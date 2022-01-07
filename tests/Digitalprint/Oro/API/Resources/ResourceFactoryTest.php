<?php

namespace Tests\Digitalprint\Oro\Api\Resources;

use Digitalprint\Oro\Api\OroApiClient;
use Digitalprint\Oro\Api\Resources\Address;
use Digitalprint\Oro\Api\Resources\ResourceFactory;
use PHPUnit\Framework\TestCase;

class ResourceFactoryTest extends TestCase
{
    public function testCreateFromApiResponseWorks(): void
    {
        $apiResult = json_decode('{
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
          }
        }', false, 512, JSON_THROW_ON_ERROR);

        $address = ResourceFactory::createFromApiResult($apiResult->data, new Address($this->createMock(OroApiClient::class)));

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

        $relationsObject = (object)[
            "country" => (object)[
                "links" => (object)[
                    "self" => "https://myoroproxy.local/admin/api/addresses/1/relationships/country",
                    "related" => "https://myoroproxy.local/admin/api/addresses/1/country",
                ],
                "data" => (object)[
                    "type" => "countries",
                    "id" => "US",
                ],
              ],
            "region" => (object)[
                "links" => (object)[
                    "self" => "https://myoroproxy.local/admin/api/addresses/1/relationships/region",
                    "related" => "https://myoroproxy.local/admin/api/addresses/1/region",
                ],
                "data" => (object)[
                    "type" => "regions",
                    "id" => "US-NY",
               ],
            ],
        ];

        $this->assertEquals($relationsObject, $address->relationships);

    }
}
