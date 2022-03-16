<?php

namespace Digitalprint\Oro\Api;

use Digitalprint\Oro\Api\Endpoints\AddressEndpoint;
use Digitalprint\Oro\Api\Endpoints\AddresstypeEndpoint;
use Digitalprint\Oro\Api\Endpoints\AsyncoperationEndpoint;
use Digitalprint\Oro\Api\Endpoints\AuthorizationEndpoint;
use Digitalprint\Oro\Api\Endpoints\ProductdescriptionEndpoint;
use Digitalprint\Oro\Api\Endpoints\ProductEndpoint;
use Digitalprint\Oro\Api\Endpoints\ProductimageEndpoint;
use Digitalprint\Oro\Api\Endpoints\ProductnameEndpoint;
use Digitalprint\Oro\Api\Endpoints\ProductpriceEndpoint;
use Digitalprint\Oro\Api\Endpoints\UserEndpoint;
use Digitalprint\Oro\Api\Endpoints\UserroleEndpoint;
use Digitalprint\Oro\Api\Exceptions\ApiException;
use Digitalprint\Oro\Api\Exceptions\IncompatiblePlatform;
use Digitalprint\Oro\Api\Exceptions\UnrecognizedClientException;
use Digitalprint\Oro\Api\HttpAdapter\OroHttpAdapterInterface;
use Digitalprint\Oro\Api\HttpAdapter\OroHttpAdapterPicker;
use Digitalprint\Oro\Api\HttpAdapter\OroHttpAdapterPickerInterface;
use GuzzleHttp\ClientInterface;
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
    protected OroHttpAdapterInterface $httpClient;

    /**
     * @var string
     */
    protected string $apiEndpoint;

    protected string $user;

    /**
     * @var AuthorizationEndpoint
     */
    public AuthorizationEndpoint $authorization;

    /**
     * @var AddressEndpoint
     */
    public AddressEndpoint $addresses;

    /**
     * @var AddresstypeEndpoint
     */
    public AddresstypeEndpoint $addresstypes;

    /**
     * @var AsyncoperationEndpoint
     */
    public AsyncoperationEndpoint $asyncoperations;

    /**
     * @var ProductEndpoint
     */
    public ProductEndpoint $products;

    /**
     * @var ProductdescriptionEndpoint
     */
    public ProductdescriptionEndpoint $productdescriptions;

    /**
     * @var ProductimageEndpoint
     */
    public ProductimageEndpoint $productimages;

    /**
     * @var ProductnameEndpoint
     */
    public ProductnameEndpoint $productnames;

    /**
     * @var ProductpriceEndpoint
     */
    public ProductpriceEndpoint $productprices;

    /**
     * @var UserEndpoint
     */
    public UserEndpoint $users;

    /**
     * @var UserroleEndpoint
     */
    public UserroleEndpoint $userroles;

    /**
     * @var string|null
     */
    protected ?string $accessToken = null;

    /**
     * @var array
     */
    protected array $versionStrings = [];

    /**
     * @param ClientInterface|OroHttpAdapterInterface|null $httpClient
     * @param OroHttpAdapterPickerInterface|null $httpAdapterPicker
     * @throws IncompatiblePlatform|UnrecognizedClientException
     */
    public function __construct(OroHttpAdapterInterface|ClientInterface $httpClient = null, OroHttpAdapterPickerInterface $httpAdapterPicker = null)
    {
        $httpAdapterPicker = $httpAdapterPicker ?: new OroHttpAdapterPicker;
        $this->httpClient = $httpAdapterPicker->pickHttpAdapter($httpClient);

        $compatibilityChecker = new CompatibilityChecker;
        $compatibilityChecker->checkCompatibility();

        $this->initializeEndpoints();

        $this->addVersionString("ORO/" . self::CLIENT_VERSION);
        $this->addVersionString("PHP/" . PHP_VERSION);

        $httpClientVersionString = $this->httpClient->versionString();
        if ($httpClientVersionString) {
            $this->addVersionString($httpClientVersionString);
        }
    }

    public function initializeEndpoints(): void
    {
        $this->authorization = new AuthorizationEndpoint($this);

        $this->addresses = new AddressEndpoint($this);
        $this->addresstypes = new AddresstypeEndpoint($this);
        $this->asyncoperations = new AsyncoperationEndpoint($this);
        $this->products = new ProductEndpoint($this);
        $this->productdescriptions = new ProductdescriptionEndpoint($this);
        $this->productimages = new ProductimageEndpoint($this);
        $this->productnames = new ProductnameEndpoint($this);
        $this->productprices = new ProductpriceEndpoint($this);
        $this->users = new UserEndpoint($this);
        $this->userroles = new UserroleEndpoint($this);
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
     * @return string|null
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
        $url = $this->apiEndpoint . "/" . $apiMethod;

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
        $url = $this->apiEndpoint . "/" . $this->user . "/" . $apiMethod;

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
            'Authorization' => "Bearer $this->accessToken",
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
     * @throws UnrecognizedClientException
     */
    public function __wakeup()
    {
        $this->__construct();
    }
}
