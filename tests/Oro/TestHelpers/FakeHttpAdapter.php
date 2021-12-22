<?php

namespace Tests\Oro\TestHelpers;

use Oro\Api\HttpAdapter\OroHttpAdapterInterface;
use Psr\Http\Message\ResponseInterface;
use stdClass;

class FakeHttpAdapter implements OroHttpAdapterInterface
{

    /**
     * @var stdClass|null
     */
    private $response;

    /**
     * @var string
     */
    private $usedMethod;

    /**
     * @var string
     */
    private $usedUrl;

    /**
     * @var string
     */
    private $usedHeaders;

    /**
     * @var string
     */
    private $usedBody;


    /**
     * FakeHttpAdapter constructor.
     * @param $response
     */
    public function __construct($response)
    {
        $this->response = $response;
    }

    /**
     * @param $httpMethod
     * @param $url
     * @param $headers
     * @param $httpBody
     * @return stdClass
     */
    public function send($httpMethod, $url, $headers, $httpBody): stdClass
    {
        $this->usedMethod = $httpMethod;
        $this->usedUrl = $url;
        $this->usedHeaders = $headers;
        $this->usedBody = $httpBody;

        return $this->parseResponseBody($this->response);
    }

    /**
     * @return string
     */
    public function versionString(): string
    {
        return 'fake';
    }

    /**
     * @return mixed
     */
    public function getUsedMethod(): mixed
    {
        return $this->usedMethod;
    }

    /**
     * @return mixed
     */
    public function getUsedUrl(): mixed
    {
        return $this->usedUrl;
    }

    /**
     * @return mixed
     */
    public function getUsedHeaders(): mixed
    {
        return $this->usedHeaders;
    }

    /**
     * @return mixed
     */
    public function getUsedBody(): mixed
    {
        return $this->usedBody;
    }

    /**
     * Parse the PSR-7 Response body
     *
     * @param ResponseInterface $response
     * @return stdClass|null
     */
    private function parseResponseBody(ResponseInterface $response): ?stdClass
    {
        $body = (string) $response->getBody();

        return @json_decode($body, false);
    }
}
