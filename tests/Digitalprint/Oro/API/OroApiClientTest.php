<?php

namespace Tests\Digitalprint\Oro\API;

use Digitalprint\Oro\Api\Exceptions\ApiException;
use Digitalprint\Oro\Api\Exceptions\IncompatiblePlatform;
use Digitalprint\Oro\Api\Exceptions\UnrecognizedClientException;
use Digitalprint\Oro\Api\HttpAdapter\Guzzle6And7OroHttpAdapter;
use Digitalprint\Oro\Api\OroApiClient;
use Eloquent\Liberator\Liberator;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Digitalprint\Oro\TestHelpers\FakeHttpAdapter;
use function serialize;

class OroApiClientTest extends TestCase
{

    /**
     * @var ClientInterface|MockObject
     */
    private ClientInterface|MockObject $guzzleClient;

    /**
     * @var OroApiClient
     */
    private OroApiClient $oroApiClient;


    /**
     * @return void
     * @throws IncompatiblePlatform
     * @throws UnrecognizedClientException
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->guzzleClient = $this->createMock(Client::class);
        $this->oroApiClient = new OroApiClient($this->guzzleClient);

        $this->oroApiClient->setAccessToken('dbbfcb901fe22d8753841ece7466630fa14c065c52175b2b27f382602d0c2b9c7a972df75683cd8befc7abcf198bcdde6ced863305ca3a2ce49fec5130b4141b');

        $this->oroApiClient->setApiEndpoint('https://myoroproxy.local');
        $this->oroApiClient->setUser('admin');
    }

    /**
     * @return void
     * @throws ApiException
     */
    public function testPerformHttpCallReturnsBodyAsObject(): void
    {
        $response = new Response(200, [], '{"data": "products"}');

        $this->guzzleClient
            ->expects($this->once())
            ->method('send')
            ->willReturn($response);


        $parsedResponse = $this->oroApiClient->performHttpCall('GET', '');

        $this->assertEquals(
            (object)['data' => 'products'],
            $parsedResponse
        );
    }

    /**
     * @return void
     * @throws ApiException
     */
    public function testPerformHttpCallCreatesApiExceptionCorrectly(): void
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Error executing API call (422: Unprocessable Entity): Non-existent parameter "productType" for this API call. Did you mean: "productId"?');
        $this->expectExceptionCode(422);

        $response = new Response(422, [],
          '{
                      "errors": [{
                        "status": 422,
                        "title": "Unprocessable Entity",
                        "detail": "Non-existent parameter \"productType\" for this API call. Did you mean: \"productId\"?",
                        "field": "productType"
                    }]
                  }'
        );


        $this->guzzleClient
            ->expects($this->once())
            ->method('send')
            ->willReturn($response);

        try {
             $this->oroApiClient->performHttpCall('GET', '');
        } catch (ApiException $e) {
            $this->assertEquals('productType', $e->getField());
            $this->assertEquals($response, $e->getResponse());

            throw $e;
        }
    }

    /**
     * @return void
     * @throws ApiException
     */
    public function testPerformHttpCallCreatesApiExceptionWithoutField(): void
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Error executing API call (422: Unprocessable Entity): Non-existent parameter "productType" for this API call. Did you mean: "productId"?');
        $this->expectExceptionCode(422);

        $response = new Response(422, [], '{
            "errors": [{        
              "status": 422,
              "title": "Unprocessable Entity",
              "detail": "Non-existent parameter \"productType\" for this API call. Did you mean: \"productId\"?"
            }]
        }');

        $this->guzzleClient
            ->expects($this->once())
            ->method('send')
            ->willReturn($response);

        try {
            $this->oroApiClient->performHttpCall('GET', '');
        } catch (ApiException $e) {
            $this->assertNull($e->getField());
            $this->assertEquals($response, $e->getResponse());
            throw $e;
        }
    }

    /**
     * @return void
     */
    public function testCanBeSerializedAndUnserialized(): void
    {
        $this->oroApiClient->setApiEndpoint("https://myoroproxy.local");
        $serialized = serialize($this->oroApiClient);

        $this->assertStringNotContainsString('dbbfcb901fe22d8753841ece7466630fa14c065c52175b2b27f382602d0c2b9c7a972df75683cd8befc7abcf198bcdde6ced863305ca3a2ce49fec5130b4141b', $serialized, "API key should not be in serialized data or it will end up in caches.");

        /** @var OroApiClient $client_copy */
        $client_copy = Liberator::liberate(unserialize($serialized));

        $this->assertEmpty($client_copy->accessToken, "API key should not have been remembered");
        $this->assertInstanceOf(Guzzle6And7OroHttpAdapter::class, $client_copy->httpClient, "A Guzzle client should have been set.");
        $this->assertEquals("https://myoroproxy.local", $client_copy->getApiEndpoint(), "The API endpoint should be remembered");

        $this->assertNotEmpty($client_copy->products);
        // no need to assert them all.
    }

    /**
     * @return void
     * @throws ApiException
     */
    public function testResponseBodyCanBeReadMultipleTimesIfMiddlewareReadsItFirst(): void
    {
        $response = new Response(200, [], '{"data": "products"}');

        // Before the OroApiClient gets the response, some middleware reads the body first.
        $bodyAsReadFromMiddleware = (string)$response->getBody();

        $this->guzzleClient
            ->expects($this->once())
            ->method('send')
            ->willReturn($response);

        $parsedResponse = $this->oroApiClient->performHttpCall('GET', '');

        $this->assertEquals(
            '{"data": "products"}',
            $bodyAsReadFromMiddleware
        );

        $this->assertEquals(
            (object)['data' => 'products'],
            $parsedResponse
        );
    }

    /**
     * This test verifies that our request headers are correctly sent to Oro.
     * If these are broken, it could be that some payments do not work.
     *
     * @throws ApiException
     */
    public function testCorrectRequestHeaders(): void
    {
        $response = new Response(200, [], '{"data": "products"}');
        $fakeAdapter = new FakeHttpAdapter($response);

        $oroClient = new OroApiClient($fakeAdapter);
        $oroClient->setAccessToken('dbbfcb901fe22d8753841ece7466630fa14c065c52175b2b27f382602d0c2b9c7a972df75683cd8befc7abcf198bcdde6ced863305ca3a2ce49fec5130b4141b');

        $oroClient->performHttpCallToFullUrl('GET', '', '');

        $usedHeaders = $fakeAdapter->getUsedHeaders();

        # these change through environments
        # just make sure its existing
        $this->assertArrayHasKey('User-Agent', $usedHeaders);
        $this->assertArrayHasKey('X-Oro-Client-Info', $usedHeaders);

        # these should be exactly the expected values
        $this->assertEquals('Bearer dbbfcb901fe22d8753841ece7466630fa14c065c52175b2b27f382602d0c2b9c7a972df75683cd8befc7abcf198bcdde6ced863305ca3a2ce49fec5130b4141b', $usedHeaders['Authorization']);
        $this->assertEquals('application/vnd.api+json', $usedHeaders['Accept']);
    }

    /**
     * This test verifies that we do not add a Content-Type request header
     * if we do not send a BODY (skipping argument).
     * In this case it has to be skipped.
     *
     * @throws ApiException
     * @throws IncompatiblePlatform
     * @throws UnrecognizedClientException
     */
    public function testNoContentTypeWithoutProvidedBody(): void
    {
        $response = new Response(200, [], '{"data": "products"}');
        $fakeAdapter = new FakeHttpAdapter($response);

        $oroClient = new OroApiClient($fakeAdapter);
        $oroClient->setAccessToken('dbbfcb901fe22d8753841ece7466630fa14c065c52175b2b27f382602d0c2b9c7a972df75683cd8befc7abcf198bcdde6ced863305ca3a2ce49fec5130b4141b');

        $oroClient->performHttpCallToFullUrl('GET', '');

        $this->assertEquals(false, isset($fakeAdapter->getUsedHeaders()['Content-Type']));
    }
}
