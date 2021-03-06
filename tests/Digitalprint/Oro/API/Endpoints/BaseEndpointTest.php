<?php

namespace Tests\Digitalprint\Oro\API\Endpoints;

use Digitalprint\Oro\Api\Exceptions\IncompatiblePlatform;
use Digitalprint\Oro\Api\Exceptions\UnrecognizedClientException;
use Digitalprint\Oro\Api\OroApiClient;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

abstract class BaseEndpointTest extends TestCase
{
    /**
     * @var Client|MockObject
     */
    protected Client|MockObject $guzzleClient;

    /**
     * @var OroApiClient
     */
    protected OroApiClient $apiClient;

    /**
     * @param Request $expectedRequest
     * @param Response $response
     * @return void
     * @throws IncompatiblePlatform
     * @throws UnrecognizedClientException
     */
    protected function mockApiCall(Request $expectedRequest, Response $response)
    {
        $this->guzzleClient = $this->createMock(Client::class);

        $this->apiClient = new OroApiClient($this->guzzleClient);

        $this->apiClient->setAccessToken("access_Wwvu7egPcJLLJ9Kb7J632x8wJ2zMeJ");
        $this->apiClient->setApiEndpoint('https://myoroproxy.local');
        $this->apiClient->setUser('admin');

        $this->guzzleClient
            ->expects($this->once())
            ->method('send')
            ->with($this->isInstanceOf(Request::class))
            ->willReturnCallback(function (Request $request) use ($expectedRequest, $response) {
                $this->assertEquals($expectedRequest->getMethod(), $request->getMethod(), "HTTP method must be identical");

                $this->assertEquals(
                    $expectedRequest->getUri()->getPath(),
                    $request->getUri()->getPath(),
                    "URI path must be identical"
                );

                $this->assertEquals(
                    $expectedRequest->getUri()->getQuery(),
                    $request->getUri()->getQuery(),
                    'Query string parameters must be identical'
                );

                $requestBody = $request->getBody()->getContents();
                $expectedBody = $expectedRequest->getBody()->getContents();

                if ($expectedBody !== '' && $requestBody !== '') {
                    $this->assertJsonStringEqualsJsonString(
                        $expectedBody,
                        $requestBody,
                        "HTTP body must be identical"
                    );
                }

                return $response;
            });
    }

    /**
     * @param $array
     * @param $object
     * @return mixed
     */
    protected function copy($array, $object): mixed
    {
        foreach ($array as $property => $value) {
            $object->$property = $value;
        }

        return $object;
    }
}
