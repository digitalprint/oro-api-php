<?php

namespace Tests\Digitalprint\Oro\Api\Endpoints;

use Digitalprint\Oro\Api\Exceptions\ApiException;
use Digitalprint\Oro\Api\Exceptions\IncompatiblePlatform;
use Digitalprint\Oro\Api\Exceptions\UnrecognizedClientException;
use Digitalprint\Oro\Api\Resources\Customerproductvisibility;
use Digitalprint\Oro\Api\Resources\CustomerproductvisibilityCollection;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use JsonException;

class CustomerproductvisibilityEndpointTest extends BaseEndpointTest
{

    /**
     * @return void
     * @throws ApiException
     * @throws IncompatiblePlatform
     * @throws UnrecognizedClientException
     * @throws JsonException
     */
    public function testCreatCustomerproductvisibility(): void
    {
        $this->mockApiCall(
            new Request(
                "POST",
                "/admin/api/customerproductvisibilities",
                [],
                '{
                  "data": {
                    "type": "customerproductvisibilities",    
                    "attributes": { 
                      "visibility": "visible"
                    },
                    "relationships": {
                      "product": {
                        "data": {
                          "type": "products",
                          "id": "1"
                        }
                      },
                      "customer": {
                        "data": {
                          "type": "customers",
                          "id": "1"
                        }
                      },
                      "website": {
                        "data": {
                          "type": "websites",
                          "id": "1"
                        }
                      }
                    }
                  }
                }'
            ),
            new Response(
                201,
                [],
                $this->getCustomerproductvisibilityResponse()
            )
        );

        $customerproductvisibility = $this->apiClient->customerproductvisibilities->create([
            'data' => [
                'type' => 'customerproductvisibilities',
                'attributes' => [
                    'visibility' => 'visible',
                ],
                'relationships' => [
                    'product' => [
                        'data' => [
                            'type' => 'products',
                            'id' => '1',
                        ],
                    ],
                    'customer' => [
                        'data' => [
                            'type' => 'customers',
                            'id' => '1',
                        ],
                    ],
                    'website' => [
                        'data' => [
                            'type' => 'websites',
                            'id' => '1',
                        ],
                    ],
                ],
            ],
        ]);

        $this->assertCustomerproductvisibility($customerproductvisibility);
    }

    /**
     * @return void
     * @throws ApiException
     * @throws IncompatiblePlatform
     * @throws JsonException
     * @throws UnrecognizedClientException
     */
    public function testUpdateCustomerproductvisibility(): void
    {
        $this->mockApiCall(
            new Request(
                "PATCH",
                "/admin/api/customerproductvisibilities",
                [],
                '{
                  "data": {
                    "meta": {
                      "update": true
                    },
                    "type": "customerproductvisibilities",
                    "id": "1-1-1",
                    "attributes": {
                      "visibility": "visible"
                    }
                  }
                }'
            ),
            new Response(
                200,
                [],
                $this->getCustomerproductvisibilityResponse()
            )
        );

        $customerproductvisibility = $this->apiClient->customerproductvisibilities->update([
            'data' => [
                'meta' => [
                    'update' => true,
                ],
                'type' => 'customerproductvisibilities',
                'id' => "1-1-1",
                'attributes' => [
                    'visibility' => 'visible',
                ],
            ],
        ]);

        $this->assertCustomerproductvisibility($customerproductvisibility);
    }

    /**
     * @return void
     * @throws IncompatiblePlatform
     * @throws UnrecognizedClientException
     * @throws ApiException
     */
    public function testGetCustomerproductvisibility(): void
    {
        $this->mockApiCall(
            new Request(
                "GET",
                "/admin/api/customerproductvisibilities/1-1-1",
                [],
                ''
            ),
            new Response(
                200,
                [],
                $this->getCustomerproductvisibilityResponse()
            )
        );

        $customerproductvisibility = $this->apiClient->customerproductvisibilities->get('1-1-1');

        $this->assertCustomerproductvisibility($customerproductvisibility);
    }

    /**
     * @return void
     * @throws ApiException
     * @throws IncompatiblePlatform
     * @throws UnrecognizedClientException
     */
    public function testListCustomerproductvisibility(): void
    {
        $this->mockApiCall(
            new Request(
                "GET",
                "/admin/api/customerproductvisibilities",
                [],
                ''
            ),
            new Response(
                200,
                [],
                $this->getCustomerproductvisibilityCollectionResponse()
            )
        );

        $customerproductvisibilities = $this->apiClient->customerproductvisibilities->page();

        $this->assertInstanceOf(CustomerproductvisibilityCollection::class, $customerproductvisibilities);

        foreach ($customerproductvisibilities as $customerproductvisibility) {
            $this->assertInstanceOf(Customerproductvisibility::class, $customerproductvisibility);
            $this->assertEquals("customerproductvisibilities", $customerproductvisibility->type);
            $this->assertNotEmpty($customerproductvisibility->attributes);
        }

        $linksObject = (object)[
            "self" => "https://myoroproxy.local/admin/api/customerproductvisibilities",
            "first" => "https://myoroproxy.local/admin/api/customerproductvisibilities?page%5Bsize%5D=1&sort=id",
            "prev" => "https://myoroproxy.local/admin/api/customerproductvisibilities?page%5Bsize%5D=1&sort=id",
            "next" => "https://myoroproxy.local/admin/api/customerproductvisibilities?page%5Bnumber%5D=2&page%5Bsize%5D=1&sort=id",
        ];
        $this->assertEquals($linksObject, $customerproductvisibilities->links);
    }

    /**
     * @return void
     * @throws ApiException
     * @throws IncompatiblePlatform
     * @throws UnrecognizedClientException
     */
    public function testDeleteCustomerproductvisibility(): void
    {
        $this->mockApiCall(
            new Request(
                "DELETE",
                "/admin/api/customerproductvisibilities?filter%5Bproduct%5D=1",
                [],
                '{}'
            ),
            new Response(204)
        );

        $result = $this->apiClient->customerproductvisibilities->delete(['product' => '1']);
        $this->assertNull($result);
    }

    /**
     * @param $customerproductvisibility
     * @return void
     */
    protected function assertCustomerproductvisibility($customerproductvisibility): void
    {
        $this->assertInstanceOf(Customerproductvisibility::class, $customerproductvisibility);

        $this->assertEquals("customerproductvisibilities", $customerproductvisibility->type);
        $this->assertEquals("1-1-1", $customerproductvisibility->id);

        $attributesObject = (object)[
            "visibility" => "visible",
        ];
        $this->assertEquals($attributesObject, $customerproductvisibility->attributes);

        $relationshipsOwnerObject = (object)[
            "data" => (object)[
                "type" => "customers",
                "id" => "1",
            ],
        ];
        $this->assertEquals($relationshipsOwnerObject, $customerproductvisibility->relationships->customer);
    }

    /**
     * @return string
     */
    protected function getCustomerproductvisibilityResponse(): string
    {
        return '{
                  "data": {
                    "type": "customerproductvisibilities",
                    "id": "1-1-1",
                    "links": {
                      "self": "https://myoroproxy.local/admin/api/customerproductvisibilities/1-1-1"
                    },
                    "attributes": {
                      "visibility": "visible"
                    },
                    "relationships": {
                      "product": {
                        "data": {
                          "type": "products",
                          "id": "1"
                        }
                      },
                      "customer": {
                        "data": {
                          "type": "customers",
                          "id": "1"
                        }
                      },
                      "website": {
                        "data": {
                          "type": "websites",
                          "id": "1"
                        }
                      }
                    }
                  },
                  "links": {
                    "self": "https://myoroproxy.local/admin/api/customerproductvisibilities"
                  }
                }';
    }

    /**
     * @return string
     */
    protected function getCustomerproductvisibilityCollectionResponse(): string
    {
        return '{
          "data": [
            {
              "type": "customerproductvisibilities",
              "id": "1-1-1",
              "links": {
                "self": "https://myoroproxy.local/admin/customerproductvisibilities/1-1-1"
              },
              "attributes": {
                "visibility": "visible"
              },
              "relationships": {
                "product": {
                  "data": {
                    "type": "products",
                    "id": "1"
                  }
                },
                "customer": {
                  "data": {
                    "type": "customers",
                    "id": "1"
                  }
                },
                "website": {
                  "data": {
                    "type": "websites",
                    "id": "1"
                  }
                }
              }
            }
          ],
          "links": {
            "self": "https://myoroproxy.local/admin/api/customerproductvisibilities",
            "first": "https://myoroproxy.local/admin/api/customerproductvisibilities?page%5Bsize%5D=1&sort=id",
            "prev": "https://myoroproxy.local/admin/api/customerproductvisibilities?page%5Bsize%5D=1&sort=id",
            "next": "https://myoroproxy.local/admin/api/customerproductvisibilities?page%5Bnumber%5D=2&page%5Bsize%5D=1&sort=id"            
          }
        }';
    }

}
