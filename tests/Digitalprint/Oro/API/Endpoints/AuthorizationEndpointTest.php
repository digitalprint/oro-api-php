<?php

namespace Tests\Digitalprint\Oro\Api\Endpoints;

use Digitalprint\Oro\Api\Exceptions\ApiException;
use Digitalprint\Oro\Api\Exceptions\IncompatiblePlatform;
use Digitalprint\Oro\Api\Exceptions\UnrecognizedClientException;
use Digitalprint\Oro\Api\Resources\Authorization;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use JsonException;

class AuthorizationEndpointTest extends BaseEndpointTest
{
    /**
     * @return void
     * @throws IncompatiblePlatform
     * @throws UnrecognizedClientException
     * @throws ApiException
     * @throws JsonException
     */
    public function testCreateAcesstoken(): void
    {
        $this->mockApiCall(
            new Request(
                "POST",
                "/oauth2-token",
                [],
                '{
                  "client_id": "2bfe9d72a4aae8f06a31025b7536be80",
                  "client_secret": "42ebd50f8420774e7d51a75f4506be3669a5a6b0429ebe0528b7bd588d62d830e54d9bfa40bfff36b0ef480634e1be104b732f8268c13b097ce8815c20692bb5",
                  "grant_type": "client_credentials"                
                }'
            ),
            new Response(
                201,
                [],
                '{
                  "access_token": "dbbfcb901fe22d8753841ece7466630fa14c065c52175b2b27f382602d0c2b9c7a972df75683cd8befc7abcf198bcdde6ced863305ca3a2ce49fec5130b4141b"
                }'
            )
        );

        $authorization = $this->apiClient->authorization->create([
            'client_id' => '2bfe9d72a4aae8f06a31025b7536be80',
            'client_secret' => '42ebd50f8420774e7d51a75f4506be3669a5a6b0429ebe0528b7bd588d62d830e54d9bfa40bfff36b0ef480634e1be104b732f8268c13b097ce8815c20692bb5',
        ]);

        $this->assertInstanceOf(Authorization::class, $authorization);

        $this->assertEquals("dbbfcb901fe22d8753841ece7466630fa14c065c52175b2b27f382602d0c2b9c7a972df75683cd8befc7abcf198bcdde6ced863305ca3a2ce49fec5130b4141b", $authorization->access_token);
    }
}
