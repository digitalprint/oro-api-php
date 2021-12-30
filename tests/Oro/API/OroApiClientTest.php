<?php

namespace Tests\Oro\Api;

use Eloquent\Liberator\Liberator;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use Oro\Api\Exceptions\ApiException;
use Oro\Api\Exceptions\IncompatiblePlatform;
use Oro\Api\Exceptions\UnrecognizedClientException;
use Oro\Api\HttpAdapter\Guzzle6And7OroHttpAdapter;
use Oro\Api\OroApiClient;
use Tests\Oro\TestHelpers\FakeHttpAdapter;

class OroApiClientTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var ClientInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $guzzleClient;

    /**
     * @var OroApiClient
     */
    private $oroApiClient;

    protected function setUp(): void
    {
        parent::setUp();

        $this->guzzleClient = $this->createMock(Client::class);
        $this->oroApiClient = new OroApiClient($this->guzzleClient);

        $this->oroApiClient->setAccessToken('test_foobarfoobarfoobarfoobarfoobar');

        $this->oroApiClient->setApiEndpoint('https://printplanet-stage.oro-cloud.com');
        $this->oroApiClient->setUser('ppbackoffice');

    }

    public function testPerformHttpCallReturnsBodyAsObject(): void
    {
        $response = new Response(200, [], '{"resource": "products"}');

        $this->guzzleClient
            ->expects($this->once())
            ->method('send')
            ->willReturn($response);


        $parsedResponse = $this->oroApiClient->performHttpCall('GET', '');

        $this->assertEquals(
            (object)['resource' => 'products'],
            $parsedResponse
        );
    }

    public function testPerformHttpCallCreatesApiExceptionCorrectly(): void
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Error executing API call (422: Unprocessable Entity): Non-existent parameter "recurringType" for this API call. Did you mean: "sequenceType"?');
        $this->expectExceptionCode(422);

        $response = new Response(422, [], '{
            "errors": [{
              "status": 422,
              "title": "Unprocessable Entity",
              "detail": "Non-existent parameter \"recurringType\" for this API call. Did you mean: \"sequenceType\"?",
              "field": "recurringType",
            }] 
        }');


        $response = new Response(422, [],
          /** @lang JSON */
          '{
                      "errors": [{
                        "status": 422,
                        "title": "Unprocessable Entity",
                        "detail": "Non-existent parameter \"recurringType\" for this API call. Did you mean: \"sequenceType\"?",
                        "field": "recurringType"
                    }]
                  }'
        );


        $this->guzzleClient
            ->expects($this->once())
            ->method('send')
            ->willReturn($response);

        try {
            $parsedResponse = $this->oroApiClient->performHttpCall('GET', '');
        } catch (ApiException $e) {
            $this->assertEquals('recurringType', $e->getField());
            $this->assertEquals($response, $e->getResponse());

            throw $e;
        }
    }

    public function testPerformHttpCallCreatesApiExceptionWithoutField(): void
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Error executing API call (422: Unprocessable Entity): Non-existent parameter "recurringType" for this API call. Did you mean: "sequenceType"?');
        $this->expectExceptionCode(422);

        $response = new Response(422, [], '{
            "errors": [{        
              "status": 422,
              "title": "Unprocessable Entity",
              "detail": "Non-existent parameter \"recurringType\" for this API call. Did you mean: \"sequenceType\"?"
            }]
        }');

        $this->guzzleClient
            ->expects($this->once())
            ->method('send')
            ->willReturn($response);

        try {
            $parsedResponse = $this->oroApiClient->performHttpCall('GET', '');
        } catch (ApiException $e) {
            $this->assertNull($e->getField());
            $this->assertEquals($response, $e->getResponse());
            throw $e;
        }
    }

    public function testCanBeSerializedAndUnserialized(): void
    {
        $this->oroApiClient->setApiEndpoint("https://myoroproxy.local");
        $serialized = \serialize($this->oroApiClient);

        $this->assertStringNotContainsString('test_foobarfoobarfoobarfoobarfoobar', $serialized, "API key should not be in serialized data or it will end up in caches.");

        /** @var OroApiClient $client_copy */
        $client_copy = Liberator::liberate(unserialize($serialized));

        $this->assertEmpty($client_copy->accessToken, "API key should not have been remembered");
        $this->assertInstanceOf(Guzzle6And7OroHttpAdapter::class, $client_copy->httpClient, "A Guzzle client should have been set.");
        $this->assertEquals("https://myoroproxy.local", $client_copy->getApiEndpoint(), "The API endpoint should be remembered");

        $this->assertNotEmpty($client_copy->products);
        // no need to assert them all.
    }

    public function testResponseBodyCanBeReadMultipleTimesIfMiddlewareReadsItFirst(): void
    {
        $response = new Response(200, [], '{"resource": "payment"}');

        // Before the OroApiClient gets the response, some middleware reads the body first.
        $bodyAsReadFromMiddleware = (string)$response->getBody();

        $this->guzzleClient
            ->expects($this->once())
            ->method('send')
            ->willReturn($response);

        $parsedResponse = $this->oroApiClient->performHttpCall('GET', '');

        $this->assertEquals(
            '{"resource": "payment"}',
            $bodyAsReadFromMiddleware
        );

        $this->assertEquals(
            (object)['resource' => 'payment'],
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
        $response = new Response(200, [], '{"resource": "payment"}');
        $fakeAdapter = new FakeHttpAdapter($response);

        $oroClient = new OroApiClient($fakeAdapter);
        $oroClient->setAccessToken('test_foobarfoobarfoobarfoobarfoobar');

        $oroClient->performHttpCallToFullUrl('GET', '', '');

        $usedHeaders = $fakeAdapter->getUsedHeaders();

        # these change through environments
        # just make sure its existing
        $this->assertArrayHasKey('User-Agent', $usedHeaders);
        $this->assertArrayHasKey('X-Oro-Client-Info', $usedHeaders);

        # these should be exactly the expected values
        $this->assertEquals('Bearer test_foobarfoobarfoobarfoobarfoobar', $usedHeaders['Authorization']);
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
        $response = new Response(200, [], '{"resource": "payment"}');
        $fakeAdapter = new FakeHttpAdapter($response);

        $oroClient = new OroApiClient($fakeAdapter);
        $oroClient->setAccessToken('test_foobarfoobarfoobarfoobarfoobar');

        $oroClient->performHttpCallToFullUrl('GET', '');

        $this->assertEquals(false, isset($fakeAdapter->getUsedHeaders()['Content-Type']));
    }
}
