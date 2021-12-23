<?php

namespace Oro\Api;

use GuzzleHttp\ClientInterface;
use Oro\Api\Endpoints\AsyncoperationEndpoint;
use Oro\Api\Endpoints\AuthorizationEndpoint;
use Oro\Api\Endpoints\AddresstypeEndpoint;
use Oro\Api\Endpoints\ProductEndpoint;
use Oro\Api\Endpoints\ProductpricesEndpoint;
use Oro\Api\Exceptions\ApiException;
use Oro\Api\Exceptions\IncompatiblePlatform;
use Oro\Api\Exceptions\UnrecognizedClientException;
use Oro\Api\HttpAdapter\OroHttpAdapterInterface;
use Oro\Api\HttpAdapter\OroHttpAdapterPicker;
use Oro\Api\HttpAdapter\OroHttpAdapterPickerInterface;
use stdClass;

class OroApiClient
{
    /**
     * Version of our client.
     */
    public const CLIENT_VERSION = "1.0.0";

    /**
     * HTTP Methods
     */
    public const HTTP_GET = "GET";
    public const HTTP_POST = "POST";
    public const HTTP_DELETE = "DELETE";
    public const HTTP_PATCH = "PATCH";

    /**
     * @var OroHttpAdapterInterface
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $apiEndpoint = null;

    protected $user = null;

    public $authorization;

    public $asyncoperations;
    public $products;
    public $productprices;
    public $addresstypes;

    protected $accessToken;

    /**
     * @var array
     */
    protected $versionStrings = [];

    /**
     * @param ClientInterface|OroHttpAdapterInterface|null $httpClient
     * @param OroHttpAdapterPickerInterface|null $httpAdapterPicker
     * @throws IncompatiblePlatform|UnrecognizedClientException
     */
    public function __construct($httpClient = null, OroHttpAdapterPickerInterface $httpAdapterPicker = null)
    {
        $httpAdapterPicker = $httpAdapterPicker ?: new OroHttpAdapterPicker;
        $this->httpClient = $httpAdapterPicker->pickHttpAdapter($httpClient);

        $compatibilityChecker = new CompatibilityChecker;
        $compatibilityChecker->checkCompatibility();

        $this->initializeEndpoints();

        $this->addVersionString("ORO/" . self::CLIENT_VERSION);
        $this->addVersionString("PHP/" . phpversion());

        $httpClientVersionString = $this->httpClient->versionString();
        if ($httpClientVersionString) {
            $this->addVersionString($httpClientVersionString);
        }
    }

    public function initializeEndpoints(): void
    {
        $this->authorization = new AuthorizationEndpoint($this);
        $this->asyncoperations = new AsyncoperationEndpoint($this);
        $this->products = new ProductEndpoint($this);
        $this->productprices = new ProductpricesEndpoint($this);
        $this->addresstypes = new AddresstypeEndpoint($this);
    }

    /**
     * @param string $url
     *
     * @return OroApiClient
     */
    public function setApiEndpoint(string $url): OroApiClient
    {
        $this->apiEndpoint = rtrim(trim($url), '/');

        return $this;
    }

    /**
     * @return string
     */
    public function getApiEndpoint(): ?string
    {
        return $this->apiEndpoint;
    }

    /*
     * @param string $user
     *
     * @return OroApiClient
     */
    public function setUser(string $user): OroApiClient
    {
        $this->user = trim($user);

        return $this;
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @return array
     */
    public function getVersionStrings(): array
    {
        return $this->versionStrings;
    }

    /*
     * @param string accessToken
     *
     * @return OroApiClient
     */
    public function setAccessToken(string $accessToken): OroApiClient
    {
        $this->accessToken = trim($accessToken);

        return $this;
    }

    /**
     * @param string $versionString
     *
     * @return OroApiClient
     */
    public function addVersionString(string $versionString): OroApiClient
    {
        $this->versionStrings[] = str_replace([" ", "\t", "\n", "\r"], '-', $versionString);

        return $this;
    }

    /**
     *
     * @param string $httpMethod
     * @param string $apiMethod
     * @param string|null $httpBody
     *
     * @return stdClass
     * @throws ApiException
     *
     * @codeCoverageIgnore
     */
    public function performHttpCallAuthorization(string $httpMethod, string $apiMethod, string $httpBody = null): stdClass
    {
        $url = "{$this->apiEndpoint}/{$apiMethod}";

        $userAgent = implode(' ', $this->versionStrings);

        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => "application/json",
            'User-Agent' => $userAgent,
        ];

        return $this->httpClient->send($httpMethod, $url, $headers, $httpBody);
    }

    /**
     * Perform an http call. This method is used by the resource specific classes.
     *
     * @param string $httpMethod
     * @param string $apiMethod
     * @param string|null $httpBody
     *
     * @return stdClass|null
     * @throws ApiException
     *
     * @codeCoverageIgnore
     */
    public function performHttpCall(string $httpMethod, string $apiMethod, string $httpBody = null): ?stdClass
    {
        $url = "{$this->apiEndpoint}/{$this->user}/{$apiMethod}";

        return $this->performHttpCallToFullUrl($httpMethod, $url, $httpBody);
    }

    /**
     * Perform a http call to a full url. This method is used by the resource specific classes.
     *
     * @param string $httpMethod
     * @param string $url
     * @param string|null $httpBody
     *
     * @return stdClass|null
     * @throws ApiException
     *
     * @codeCoverageIgnore
     */
    public function performHttpCallToFullUrl(string $httpMethod, string $url, string $httpBody = null): ?stdClass
    {
        if (empty($this->accessToken)) {
            throw new ApiException("You have not set an OAuth access token.");
        }

        $userAgent = implode(' ', $this->versionStrings) . " OAuth/2.0";

        $headers = [
            'Accept' => "application/vnd.api+json",
            'Authorization' => "Bearer {$this->accessToken}",
            'User-Agent' => $userAgent,
        ];

        if ($httpMethod === 'GET') {
            $headers['X-Include'] = 'totalCount';
        } elseif ($httpMethod === 'DELETE') {
            $headers['X-Include'] = 'totalCount;deletedCount';
        }

        if ($httpBody !== null) {
            $headers['Content-Type'] = "application/vnd.api+json";
        }

        if (function_exists("php_uname")) {
            $headers['X-Oro-Client-Info'] = php_uname();
        }

        return $this->httpClient->send($httpMethod, $url, $headers, $httpBody);
    }

    /**
     * Serialization can be used for caching. Of course doing so can be dangerous but some like to live dangerously.
     *
     * \serialize() should be called on the collections or object you want to cache.
     *
     * We don't need any property that can be set by the constructor, only properties that are set by setters.
     *
     * Note that the API key is not serialized, so you need to set the key again after unserializing if you want to do
     * more API calls.
     *
     * @deprecated
     * @return string[]
     */
    public function __sleep()
    {
        return ["apiEndpoint"];
    }

    /**
     * When unserializing a collection or a resource, this class should restore itself.
     *
     * Note that if you have set an HttpAdapter, this adapter is lost on wakeup and reset to the default one.
     *
     * @throws IncompatiblePlatform If suddenly unserialized on an incompatible platform.
     */
    public function __wakeup()
    {
        $this->__construct();
    }
}
