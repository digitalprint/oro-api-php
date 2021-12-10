<?php

namespace Tests\Oro\TestHelpers;

use Oro\Api\HttpAdapter\MollieHttpAdapterInterface;

class FakeHttpAdapter implements OroHttpAdapterInterface
{

    /**
     * @var \stdClass|null
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
     * @return \stdClass|void|null
     */
    public function send($httpMethod, $url, $headers, $httpBody)
    {
        $this->usedMethod = $httpMethod;
        $this->usedUrl = $url;
        $this->usedHeaders = $headers;
        $this->usedBody = $httpBody;

        return $this->response;
    }

    /**
     * @return string
     */
    public function versionString()
    {
        return 'fake';
    }

    /**
     * @return mixed
     */
    public function getUsedMethod()
    {
        return $this->usedMethod;
    }

    /**
     * @return mixed
     */
    public function getUsedUrl()
    {
        return $this->usedUrl;
    }

    /**
     * @return mixed
     */
    public function getUsedHeaders()
    {
        return $this->usedHeaders;
    }

    /**
     * @return mixed
     */
    public function getUsedBody()
    {
        return $this->usedBody;
    }
}
