<?php

use Digitalprint\Oro\Api\Exceptions\IncompatiblePlatform;
use Digitalprint\Oro\Api\Exceptions\UnrecognizedClientException;
use Digitalprint\Oro\Api\Resources\Asyncoperation;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Tests\Digitalprint\Oro\Api\Endpoints\BaseEndpointTest;

class AsyncoperationEndpointTest extends BaseEndpointTest
{

  /**
   * @return void
   * @throws IncompatiblePlatform
   * @throws UnrecognizedClientException
   */
    public function testGetAsyncoperation(): void
    {
        $this->mockApiCall(
            new Request(
                "GET",
                "/admin/api/asyncoperations/1",
                [],
                ''
            ),
            new Response(
                200,
                [],
                $this->getAsyncoperationResponse()
            )
        );

        $asyncoperation = $this->apiClient->asyncoperations->get(1);

        $this->assertInstanceOf(Asyncoperation::class, $asyncoperation);

        $this->assertEquals("asyncoperations", $asyncoperation->type);
        $this->assertEquals("1", $asyncoperation->id);

        $attributesObject = (object)[
            "status" => "success",
            "progress" => 1,
            "createdAt" => "2021-12-22T14:17:47Z",
            "updatedAt" => "2021-12-22T14:17:47Z",
            "elapsedTime" => 0,
            "entityType" => "products",
            "summary" => (object)[
                "aggregateTime" => 299,
                "readCount" => 0,
                "writeCount" => 0,
                "errorCount" => 0,
                "createCount" => 0,
                "updateCount" => 0,
            ],
        ];
        $this->assertEquals($attributesObject, $asyncoperation->attributes);

        $relationshipsOwnerObject = (object)[
            "data" => (object)[
                "type" => "users",
                 "id" => "1",
            ],
        ];
        $this->assertEquals($relationshipsOwnerObject, $asyncoperation->relationships->owner);
    }

    /**
     * @return string
     */
    protected function getAsyncoperationResponse(): string
    {
        return '{
          "data": {
            "type": "asyncoperations",
            "id": "1",
            "attributes": {
              "status": "success",
              "progress": 1,
              "createdAt": "2021-12-22T14:17:47Z",
              "updatedAt": "2021-12-22T14:17:47Z",
              "elapsedTime": 0,
              "entityType": "products",
              "summary": {
                "aggregateTime": 299,
                "readCount": 0,
                "writeCount": 0,
                "errorCount": 0,
                "createCount": 0,
                "updateCount": 0
              }
            },
            "relationships": {
              "owner": {
                "data": {
                  "type": "users",
                  "id": "1"
                }
              },
              "organization": {
                "data": {
                  "type": "organizations",
                  "id": "1"
                }
              }
            }
          }
        }';
    }
}
