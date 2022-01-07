<?php

use Digitalprint\Oro\Api\Exceptions\IncompatiblePlatform;
use Digitalprint\Oro\Api\Exceptions\UnrecognizedClientException;
use Digitalprint\Oro\Api\Resources\Address;
use Digitalprint\Oro\Api\Resources\AddressCollection;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Tests\Digitalprint\Oro\Api\Endpoints\BaseEndpointTest;

class AddressEndpointTest extends BaseEndpointTest
{

  /**
   * @return void
   * @throws IncompatiblePlatform
   * @throws UnrecognizedClientException
   */
    public function testCreateAddress(): void
    {
        $this->mockApiCall(
            new Request(
                "POST",
                "/admin/api/addresses",
                [],
                '{
                  "data": {
                    "type": "addresses",
                    "attributes": {
                      "label": "Home",
                      "street": "1475 Harigun Drive",
                      "city": "Dallas",
                      "postalCode": "04759",
                      "organization": "Dallas Nugets",
                      "namePrefix": "Mr.",
                      "firstName": "Jerry",
                      "middleName": "August",
                      "lastName": "Coleman",
                      "nameSuffix": "d\'"
                    },
                    "relationships": {
                      "country": {
                        "data": {
                          "type": "countries",
                          "id": "US"
                        }
                      },
                      "region": {
                        "data": {
                          "type": "regions",
                          "id": "US-NY"
                        }
                      }
                    }
                  }
                }'
            ),
            new Response(
                201,
                [],
                $this->getAddressResponse()
            )
        );

        $address = $this->apiClient->addresses->create([
          'data' => [
            'type' => 'addresses',
            'attributes' => [
              'label' => 'Home',
              'street' => '1475 Harigun Drive',
              'city' => 'Dallas',
              'postalCode' => '04759',
              'organization' => 'Dallas Nugets',
              'namePrefix' => 'Mr.',
              'firstName' => 'Jerry',
              'middleName' => 'August',
              'lastName' => 'Coleman',
              'nameSuffix' => 'd\'',
            ],
            'relationships' => [
              'country' => [
                'data' => [
                  'type' => 'countries',
                  'id' => 'US',
                ],
              ],
              'region' => [
                'data' => [
                  'type' => 'regions',
                  'id' => 'US-NY',
                ],
              ],
            ],
          ],
        ]);

        $this->assertAddress($address);
    }

    /**
     * @return void
     * @throws IncompatiblePlatform
     * @throws UnrecognizedClientException
     */
    public function testUpdateAddress(): void
    {
        $this->mockApiCall(
            new Request(
                "PATCH",
                "/admin/api/addresses",
                [],
                '{
                  "data": {
                    "meta": {
                      "update": true
                    },
                    "type": "addresses",
                    "id": "1",
                    "attributes": {
                      "city": "Dallas"
                    }
                  }
                }'
            ),
            new Response(
                200,
                [],
                $this->getAddressResponse()
            )
        );

        $address = $this->apiClient->addresses->update([
          'data' => [
            'meta' => [
              'update' => true,
            ],
            'type' => 'addresses',
            'id' => "1",
            'attributes' => [
              'city' => 'Dallas',
            ],
          ],
        ]);

        $this->assertAddress($address);
    }

    /**
     * @return void
     * @throws IncompatiblePlatform
     * @throws UnrecognizedClientException
     */
    public function testGetAddress(): void
    {
        $this->mockApiCall(
            new Request(
                "GET",
                "/admin/api/addresses/1",
                [],
                ''
            ),
            new Response(
                200,
                [],
                $this->getAddressResponse()
            )
        );

        $address = $this->apiClient->addresses->get("1");

        $this->assertAddress($address);
    }

    /**
     * @return void
     * @throws IncompatiblePlatform
     * @throws UnrecognizedClientException
     */
    public function testListAddress(): void
    {
        $this->mockApiCall(
            new Request(
                "GET",
                "/admin/api/addresses",
                [],
                ''
            ),
            new Response(
                200,
                [],
                $this->getAddressCollectionResponse()
            )
        );

        $addresses = $this->apiClient->addresses->page();

        $this->assertInstanceOf(AddressCollection::class, $addresses);

        foreach ($addresses as $address) {
            $this->assertInstanceOf(Address::class, $address);
            $this->assertEquals("addresses", $address->type);
            $this->assertNotEmpty($address->attributes);
        }

        $linksObject = (object)[
            "self" => "https://myoroproxy.local/admin/api/addresses",
            "first" => "https://myoroproxy.local/admin/api/addresses?page%5Bsize%5D=1&sort=id",
            "prev" => "https://myoroproxy.local/admin/api/addresses?page%5Bsize%5D=1&sort=id",
            "next" => "https://myoroproxy.local/admin/api/addresses?page%5Bnumber%5D=2&page%5Bsize%5D=1&sort=id",
        ];
        $this->assertEquals($linksObject, $addresses->links);
    }

    /**
     * @return void
     * @throws IncompatiblePlatform
     * @throws UnrecognizedClientException
     */
    public function testDeleteAddress(): void
    {
        $this->mockApiCall(
            new Request(
                "DELETE",
                "/admin/api/addresses?filter%5Bid%5D=1",
                [],
                '{}'
            ),
            new Response(204)
        );

        $result = $this->apiClient->addresses->delete(['id' => '1']);
        $this->assertNull($result);
    }

    /**
     * @param $address
     * @return void
     */
    protected function assertAddress($address): void
    {
        $this->assertInstanceOf(Address::class, $address);

        $this->assertEquals("addresses", $address->type);
        $this->assertEquals("1", $address->id);

        $attributesObject = (object)[
            "label" => "Home",
            "street" => "1475 Harigun Drive",
            "street2" => null,
            "city" => "Dallas",
            "postalCode" => "04759",
            "organization" => "Dallas Nugets",
            "customRegion" => null,
            "namePrefix" => "Mr.",
            "firstName" => "Jerry",
            "middleName" => "August",
            "lastName" => "Coleman",
            "nameSuffix" => "d'",
            "createdAt" => "2021-12-23T16:00:52Z",
            "updatedAt" => "2021-12-23T16:24:18Z",
        ];
        $this->assertEquals($attributesObject, $address->attributes);

        $linkObject = (object)["self" => "https://myoroproxy.local/admin/api/addresses/1"];
        $this->assertEquals($linkObject, $address->links);

        $relationshipsCountryObject = (object)[
          "links" => (object)[
            "self" => "https://myoroproxy.local/admin/api/addresses/1/relationships/country",
            "related" => "https://myoroproxy.local/admin/api/addresses/1/country",
          ],
          "data" => (object)[
            "type" => "countries",
            "id" => "US",
          ],
        ];
        $this->assertEquals($relationshipsCountryObject, $address->relationships->country);
    }

    /**
     * @return string
     */
    protected function getAddressResponse(): string
    {
        return '{
          "data": {
            "type": "addresses",
            "id": "1",
            "links": {
              "self": "https://myoroproxy.local/admin/api/addresses/1"
            },
            "attributes": {
              "label": "Home",
              "street": "1475 Harigun Drive",
              "street2": null,
              "city": "Dallas",
              "postalCode": "04759",
              "organization": "Dallas Nugets",
              "customRegion": null,
              "namePrefix": "Mr.",
              "firstName": "Jerry",
              "middleName": "August",
              "lastName": "Coleman",
              "nameSuffix": "d\'",
              "createdAt": "2021-12-23T16:00:52Z",
              "updatedAt": "2021-12-23T16:24:18Z"
            },
            "relationships": {
              "country": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/addresses/1/relationships/country",
                  "related": "https://myoroproxy.local/admin/api/addresses/1/country"
                },
                "data": {
                  "type": "countries",
                  "id": "US"
                }
              },
              "region": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/addresses/1/relationships/region",
                  "related": "https://myoroproxy.local/admin/api/addresses/1/region"
                },
                "data": {
                  "type": "regions",
                  "id": "US-NY"
                }
              }
            }
          },
          "links": {
            "self": "https://myoroproxy.local/admin/api/addresses/1"
          }
        }';
    }

    /**
     * @return string
     */
    protected function getAddressCollectionResponse(): string
    {
        return '{
          "data": [
            {
              "type": "addresses",
              "id": "1",
              "links": {
                "self": "https://myoroproxy.local/admin/apiaddresses/1"
              },
              "attributes": {
                "label": "Home",
                "street": "1475 Harigun Drive",
                "street2": null,
                "city": "Dallas",
                "postalCode": "04759",
                "organization": "Dallas Nugets",
                "customRegion": null,
                "namePrefix": "Mr.",
                "firstName": "Jerry",
                "middleName": "August",
                "lastName": "Coleman",
                "nameSuffix": "d\'",
                "createdAt": "2021-12-23T16:00:52Z",
                "updatedAt": "2021-12-23T16:24:18Z"
              },
              "relationships": {
                "country": {
                  "links": {
                    "self": "https://myoroproxy.local/admin/api/addresses/1/relationships/country",
                    "related": "https://myoroproxy.local/admin/api/addresses/1/country"
                  },
                  "data": {
                    "type": "countries",
                    "id": "US"
                  }
                },
                "region": {
                  "links": {
                    "self": "https://myoroproxy.local/admin/apiaddresses/1/relationships/region",
                    "related": "https://myoroproxy.local/admin/api/addresses/1/region"
                  },
                  "data": {
                    "type": "regions",
                    "id": "US-NY"
                  }
                }
              }
            }
          ],
          "links": {
            "self": "https://myoroproxy.local/admin/api/addresses",
            "first": "https://myoroproxy.local/admin/api/addresses?page%5Bsize%5D=1&sort=id",
            "prev": "https://myoroproxy.local/admin/api/addresses?page%5Bsize%5D=1&sort=id",
            "next": "https://myoroproxy.local/admin/api/addresses?page%5Bnumber%5D=2&page%5Bsize%5D=1&sort=id"            
          }
        }';
    }
}
