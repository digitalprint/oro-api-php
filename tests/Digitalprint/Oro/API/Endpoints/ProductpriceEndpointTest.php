<?php

use Digitalprint\Oro\Api\Exceptions\IncompatiblePlatform;
use Digitalprint\Oro\Api\Exceptions\UnrecognizedClientException;
use Digitalprint\Oro\Api\Resources\Product;
use Digitalprint\Oro\Api\Resources\Productprice;
use Digitalprint\Oro\Api\Resources\ProductpriceCollection;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Tests\Digitalprint\Oro\Api\Endpoints\BaseEndpointTest;

class ProductpriceEndpointTest extends BaseEndpointTest
{
    /**
     * @return void
     * @throws IncompatiblePlatform
     * @throws UnrecognizedClientException
     */
    public function testCreateProductprice(): void
    {
        $this->mockApiCall(
            new Request(
                "POST",
                "/admin/api/productprices",
                [],
                '{
                  "data": {
                    "type": "productprices",
                    "attributes": {
                      "quantity": 24,
                      "currency": "USD",
                      "value": 126.78
                    },
                    "relationships": {
                      "priceList": {
                        "data": {
                          "type": "pricelists",
                          "id": "1"
                        }
                      },
                      "product": {
                        "data": {
                          "type": "products",
                          "id": "1"
                        }
                      },
                      "unit": {
                        "data": {
                          "type": "productunits",
                          "id": "item"
                        }
                      }
                    }
                  }
                }'
            ),
            new Response(
                201,
                [],
                $this->getProductpriceResponse()
            )
        );

        $productprice = $this->apiClient->productprices->create([
          'data' => [
            'type' => 'productprices',
            'attributes' => [
              'quantity' => 24,
              'currency' => 'USD',
              'value' => 126.78,
            ],
            'relationships' => [
              'priceList' => [
                'data' => [
                  'type' => 'pricelists',
                  'id' => '1',
                ],
              ],
              'product' => [
                'data' => [
                  'type' => 'products',
                  'id' => '1',
                ],
              ],
              'unit' => [
                'data' => [
                  'type' => 'productunits',
                  'id' => 'item',
                ],
              ],
            ],
          ],
        ]);

        $this->assertProductprice($productprice);
    }

    /**
     * @return void
     * @throws IncompatiblePlatform
     * @throws UnrecognizedClientException
     */
    public function testUpdateProductprice(): void
    {
        $this->mockApiCall(
            new Request(
                "PATCH",
                "/admin/api/productprices",
                [],
                '{
                  "data": {
                    "id": "24be698e-31b2-4b8f-a3cc-9825b4cf24b7-1",
                    "type": "productprices",
                    "attributes": {
                      "quantity": 1,
                      "currency": "EUR",
                      "value": 120
                    },
                    "relationships": {
                      "product": {
                        "data": {
                          "type": "products",
                          "id": "2"
                        }
                      },
                      "unit": {
                        "data": {
                          "type": "productunits",
                          "id": "set"
                        }
                      }
                    }
                  }
                }'
            ),
            new Response(
                200,
                [],
                $this->getProductpriceResponse()
            )
        );

        $productprice = $this->apiClient->productprices->update([
          'data' => [
            'id' => '24be698e-31b2-4b8f-a3cc-9825b4cf24b7-1',
            'type' => 'productprices',
            'attributes' => [
              'quantity' => 1,
              'currency' => 'EUR',
              'value' => 120,
            ],
            'relationships' => [
              'product' => [
                'data' => [
                  'type' => 'products',
                  'id' => '2',
                ],
              ],
              'unit' => [
                'data' => [
                  'type' => 'productunits',
                  'id' => 'set',
                ],
              ],
            ],
          ],
        ]);

        $this->assertProductprice($productprice);
    }

    /**
     * @return void
     * @throws IncompatiblePlatform
     * @throws UnrecognizedClientException
     */
    public function testGetProductprice(): void
    {
        $this->mockApiCall(
            new Request(
                "GET",
                "/admin/api/productprices/24be698e-31b2-4b8f-a3cc-9825b4cf24b7-1",
                [
                    "priceList" => 1,
                ],
                ''
            ),
            new Response(
                200,
                [],
                $this->getProductpriceResponse()
            )
        );

        $productprice = $this->apiClient->productprices->get("24be698e-31b2-4b8f-a3cc-9825b4cf24b7-1");

        $this->assertProductprice($productprice);
    }

    /**
     * @return void
     * @throws IncompatiblePlatform
     * @throws UnrecognizedClientException
     */
    public function testListProductprice(): void
    {
        $this->mockApiCall(
            new Request(
                "GET",
                "/admin/api/productprices",
                [],
                ''
            ),
            new Response(
                200,
                [],
                $this->getProductpriceCollectionResponse()
            )
        );

        $productprices = $this->apiClient->productprices->page();

        $this->assertInstanceOf(ProductpriceCollection::class, $productprices);

        foreach ($productprices as $productprice) {
            $this->assertInstanceOf(Productprice::class, $productprice);
            $this->assertEquals("productprices", $productprice->type);
            $this->assertNotEmpty($productprice->attributes);
        }

        $linksObject = (object)[
            "self" => "https://myoroproxy.local/admin/api/productprices",
            "first" => "https://myoroproxy.local/admin/api/productprices?page%5Bsize%5D=1&sort=id",
            "prev" => "https://myoroproxy.local/admin/api/productprices?page%5Bsize%5D=1&sort=id",
            "next" => "https://myoroproxy.local/admin/api/productprices?page%5Bnumber%5D=2&page%5Bsize%5D=1&sort=id",
        ];
        $this->assertEquals($linksObject, $productprices->links);
    }

    /**
     * @return void
     * @throws IncompatiblePlatform
     * @throws UnrecognizedClientException
     */
    public function testDeleteProductprice(): void
    {
        $this->mockApiCall(
            new Request(
                "DELETE",
                "/admin/api/productprices?filter%5BpriceList%5D=1&filter%5Bid%5D=24be698e-31b2-4b8f-a3cc-9825b4cf24b7-1",
                [],
                '{}'
            ),
            new Response(204)
        );

        $result = $this->apiClient->productprices->delete(['priceList' => '1', 'id' => '24be698e-31b2-4b8f-a3cc-9825b4cf24b7-1']);
        $this->assertNull($result);
    }

    /**
     * @param $productprice
     * @return void
     */
    protected function assertProductprice($productprice): void
    {
        $this->assertInstanceOf(Productprice::class, $productprice);

        $this->assertEquals("productprices", $productprice->type);
        $this->assertEquals("24be698e-31b2-4b8f-a3cc-9825b4cf24b7-1", $productprice->id);

        $attributesObject = (object)[
            "quantity" => 1,
            "value" => "1.0000",
            "currency" => "EUR",
        ];
        $this->assertEquals($attributesObject, $productprice->attributes);

        $linkObject = (object)["self" => "https://myoroproxy.local/admin/api/productprices/24be698e-31b2-4b8f-a3cc-9825b4cf24b7-1"];
        $this->assertEquals($linkObject, $productprice->links);

        $relationshipsProductObject = (object)[
            "data" => (object)[
                "type" => "products",
                "id" => "1",
            ],
        ];
        $this->assertEquals($relationshipsProductObject, $productprice->relationships->product);
    }

    /**
     * @return string
     */
    protected function getProductpriceResponse(): string
    {
        return '{
          "data": {
            "type": "productprices",
            "id": "24be698e-31b2-4b8f-a3cc-9825b4cf24b7-1",
            "links": {
              "self": "https://myoroproxy.local/admin/api/productprices/24be698e-31b2-4b8f-a3cc-9825b4cf24b7-1"
            },
            "attributes": {
              "quantity": 1,
              "value": "1.0000",
              "currency": "EUR"
            },
            "relationships": {
              "priceList": {
                "data": {
                  "type": "pricelists",
                  "id": "1"
                }
              },
              "product": {
                "data": {
                  "type": "products",
                  "id": "1"
                }
              },
              "unit": {
                "data": {
                  "type": "productunits",
                  "id": "set"
                }
              }
            }
          },
          "links": {
            "self": "https://myoroproxy.local/admin/api/productprices"
          }
        }';
    }

    /**
     * @return string
     */
    protected function getProductpriceCollectionResponse(): string
    {
        return '{
          "data": [
            {
              "type": "productprices",
              "id": "24be698e-31b2-4b8f-a3cc-9825b4cf24b7-1",
              "links": {
                "self": "https://myoroproxy.local/admin/api/productprices/24be698e-31b2-4b8f-a3cc-9825b4cf24b7-1"
              },
              "attributes": {
                "quantity": 1,
                "value": "1.0000",
                "currency": "EUR"
              },
              "relationships": {
                "priceList": {
                  "data": {
                    "type": "pricelists",
                    "id": "1"
                  }
                },
                "product": {
                  "data": {
                    "type": "products",
                    "id": "1"
                  }
                },
                "unit": {
                  "data": {
                    "type": "productunits",
                    "id": "set"
                  }
                }
              }
            }
          ],
          "links": {
            "self": "https://myoroproxy.local/admin/api/productprices",
            "first": "https://myoroproxy.local/admin/api/productprices?page%5Bsize%5D=1&sort=id",
            "prev": "https://myoroproxy.local/admin/api/productprices?page%5Bsize%5D=1&sort=id",
            "next": "https://myoroproxy.local/admin/api/productprices?page%5Bnumber%5D=2&page%5Bsize%5D=1&sort=id"            
          }
        }';
    }

}
