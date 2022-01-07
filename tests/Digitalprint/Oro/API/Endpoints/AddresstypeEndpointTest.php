<?php

use Digitalprint\Oro\Api\Exceptions\IncompatiblePlatform;
use Digitalprint\Oro\Api\Exceptions\UnrecognizedClientException;
use Digitalprint\Oro\Api\Resources\Addresstype;
use Digitalprint\Oro\Api\Resources\AddresstypeCollection;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Tests\Digitalprint\Oro\Api\Endpoints\BaseEndpointTest;

class AddresstypeEndpointTest extends BaseEndpointTest
{

  /**
   * @return void
   * @throws IncompatiblePlatform
   * @throws UnrecognizedClientException
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
     * @return void
     * @throws IncompatiblePlatform
     * @throws UnrecognizedClientException
     */
    public function testListAdresstypes(): void
    {
        $this->mockApiCall(
            new Request(
                "GET",
                "/admin/api/addresstypes",
                [],
                ''
            ),
            new Response(
                200,
                [],
                $this->getAddresstypeCollectionResponse()
            )
        );

        $addresses = $this->apiClient->addresstypes->page();

        $this->assertInstanceOf(AddresstypeCollection::class, $addresses);

        foreach ($addresses as $address) {
            $this->assertInstanceOf(Addresstype::class, $address);
            $this->assertEquals("addresstypes", $address->type);
            $this->assertNotEmpty($address->attributes);
        }
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

    /**
     * @return string
     */
    protected function getAddresstypeCollectionResponse(): string
    {
        return '{
          "data": [
            {
              "type": "addresstypes",
              "id": "billing",
              "attributes": {
                "label": "Billing"
              }
            },
            {
              "type": "addresstypes",
              "id": "shipping",
              "attributes": {
                "label": "Shipping"
              }
            }
          ]
        }';
    }
}
