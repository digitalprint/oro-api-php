<?php

namespace Oro\Api;

use Oro\Api\Endpoints\AuthorizationEndpoint;
use Oro\Api\Endpoints\ProductEndpoint;
use Oro\Api\Exceptions\ApiException;
use Oro\Api\Exceptions\IncompatiblePlatform;
use Oro\Api\HttpAdapter\OroHttpAdapterPicker;

class OroApiClient
{
    /**
     * Version of our client.
     */
    const CLIENT_VERSION = "1.0.0";

    /**
     * HTTP Methods
     */
    const HTTP_GET = "GET";
    const HTTP_POST = "POST";
    const HTTP_DELETE = "DELETE";
    const HTTP_PATCH = "PATCH";

    /**
     * @var \Oro\Api\HttpAdapter\OroHttpAdapterInterface
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $apiEndpoint = null;

    public $authorization;

    protected $accessToken;

    /**
     * @var array
     */
    protected $versionStrings = [];

    /**
     * @param \GuzzleHttp\ClientInterface|\Oro\Api\HttpAdapter\OroHttpAdapterInterface|null $httpClient
     * @param \Oro\Api\HttpAdapter\OroHttpAdapterPickerInterface|null $httpAdapterPicker
     * @throws \Oro\Api\Exceptions\IncompatiblePlatform|\Oro\Api\Exceptions\UnrecognizedClientException
     */
    public function __construct($httpClient = null, $httpAdapterPicker = null)
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

    public function initializeEndpoints()
    {
        $this->authorization = new AuthorizationEndpoint($this);
    }

    /**
     * @param string $url
     *
     * @return OroApiClient
     */
    public function setApiEndpoint($url)
    {
        $this->apiEndpoint = rtrim(trim($url), '/');
        return $this;
    }

    /**
     * @return string
     */
    public function getApiEndpoint()
    {
        return $this->apiEndpoint;
    }

    /**
     * @return array
     */
    public function getVersionStrings()
    {
        return $this->versionStrings;
    }

    public function setAccessToken($accessToken)
    {
        $this->accessToken = trim($accessToken);
        return $this;
    }

    /**
     * @param string $versionString
     *
     * @return OroApiClient
     */
    public function addVersionString($versionString)
    {
        $this->versionStrings[] = str_replace([" ", "\t", "\n", "\r"], '-', $versionString);
        return $this;
    }

    /**
     *
     * @param string $httpMethod
     * @param string $url
     * @param string|null $httpBody
     *
     * @return \stdClass|null
     * @throws ApiException
     *
     * @codeCoverageIgnore
     */
    public function performHttpCallAuthorization($httpMethod, $apiMethod, $httpBody = null) {

        $url = $this->apiEndpoint . "/" . $apiMethod;

        $userAgent = implode(' ', $this->versionStrings);

        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => "application/json",
            'User-Agent' => $userAgent
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
     * @return \stdClass
     * @throws ApiException
     *
     * @codeCoverageIgnore
     */
    public function performHttpCall($httpMethod, $apiMethod, $httpBody = null)
    {
        $url = $this->apiEndpoint . "/" . $apiMethod;
        return $this->performHttpCallToFullUrl($httpMethod, $url, $httpBody);
    }

    /**
     * Perform an http call to a full url. This method is used by the resource specific classes.
     *
     * @see $payments
     * @see $isuers
     *
     * @param string $httpMethod
     * @param string $url
     * @param string|null $httpBody
     *
     * @return \stdClass|null
     * @throws ApiException
     *
     * @codeCoverageIgnore
     */
    public function performHttpCallToFullUrl($httpMethod, $url, $httpBody = null)
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

        if ($httpBody !== null) {
            $headers['Content-Type'] = "application/json";
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
