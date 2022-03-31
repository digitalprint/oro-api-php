<?php

namespace Tests\Digitalprint\Oro\Api\Endpoints;

use Digitalprint\Oro\Api\Exceptions\ApiException;
use Digitalprint\Oro\Api\Exceptions\IncompatiblePlatform;
use Digitalprint\Oro\Api\Exceptions\UnrecognizedClientException;
use Digitalprint\Oro\Api\Resources\Addresstype;
use Digitalprint\Oro\Api\Resources\AddresstypeCollection;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

class AddresstypeEndpointTest extends BaseEndpointTest
{

    /**
     * @return void
     * @throws IncompatiblePlatform
     * @throws UnrecognizedClientException
     * @throws ApiException
     */
    public function testGetAddresstype(): void
    {
        $this->mockApiCall(
            new Request(
                "GET",
                "/admin/api/addresstypes/billing",
                [],
                ''
            ),
            new Response(
                200,
                [],
                $this->getAddresstypeResponse()
            )
        );

        $addresstype = $this->apiClient->addresstypes->get("billing");

        $this->assertAddresstype($addresstype);
    }

    /**
     * @param $addresstype
     * @return void
     */
    protected function assertAddresstype($addresstype): void
    {
        $this->assertInstanceOf(Addresstype::class, $addresstype);

        $this->assertEquals("addresstypes", $addresstype->type);
        $this->assertEquals("billing", $addresstype->id);

        $attributesObject = (object)[
            "label" => "Billing",
        ];
        $this->assertEquals($attributesObject, $addresstype->attributes);

        $linkObject = (object)["self" => "https://myoroproxy.local/admin/api/addresstypes"];
        $this->assertEquals($linkObject, $addresstype->links);
    }

    /**
     * @return string
     */
    protected function getAddresstypeResponse(): string
    {
        return '{
          "data": {
            "type": "addresstypes",
            "id": "billing",
            "links": {
              "self": "https://myoroproxy.local/admin/api/addresstypes"
            },
            "attributes": {
              "label": "Billing"
            }
          },
          "links": {
            "self": "https://myoroproxy.local/admin/api/addresstypes"
          }
        }';
    }

}
