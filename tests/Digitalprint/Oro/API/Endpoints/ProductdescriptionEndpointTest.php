<?php

namespace Tests\Digitalprint\Oro\Api\Endpoints;

use Digitalprint\Oro\Api\Exceptions\ApiException;
use Digitalprint\Oro\Api\Exceptions\IncompatiblePlatform;
use Digitalprint\Oro\Api\Exceptions\UnrecognizedClientException;
use Digitalprint\Oro\Api\Resources\Product;
use Digitalprint\Oro\Api\Resources\Productdescription;
use Digitalprint\Oro\Api\Resources\ProductdescriptionCollection;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use JsonException;

class ProductdescriptionEndpointTest extends BaseEndpointTest
{
    /**
     * @return void
     * @throws IncompatiblePlatform
     * @throws UnrecognizedClientException
     * @throws ApiException
     * @throws JsonException
     */
    public function testCreateProductdescription(): void
    {
        $this->mockApiCall(
            new Request(
                "POST",
                "/admin/api/productdescriptions",
                [],
                '{
                  "data": {
                    "type": "productdescriptions",
                    "attributes": {
                      "fallback": null,
                      "wysiwyg": {
                        "value": "Product Description",
                        "style": null,
                        "properties": null
                      }
                    },
                    "relationships": {
                      "localization": {
                        "data": {
                          "type": "localizations",
                          "id": "1"
                        }
                      },
                      "product": {
                        "data": {
                          "type": "products",
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
                $this->getProductdescriptionResponse()
            )
        );

        $productdescription = $this->apiClient->productdescriptions->create([
          'data' => [
            'type' => 'productdescriptions',
            'attributes' => [
              'fallback' => null,
              'wysiwyg' => [
                'value' => 'Product Description',
                'style' => null,
                'properties' => null,
              ],
            ],
            'relationships' => [
              'localization' => [
                'data' => [
                  'type' => 'localizations',
                  'id' => '1',
                ],
              ],
              'product' => [
                'data' => [
                  'type' => 'products',
                  'id' => '1',
                ],
              ],
            ],
          ],
        ]);

        $this->assertProductdescription($productdescription);
    }

    /**
     * @return void
     * @throws ApiException
     * @throws IncompatiblePlatform
     * @throws JsonException
     * @throws UnrecognizedClientException
     */
    public function testUpdateProductdescription(): void
    {
        $this->mockApiCall(
            new Request(
                "PATCH",
                "/admin/api/productdescriptions",
                [],
                '{
                  "data": {
                    "type": "productdescriptions",
                    "id" : "1",
                    "attributes": {
                      "fallback": null,
                      "wysiwyg": {
                        "value": "Product Description",
                        "style": null,
                        "properties": null
                      }
                    },
                    "relationships": {
                      "localization": {
                        "data": {
                          "type": "localizations",
                          "id": "1"
                        }
                      },
                      "product": {
                        "data": {
                          "type": "products",
                          "id": "1"
                        }
                      }
                    }
                  }
                }'
            ),
            new Response(
                200,
                [],
                $this->getProductdescriptionResponse()
            )
        );

        $productdescription = $this->apiClient->productdescriptions->update([
          'data' => [
            'type' => 'productdescriptions',
            'id' => '1',
            'attributes' => [
              'fallback' => null,
              'wysiwyg' => [
                'value' => 'Product Description',
                'style' => null,
                'properties' => null,
              ],
            ],
            'relationships' => [
              'localization' => [
                'data' => [
                  'type' => 'localizations',
                  'id' => '1',
                ],
              ],
              'product' => [
                'data' => [
                  'type' => 'products',
                  'id' => '1',
                ],
              ],
            ],
          ],
        ]);

        $this->assertProductdescription($productdescription);
    }

    /**
     * @return void
     * @throws ApiException
     * @throws IncompatiblePlatform
     * @throws UnrecognizedClientException
     */
    public function testGetProductdescription(): void
    {
        $this->mockApiCall(
            new Request(
                "GET",
                "/admin/api/productdescriptions/1",
                [],
                ''
            ),
            new Response(
                200,
                [],
                $this->getProductdescriptionResponse()
            )
        );

        $productdescription = $this->apiClient->productdescriptions->get("1");

        $this->assertProductdescription($productdescription);
    }

    /**
     * @return void
     * @throws IncompatiblePlatform
     * @throws JsonException
     * @throws UnrecognizedClientException
     */
    public function testGetProductdescriptionOnProductResource(): void
    {
        $this->mockApiCall(
            new Request(
                "GET",
                "/admin/api/products/1/descriptions",
                [],
                ''
            ),
            new Response(
                200,
                [],
                $this->getProductdescriptionCollectionResponse()
            )
        );

        $product = $this->getProduct();

        $productdescriptions = $product->descriptions();

        $this->assertProductdescription($productdescriptions[0]);
    }

    /**
     * @return void
     * @throws ApiException
     * @throws IncompatiblePlatform
     * @throws UnrecognizedClientException
     */
    public function testListProductdescription(): void
    {
        $this->mockApiCall(
            new Request(
                "GET",
                "/admin/api/productdescriptions",
                [],
                ''
            ),
            new Response(
                200,
                [],
                $this->getProductdescriptionCollectionResponse()
            )
        );

        $productdescriptions = $this->apiClient->productdescriptions->page();

        $this->assertInstanceOf(ProductdescriptionCollection::class, $productdescriptions);

        foreach ($productdescriptions as $productdescription) {
            $this->assertInstanceOf(Productdescription::class, $productdescription);
            $this->assertEquals("productdescriptions", $productdescription->type);
            $this->assertNotEmpty($productdescription->attributes);
        }

        $linksObject = (object)[
            "self" => "https://myoroproxy.local/admin/api/productdescriptions",
            "first" => "https://myoroproxy.local/admin/api/productdescriptions?page%5Bsize%5D=1&sort=id",
            "prev" => "https://myoroproxy.local/admin/api/productdescriptions?page%5Bsize%5D=1&sort=id",
            "next" => "https://myoroproxy.local/admin/api/productdescriptions?page%5Bnumber%5D=2&page%5Bsize%5D=1&sort=id",
        ];
        $this->assertEquals($linksObject, $productdescriptions->links);
    }

    /**
     * @param $productdescription
     * @return void
     */
    public function assertProductdescription($productdescription): void
    {
        $this->assertInstanceOf(Productdescription::class, $productdescription);

        $this->assertEquals("productdescriptions", $productdescription->type);
        $this->assertEquals("1", $productdescription->id);

        $attributesObject = (object)[
            "fallback" => null,
            "wysiwyg" => (object)[
                "value" => "Product Description",
                "style" => null,
                "properties" => null,
                "valueRendered" => "Product Description",
            ],
        ];
        $this->assertEquals($attributesObject, $productdescription->attributes);

        $linkObject = (object)["self" => "https://myoroproxy.local/admin/api/productdescriptions/1"];
        $this->assertEquals($linkObject, $productdescription->links);

        $relationshipsProductObject = (object)[
            "links" => (object)[
              "self" => "https://myoroproxy.local/admin/api/productdescriptions/1/relationships/product",
              "related" => "https://myoroproxy.local/admin/api/productdescriptions/1/product",
            ],
            "data" => (object)[
                "type" => "products",
                 "id" => "1",
            ],
        ];
        $this->assertEquals($relationshipsProductObject, $productdescription->relationships->product);
    }

    /**
     * @return string
     */
    protected function getProductdescriptionResponse(): string
    {
        return '{
          "data": {
            "type": "productdescriptions",
            "id": "1",
            "links": {
              "self": "https://myoroproxy.local/admin/api/productdescriptions/1"
            },
            "attributes": {
              "fallback": null,
              "wysiwyg": {
                "value": "Product Description",
                "style": null,
                "properties": null,
                "valueRendered": "Product Description"
              }
            },
            "relationships": {
              "product": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/productdescriptions/1/relationships/product",
                  "related": "https://myoroproxy.local/admin/api/productdescriptions/1/product"
                },
                "data": {
                  "type": "products",
                  "id": "1"
                }
              },
              "localization": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/productdescriptions/1/relationships/localization",
                  "related": "https://myoroproxy.local/admin/api/productdescriptions/1/localization"
                },
                "data": {
                  "type": "localizations",
                  "id": "1"
                }
              }
            }
          },
          "links": {
            "self": "https://myoroproxy.local/admin/api/productdescriptions"
          }
        }';
    }

    /**
     * @return string
     */
    protected function getProductdescriptionCollectionResponse(): string
    {
        return '{
          "data": [
            {
              "type": "productdescriptions",
              "id": "1",
              "links": {
                "self": "https://myoroproxy.local/admin/api/productdescriptions/1"
              },
              "attributes": {
                "fallback": null,
                "wysiwyg": {
                  "value": "Product Description",
                  "style": null,
                  "properties": null,
                  "valueRendered": "Product Description"
                }
              },
              "relationships": {
                "product": {
                  "links": {
                    "self": "https://myoroproxy.local/admin/api/productdescriptions/1/relationships/product",
                    "related": "https://myoroproxy.local/admin/api/productdescriptions/1/product"
                  },
                  "data": {
                    "type": "products",
                    "id": "1"
                  }
                },
                "localization": {
                  "links": {
                    "self": "https://myoroproxy.local/admin/api/productdescriptions/1/relationships/localization",
                    "related": "https://myoroproxy.local/admin/api/productdescriptions/1/localization"
                  },
                  "data": {
                    "type": "localizations",
                    "id": "1"
                  }
                }
              }
            }
          ],
          "links": {
            "self": "https://myoroproxy.local/admin/api/productdescriptions",
            "first": "https://myoroproxy.local/admin/api/productdescriptions?page%5Bsize%5D=1&sort=id",
            "prev": "https://myoroproxy.local/admin/api/productdescriptions?page%5Bsize%5D=1&sort=id",
            "next": "https://myoroproxy.local/admin/api/productdescriptions?page%5Bnumber%5D=2&page%5Bsize%5D=1&sort=id"            
          }
        }';
    }

    /**
     * @return mixed
     * @throws JsonException
     */
    protected function getProduct(): mixed
    {
        $productJson = $this->getProductResponse();

        return $this->copy(json_decode($productJson, false, 512, JSON_THROW_ON_ERROR)->data, new Product($this->apiClient));
    }

    /**
     * @return string
     */
    protected function getProductResponse(): string
    {
        return '{
          "data": {
            "type": "products",
            "id": "1",
            "links": {
              "self": "https://myoroproxy.local/admin/api/products/1"
            },
            "attributes": {
              "availability_date": "2018-01-01T00:00:00Z",
              "sku": "test-api-1",
              "status": "enabled",
              "variantFields": [],
              "createdAt": "2021-12-16T11:12:03Z",
              "updatedAt": "2021-12-16T11:12:04Z",
              "productType": "simple",
              "featured": true,
              "newArrival": false
            },
            "relationships": {
              "owner": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/products/1/relationships/owner",
                  "related": "https://myoroproxy.local/admin/api/products/1/owner"
                },
                "data": {
                  "type": "businessunits",
                  "id": "1"
                }
              },
              "organization": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/products/1/relationships/organization",
                  "related": "https://myoroproxy.local/admin/api/products/1/organization"
                },
                "data": {
                  "type": "organizations",
                  "id": "1"
                }
              },
              "unitPrecisions": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/products/1/relationships/unitPrecisions",
                  "related": "https://myoroproxy.local/admin/api/products/1/unitPrecisions"
                },
                "data": [
                  {
                    "type": "productunitprecisions",
                    "id": "7"
                  }
                ]
              },
              "primaryUnitPrecision": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/products/1/relationships/primaryUnitPrecision",
                  "related": "https://myoroproxy.local/admin/api/products/1/primaryUnitPrecision"
                },
                "data": {
                  "type": "productunitprecisions",
                  "id": "7"
                }
              },
              "names": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/products/1/relationships/names",
                  "related": "https://myoroproxy.local/admin/api/products/1/names"
                },
                "data": [
                  {
                    "type": "productnames",
                    "id": "10"
                  },
                  {
                    "type": "productnames",
                    "id": "11"
                  },
                  {
                    "type": "productnames",
                    "id": "12"
                  }
                ]
              },
              "descriptions": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/products/1/relationships/descriptions",
                  "related": "https://myoroproxy.local/admin/api/products/1/descriptions"
                },
                "data": [
                  {
                    "type": "productdescriptions",
                    "id": "10"
                  },
                  {
                    "type": "productdescriptions",
                    "id": "11"
                  },
                  {
                    "type": "productdescriptions",
                    "id": "12"
                  }
                ]
              },
              "variantLinks": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/products/1/relationships/variantLinks",
                  "related": "https://myoroproxy.local/admin/api/products/1/variantLinks"
                },
                "data": []
              },
              "shortDescriptions": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/products/1/relationships/shortDescriptions",
                  "related": "https://myoroproxy.local/admin/api/products/1/shortDescriptions"
                },
                "data": [
                  {
                    "type": "productshortdescriptions",
                    "id": "10"
                  },
                  {
                    "type": "productshortdescriptions",
                    "id": "11"
                  },
                  {
                    "type": "productshortdescriptions",
                    "id": "12"
                  }
                ]
              },
              "images": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/products/1/relationships/images",
                  "related": "https://myoroproxy.local/admin/api/products/1/images"
                },
                "data": []
              },
              "attributeFamily": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/products/1/relationships/attributeFamily",
                  "related": "https://myoroproxy.local/admin/api/products/1/attributeFamily"
                },
                "data": {
                  "type": "attributefamilies",
                  "id": "1"
                }
              },
              "brand": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/products/1/relationships/brand",
                  "related": "https://myoroproxy.local/admin/api/products/1/brand"
                },
                "data": null
              },
              "slugPrototypes": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/products/1/relationships/slugPrototypes",
                  "related": "https://myoroproxy.local/admin/api/products/1/slugPrototypes"
                },
                "data": [
                  {
                    "type": "localizedfallbackvalues",
                    "id": "326"
                  },
                  {
                    "type": "localizedfallbackvalues",
                    "id": "327"
                  },
                  {
                    "type": "localizedfallbackvalues",
                    "id": "316"
                  }
                ]
              },
              "category": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/products/1/relationships/category",
                  "related": "https://myoroproxy.local/admin/api/products/1/category"
                },
                "data": {
                  "type": "categories",
                  "id": "4"
                }
              },
              "pageTemplate": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/products/1/relationships/pageTemplate",
                  "related": "https://myoroproxy.local/admin/api/products/1/pageTemplate"
                },
                "data": {
                  "type": "entityfieldfallbackvalues",
                  "id": "49"
                }
              },
              "taxCode": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/products/1/relationships/taxCode",
                  "related": "https://myoroproxy.local/admin/api/products/1/taxCode"
                },
                "data": null
              },
              "manageInventory": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/products/1/relationships/manageInventory",
                  "related": "https://myoroproxy.local/admin/api/products/1/manageInventory"
                },
                "data": {
                  "type": "entityfieldfallbackvalues",
                  "id": "50"
                }
              },
              "highlightLowInventory": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/products/1/relationships/highlightLowInventory",
                  "related": "https://myoroproxy.local/admin/api/products/1/highlightLowInventory"
                },
                "data": {
                  "type": "entityfieldfallbackvalues",
                  "id": "52"
                }
              },
              "inventoryThreshold": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/products/1/relationships/inventoryThreshold",
                  "related": "https://myoroproxy.local/admin/api/products/1/inventoryThreshold"
                },
                "data": {
                  "type": "entityfieldfallbackvalues",
                  "id": "51"
                }
              },
              "lowInventoryThreshold": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/products/1/relationships/lowInventoryThreshold",
                  "related": "https://myoroproxy.local/admin/api/products/1/lowInventoryThreshold"
                },
                "data": {
                  "type": "entityfieldfallbackvalues",
                  "id": "53"
                }
              },
              "minimumQuantityToOrder": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/products/1/relationships/minimumQuantityToOrder",
                  "related": "https://myoroproxy.local/admin/api/products/1/minimumQuantityToOrder"
                },
                "data": {
                  "type": "entityfieldfallbackvalues",
                  "id": "55"
                }
              },
              "maximumQuantityToOrder": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/products/1/relationships/maximumQuantityToOrder",
                  "related": "https://myoroproxy.local/admin/api/products/1/maximumQuantityToOrder"
                },
                "data": {
                  "type": "entityfieldfallbackvalues",
                  "id": "56"
                }
              },
              "decrementQuantity": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/products/1/relationships/decrementQuantity",
                  "related": "https://myoroproxy.local/admin/api/products/1/decrementQuantity"
                },
                "data": {
                  "type": "entityfieldfallbackvalues",
                  "id": "57"
                }
              },
              "backOrder": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/products/1/relationships/backOrder",
                  "related": "https://myoroproxy.local/admin/api/products/1/backOrder"
                },
                "data": {
                  "type": "entityfieldfallbackvalues",
                  "id": "58"
                }
              },
              "isUpcoming": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/products/1/relationships/isUpcoming",
                  "related": "https://myoroproxy.local/admin/api/products/1/isUpcoming"
                },
                "data": {
                  "type": "entityfieldfallbackvalues",
                  "id": "54"
                }
              },
              "metaTitles": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/products/1/relationships/metaTitles",
                  "related": "https://myoroproxy.local/admin/api/products/1/metaTitles"
                },
                "data": [
                  {
                    "type": "localizedfallbackvalues",
                    "id": "317"
                  },
                  {
                    "type": "localizedfallbackvalues",
                    "id": "318"
                  },
                  {
                    "type": "localizedfallbackvalues",
                    "id": "319"
                  }
                ]
              },
              "metaDescriptions": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/products/1/relationships/metaDescriptions",
                  "related": "https://myoroproxy.local/admin/api/products/1/metaDescriptions"
                },
                "data": [
                  {
                    "type": "localizedfallbackvalues",
                    "id": "320"
                  },
                  {
                    "type": "localizedfallbackvalues",
                    "id": "321"
                  },
                  {
                    "type": "localizedfallbackvalues",
                    "id": "322"
                  }
                ]
              },
              "metaKeywords": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/products/1/relationships/metaKeywords",
                  "related": "https://myoroproxy.local/admin/api/products/1/metaKeywords"
                },
                "data": [
                  {
                    "type": "localizedfallbackvalues",
                    "id": "323"
                  },
                  {
                    "type": "localizedfallbackvalues",
                    "id": "324"
                  },
                  {
                    "type": "localizedfallbackvalues",
                    "id": "325"
                  }
                ]
              },
              "inventory_status": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/products/1/relationships/inventory_status",
                  "related": "https://myoroproxy.local/admin/api/products/1/inventory_status"
                },
                "data": {
                  "type": "prodinventorystatuses",
                  "id": "out_of_stock"
                }
              }
            }
          },
          "links": {
            "self": "https://myoroproxy.local/admin/api/products"
          }
        }';
    }
}
