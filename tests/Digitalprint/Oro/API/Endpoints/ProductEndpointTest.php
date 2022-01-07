<?php

use Digitalprint\Oro\Api\Exceptions\IncompatiblePlatform;
use Digitalprint\Oro\Api\Exceptions\UnrecognizedClientException;
use Digitalprint\Oro\Api\Resources\Product;
use Digitalprint\Oro\Api\Resources\ProductCollection;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Tests\Digitalprint\Oro\Api\Endpoints\BaseEndpointTest;

class ProductEndpointTest extends BaseEndpointTest
{
    /**
     * @return void
     * @throws IncompatiblePlatform
     * @throws UnrecognizedClientException
     */
    public function testCreateProduct(): void
    {
        $this->mockApiCall(
            new Request(
                "POST",
                "/admin/api/products",
                [],
                '{
                   "data": {
                      "type": "products",
                      "attributes": {
                        "sku": "test-api-1",
                        "status": "enabled",
                        "variantFields": [],
                        "productType": "simple",
                        "featured": true,
                        "newArrival": false,
                        "availability_date": "2018-01-01"
                      },
                      "relationships": {
                        "owner": {
                          "data": {
                            "type": "businessunits",
                            "id": "1"
                          }
                        },
                        "organization": {
                          "data": {
                            "type": "organizations",
                            "id": "1"
                          }
                        },
                        "names": {
                          "data": [
                            {
                              "type": "productnames",
                              "id": "names-1"
                            },
                            {
                              "type": "productnames",
                              "id": "names-2"
                            }
                          ]
                        },
                        "shortDescriptions": {
                          "data": [
                            {
                              "type": "productshortdescriptions",
                              "id": "short-descriptions-1"
                            },
                            {
                              "type": "productshortdescriptions",
                              "id": "short-descriptions-2"
                            }
                          ]
                        },
                        "descriptions": {
                          "data": [
                            {
                              "type": "productdescriptions",
                              "id": "descriptions-1"
                            },
                            {
                              "type": "productdescriptions",
                              "id": "descriptions-2"
                            }
                          ]
                        },
                        "slugPrototypes": {
                          "data": [
                            {
                              "type": "localizedfallbackvalues",
                              "id": "slug-id-1"
                            }
                          ]
                        },
                        "taxCode": {
                          "data": {
                            "type": "producttaxcodes",
                            "id": "2"
                          }
                        },
                        "attributeFamily": {
                          "data": {
                            "type": "attributefamilies",
                            "id": "1"
                          }
                        },
                        "primaryUnitPrecision": {
                          "data": {
                            "type": "productunitprecisions",
                            "id": "product-unit-precision-id-3"
                          }
                        },
                        "unitPrecisions": {
                          "data": [
                            {
                              "type": "productunitprecisions",
                              "id": "product-unit-precision-id-1"
                            },
                            {
                              "type": "productunitprecisions",
                              "id": "product-unit-precision-id-2"
                            }
                          ]
                        },
                        "inventory_status": {
                          "data": {
                            "type": "prodinventorystatuses",
                            "id": "out_of_stock"
                          }
                        },
                        "pageTemplate": {
                          "data": {
                            "type": "entityfieldfallbackvalues",
                            "id": "1xyz"
                          }
                        },
                        "manageInventory": {
                          "data": {
                            "type": "entityfieldfallbackvalues",
                            "id": "1abcd"
                          }
                        },
                        "inventoryThreshold": {
                          "data": {
                            "type": "entityfieldfallbackvalues",
                            "id": "2abcd"
                          }
                        },
                        "highlightLowInventory": {
                          "data": {
                            "type": "entityfieldfallbackvalues",
                            "id": "low1abcd"
                          }
                        },
                        "lowInventoryThreshold": {
                          "data": {
                            "type": "entityfieldfallbackvalues",
                            "id": "low2abcd"
                          }
                        },
                        "isUpcoming": {
                          "data": {
                            "type": "entityfieldfallbackvalues",
                            "id": "product-is-upcoming"
                          }
                        },
                        "minimumQuantityToOrder": {
                          "data": {
                            "type": "entityfieldfallbackvalues",
                            "id": "3abcd"
                          }
                        },
                        "maximumQuantityToOrder": {
                          "data": {
                            "type": "entityfieldfallbackvalues",
                            "id": "4abcd"
                          }
                        },
                        "decrementQuantity": {
                          "data": {
                            "type": "entityfieldfallbackvalues",
                            "id": "5abcd"
                          }
                        },
                        "backOrder": {
                          "data": {
                            "type": "entityfieldfallbackvalues",
                            "id": "6abcd"
                          }
                        },
                        "category": {
                          "data": {
                            "type": "categories",
                            "id": "4"
                          }
                        }
                      }
                    },
                    "included": [
                      {
                        "type": "entityfieldfallbackvalues",
                        "id": "1xyz",
                        "attributes": {
                          "fallback": null,
                          "scalarValue": "short",
                          "arrayValue": null
                        }
                      },
                      {
                        "type": "entityfieldfallbackvalues",
                        "id": "1abcd",
                        "attributes": {
                          "fallback": "systemConfig",
                          "scalarValue": null,
                          "arrayValue": null
                        }
                      },
                      {
                        "type": "entityfieldfallbackvalues",
                        "id": "2abcd",
                        "attributes": {
                          "fallback": null,
                          "scalarValue": "31",
                          "arrayValue": null
                        }
                      },
                      {
                        "type": "entityfieldfallbackvalues",
                        "id": "low1abcd",
                        "attributes": {
                          "fallback": "systemConfig",
                          "scalarValue": null,
                          "arrayValue": null
                        }
                      },
                      {
                        "type": "entityfieldfallbackvalues",
                        "id": "low2abcd",
                        "attributes": {
                          "fallback": null,
                          "scalarValue": "41",
                          "arrayValue": null
                        }
                      },
                      {
                        "type": "entityfieldfallbackvalues",
                        "id": "product-is-upcoming",
                        "attributes": {
                          "fallback": null,
                          "scalarValue": "1",
                          "arrayValue": null
                        }
                      },
                      {
                        "type": "entityfieldfallbackvalues",
                        "id": "3abcd",
                        "attributes": {
                          "fallback": "systemConfig",
                          "scalarValue": null,
                          "arrayValue": null
                        }
                      },
                      {
                        "type": "entityfieldfallbackvalues",
                        "id": "4abcd",
                        "attributes": {
                          "fallback": null,
                          "scalarValue": "12",
                          "arrayValue": null
                        }
                      },
                      {
                        "type": "entityfieldfallbackvalues",
                        "id": "5abcd",
                        "attributes": {
                          "fallback": null,
                          "scalarValue": "1",
                          "arrayValue": null
                        }
                      },
                      {
                        "type": "entityfieldfallbackvalues",
                        "id": "6abcd",
                        "attributes": {
                          "fallback": null,
                          "scalarValue": "0",
                          "arrayValue": null
                        }
                      },
                      {
                        "type": "productnames",
                        "id": "names-1",
                        "attributes": {
                          "fallback": null,
                          "string": "Test product"
                        },
                        "relationships": {
                          "localization": {
                            "data": null
                          }
                        }
                      },
                      {
                        "type": "productnames",
                        "id": "names-2",
                        "attributes": {
                          "fallback": null,
                          "string": "Product in Spanish"
                        },
                        "relationships": {
                          "localization": {
                            "data": {
                              "type": "localizations",
                              "id": "1"
                            }
                          }
                        }
                      },
                      {
                        "type": "productshortdescriptions",
                        "id": "short-descriptions-1",
                        "attributes": {
                          "fallback": null,
                          "text": "Test product short description"
                        },
                        "relationships": {
                          "localization": {
                            "data": null
                          }
                        }
                      },
                      {
                        "type": "productshortdescriptions",
                        "id": "short-descriptions-2",
                        "attributes": {
                          "fallback": null,
                          "text": "Product Short Description in Spanish"
                        },
                        "relationships": {
                          "localization": {
                            "data": {
                              "type": "localizations",
                              "id": "1"
                            }
                          }
                        }
                      },
                      {
                        "type": "productdescriptions",
                        "id": "descriptions-1",
                        "attributes": {
                          "fallback": null,
                          "wysiwyg": {
                            "value": "Test product description",
                            "style": null,
                            "properties": null
                          }
                        },
                        "relationships": {
                          "localization": {
                            "data": null
                          }
                        }
                      },
                      {
                        "type": "productdescriptions",
                        "id": "descriptions-2",
                        "attributes": {
                          "fallback": null,
                          "wysiwyg": {
                            "value": "Product Short Description in Spanish",
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
                          }
                        }
                      },
                      {
                        "type": "localizedfallbackvalues",
                        "id": "slug-id-1",
                        "attributes": {
                          "fallback": null,
                          "string": "test-prod-slug",
                          "text": null
                        },
                        "relationships": {
                          "localization": {
                            "data": null
                          }
                        }
                      },
                      {
                        "type": "productunitprecisions",
                        "id": "product-unit-precision-id-1",
                        "attributes": {
                          "precision": "0",
                          "conversionRate": "5",
                          "sell": "1"
                        },
                        "relationships": {
                          "unit": {
                            "data": {
                              "type": "productunits",
                              "id": "each"
                            }
                          }
                        }
                      },
                      {
                        "type": "productunitprecisions",
                        "id": "product-unit-precision-id-2",
                        "attributes": {
                          "precision": "0",
                          "conversionRate": "10",
                          "sell": "1"
                        },
                        "relationships": {
                          "unit": {
                            "data": {
                              "type": "productunits",
                              "id": "item"
                            }
                          }
                        }
                      },
                      {
                        "type": "productunitprecisions",
                        "id": "product-unit-precision-id-3",
                        "attributes": {
                          "precision": "0",
                          "conversionRate": "2",
                          "sell": "1"
                        },
                        "relationships": {
                          "unit": {
                            "data": {
                              "type": "productunits",
                              "id": "set"
                            }
                          }
                        }
                      }
                    ]
                }'
            ),
            new Response(
                201,
                [],
                $this->getProductResponse()
            )
        );

        $product = $this->apiClient->products->create([
          'data' => [
            'type' => 'products',
            'attributes' => [
              'sku' => 'test-api-1',
              'status' => 'enabled',
              'variantFields' => [
              ],
              'productType' => 'simple',
              'featured' => true,
              'newArrival' => false,
              'availability_date' => '2018-01-01',
            ],
            'relationships' => [
              'owner' => [
                'data' => [
                  'type' => 'businessunits',
                  'id' => '1',
                ],
              ],
              'organization' => [
                'data' => [
                  'type' => 'organizations',
                  'id' => '1',
                ],
              ],
              'names' => [
                'data' => [
                  0 => [
                    'type' => 'productnames',
                    'id' => 'names-1',
                  ],
                  1 => [
                    'type' => 'productnames',
                    'id' => 'names-2',
                  ],
                ],
              ],
              'shortDescriptions' => [
                'data' => [
                  0 => [
                    'type' => 'productshortdescriptions',
                    'id' => 'short-descriptions-1',
                  ],
                  1 => [
                    'type' => 'productshortdescriptions',
                    'id' => 'short-descriptions-2',
                  ],
                ],
              ],
              'descriptions' => [
                'data' => [
                  0 => [
                    'type' => 'productdescriptions',
                    'id' => 'descriptions-1',
                  ],
                  1 => [
                    'type' => 'productdescriptions',
                    'id' => 'descriptions-2',
                  ],
                ],
              ],
              'slugPrototypes' => [
                'data' => [
                  0 => [
                    'type' => 'localizedfallbackvalues',
                    'id' => 'slug-id-1',
                  ],
                ],
              ],
              'taxCode' => [
                'data' => [
                  'type' => 'producttaxcodes',
                  'id' => '2',
                ],
              ],
              'attributeFamily' => [
                'data' => [
                  'type' => 'attributefamilies',
                  'id' => '1',
                ],
              ],
              'primaryUnitPrecision' => [
                'data' => [
                  'type' => 'productunitprecisions',
                  'id' => 'product-unit-precision-id-3',
                ],
              ],
              'unitPrecisions' => [
                'data' => [
                  0 => [
                    'type' => 'productunitprecisions',
                    'id' => 'product-unit-precision-id-1',
                  ],
                  1 => [
                    'type' => 'productunitprecisions',
                    'id' => 'product-unit-precision-id-2',
                  ],
                ],
              ],
              'inventory_status' => [
                'data' => [
                  'type' => 'prodinventorystatuses',
                  'id' => 'out_of_stock',
                ],
              ],
              'pageTemplate' => [
                'data' => [
                  'type' => 'entityfieldfallbackvalues',
                  'id' => '1xyz',
                ],
              ],
              'manageInventory' => [
                'data' => [
                  'type' => 'entityfieldfallbackvalues',
                  'id' => '1abcd',
                ],
              ],
              'inventoryThreshold' => [
                'data' => [
                  'type' => 'entityfieldfallbackvalues',
                  'id' => '2abcd',
                ],
              ],
              'highlightLowInventory' => [
                'data' => [
                  'type' => 'entityfieldfallbackvalues',
                  'id' => 'low1abcd',
                ],
              ],
              'lowInventoryThreshold' => [
                'data' => [
                  'type' => 'entityfieldfallbackvalues',
                  'id' => 'low2abcd',
                ],
              ],
              'isUpcoming' => [
                'data' => [
                  'type' => 'entityfieldfallbackvalues',
                  'id' => 'product-is-upcoming',
                ],
              ],
              'minimumQuantityToOrder' => [
                'data' => [
                  'type' => 'entityfieldfallbackvalues',
                  'id' => '3abcd',
                ],
              ],
              'maximumQuantityToOrder' => [
                'data' => [
                  'type' => 'entityfieldfallbackvalues',
                  'id' => '4abcd',
                ],
              ],
              'decrementQuantity' => [
                'data' => [
                  'type' => 'entityfieldfallbackvalues',
                  'id' => '5abcd',
                ],
              ],
              'backOrder' => [
                'data' => [
                  'type' => 'entityfieldfallbackvalues',
                  'id' => '6abcd',
                ],
              ],
              'category' => [
                'data' => [
                  'type' => 'categories',
                  'id' => '4',
                ],
              ],
            ],
          ],
          'included' => [
            0 => [
              'type' => 'entityfieldfallbackvalues',
              'id' => '1xyz',
              'attributes' => [
                'fallback' => null,
                'scalarValue' => 'short',
                'arrayValue' => null,
              ],
            ],
            1 => [
              'type' => 'entityfieldfallbackvalues',
              'id' => '1abcd',
              'attributes' => [
                'fallback' => 'systemConfig',
                'scalarValue' => null,
                'arrayValue' => null,
              ],
            ],
            2 => [
              'type' => 'entityfieldfallbackvalues',
              'id' => '2abcd',
              'attributes' => [
                'fallback' => null,
                'scalarValue' => '31',
                'arrayValue' => null,
              ],
            ],
            3 => [
              'type' => 'entityfieldfallbackvalues',
              'id' => 'low1abcd',
              'attributes' => [
                'fallback' => 'systemConfig',
                'scalarValue' => null,
                'arrayValue' => null,
              ],
            ],
            4 => [
              'type' => 'entityfieldfallbackvalues',
              'id' => 'low2abcd',
              'attributes' => [
                'fallback' => null,
                'scalarValue' => '41',
                'arrayValue' => null,
              ],
            ],
            5 => [
              'type' => 'entityfieldfallbackvalues',
              'id' => 'product-is-upcoming',
              'attributes' => [
                'fallback' => null,
                'scalarValue' => '1',
                'arrayValue' => null,
              ],
            ],
            6 => [
              'type' => 'entityfieldfallbackvalues',
              'id' => '3abcd',
              'attributes' => [
                'fallback' => 'systemConfig',
                'scalarValue' => null,
                'arrayValue' => null,
              ],
            ],
            7 => [
              'type' => 'entityfieldfallbackvalues',
              'id' => '4abcd',
              'attributes' => [
                'fallback' => null,
                'scalarValue' => '12',
                'arrayValue' => null,
              ],
            ],
            8 => [
              'type' => 'entityfieldfallbackvalues',
              'id' => '5abcd',
              'attributes' => [
                'fallback' => null,
                'scalarValue' => '1',
                'arrayValue' => null,
              ],
            ],
            9 => [
              'type' => 'entityfieldfallbackvalues',
              'id' => '6abcd',
              'attributes' => [
                'fallback' => null,
                'scalarValue' => '0',
                'arrayValue' => null,
              ],
            ],
            10 => [
              'type' => 'productnames',
              'id' => 'names-1',
              'attributes' => [
                'fallback' => null,
                'string' => 'Test product',
              ],
              'relationships' => [
                'localization' => [
                  'data' => null,
                ],
              ],
            ],
            11 => [
              'type' => 'productnames',
              'id' => 'names-2',
              'attributes' => [
                'fallback' => null,
                'string' => 'Product in Spanish',
              ],
              'relationships' => [
                'localization' => [
                  'data' => [
                    'type' => 'localizations',
                    'id' => '1',
                  ],
                ],
              ],
            ],
            12 => [
              'type' => 'productshortdescriptions',
              'id' => 'short-descriptions-1',
              'attributes' => [
                'fallback' => null,
                'text' => 'Test product short description',
              ],
              'relationships' => [
                'localization' => [
                  'data' => null,
                ],
              ],
            ],
            13 => [
              'type' => 'productshortdescriptions',
              'id' => 'short-descriptions-2',
              'attributes' => [
                'fallback' => null,
                'text' => 'Product Short Description in Spanish',
              ],
              'relationships' => [
                'localization' => [
                  'data' => [
                    'type' => 'localizations',
                    'id' => '1',
                  ],
                ],
              ],
            ],
            14 => [
              'type' => 'productdescriptions',
              'id' => 'descriptions-1',
              'attributes' => [
                'fallback' => null,
                'wysiwyg' => [
                  'value' => 'Test product description',
                  'style' => null,
                  'properties' => null,
                ],
              ],
              'relationships' => [
                'localization' => [
                  'data' => null,
                ],
              ],
            ],
            15 => [
              'type' => 'productdescriptions',
              'id' => 'descriptions-2',
              'attributes' => [
                'fallback' => null,
                'wysiwyg' => [
                  'value' => 'Product Short Description in Spanish',
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
              ],
            ],
            16 => [
              'type' => 'localizedfallbackvalues',
              'id' => 'slug-id-1',
              'attributes' => [
                'fallback' => null,
                'string' => 'test-prod-slug',
                'text' => null,
              ],
              'relationships' => [
                'localization' => [
                  'data' => null,
                ],
              ],
            ],
            17 => [
              'type' => 'productunitprecisions',
              'id' => 'product-unit-precision-id-1',
              'attributes' => [
                'precision' => '0',
                'conversionRate' => '5',
                'sell' => '1',
              ],
              'relationships' => [
                'unit' => [
                  'data' => [
                    'type' => 'productunits',
                    'id' => 'each',
                  ],
                ],
              ],
            ],
            18 => [
              'type' => 'productunitprecisions',
              'id' => 'product-unit-precision-id-2',
              'attributes' => [
                'precision' => '0',
                'conversionRate' => '10',
                'sell' => '1',
              ],
              'relationships' => [
                'unit' => [
                  'data' => [
                    'type' => 'productunits',
                    'id' => 'item',
                  ],
                ],
              ],
            ],
            19 => [
              'type' => 'productunitprecisions',
              'id' => 'product-unit-precision-id-3',
              'attributes' => [
                'precision' => '0',
                'conversionRate' => '2',
                'sell' => '1',
              ],
              'relationships' => [
                'unit' => [
                  'data' => [
                    'type' => 'productunits',
                    'id' => 'set',
                  ],
                ],
              ],
            ],
          ],
        ]);

        $this->assertProduct($product);
    }

    /**
     * @return void
     * @throws IncompatiblePlatform
     * @throws UnrecognizedClientException
     */
    public function testUpdateProduct(): void
    {
        $this->mockApiCall(
            new Request(
                "PATCH",
                "/admin/api/products",
                [],
                '{
                  "data": {
                    "type": "products",
                    "id": "1",
                    "attributes": {
                      "sku": "test-api-1",
                      "status": "enabled",
                      "variantFields": [],
                      "productType": "simple",
                      "featured": true,
                      "newArrival": false
                    },
                    "relationships": {
                      "owner": {
                        "data": {
                          "type": "businessunits",
                          "id": "1"
                        }
                      },
                      "organization": {
                        "data": {
                          "type": "organizations",
                          "id": "1"
                        }
                      },
                      "taxCode": {
                        "data": {
                          "type": "producttaxcodes",
                          "id": "2"
                        }
                      },
                      "attributeFamily": {
                        "data": {
                          "type": "attributefamilies",
                          "id": "1"
                        }
                      },
                      "inventory_status": {
                        "data": {
                          "type": "prodinventorystatuses",
                          "id": "in_stock"
                        }
                      },
                      "pageTempalte": {
                        "data": {
                          "type": "entityfieldfallbackvalues",
                          "id": "355"
                        }
                      },
                      "manageInventory": {
                        "data": {
                          "type": "entityfieldfallbackvalues",
                          "id": "466"
                        }
                      },
                      "category": {
                        "data": {
                          "type": "categories",
                          "id": "4"
                        }
                      },
                      "names": {
                        "data": [
                          {
                            "type": "productnames",
                            "id": "807"
                          }
                        ]
                      },
                      "slugPrototypes": {
                        "data": [
                          {
                            "type": "localizedfallbackvalues",
                            "id": "907"
                          }
                        ]
                      },
                      "primaryUnitPrecision": {
                        "data": {
                          "type": "productunitprecisions",
                          "id": "453"
                        }
                      },
                      "unitPrecisions": {
                        "data": [
                          {
                            "type": "productunitprecisions",
                            "id": "454"
                          },
                          {
                            "type": "productunitprecisions",
                            "id": "455"
                          }
                        ]
                      }
                    }
                  },
                  "included": [
                    {
                      "meta": {
                        "update": true
                      },
                      "type": "entityfieldfallbackvalues",
                      "id": "466",
                      "attributes": {
                        "fallback": null,
                        "scalarValue": "0",
                        "arrayValue": null
                      }
                    },
                    {
                      "meta": {
                        "update": true
                      },
                      "type": "localizedfallbackvalues",
                      "id": "907",
                      "attributes": {
                        "fallback": null,
                        "string": "test-prod-slug-updated",
                        "text": null
                      }
                    },
                    {
                      "type": "productunitprecisions",
                      "id": "453",
                      "attributes": {
                        "precision": "7",
                        "conversionRate": "5",
                        "sell": "0"
                      },
                      "relationships": {
                        "unit": {
                          "data": {
                            "type": "productunits",
                            "id": "set"
                          }
                        }
                      }
                    }
                  ]
                }'
            ),
            new Response(
                200,
                [],
                $this->getProductResponse()
            )
        );

        $product = $this->apiClient->products->update([
          'data' => [
            'type' => 'products',
            'id' => '1',
            'attributes' => [
              'sku' => 'test-api-1',
              'status' => 'enabled',
              'variantFields' => [
              ],
              'productType' => 'simple',
              'featured' => true,
              'newArrival' => false,
            ],
            'relationships' => [
              'owner' => [
                'data' => [
                  'type' => 'businessunits',
                  'id' => '1',
                ],
              ],
              'organization' => [
                'data' => [
                  'type' => 'organizations',
                  'id' => '1',
                ],
              ],
              'taxCode' => [
                'data' => [
                  'type' => 'producttaxcodes',
                  'id' => '2',
                ],
              ],
              'attributeFamily' => [
                'data' => [
                  'type' => 'attributefamilies',
                  'id' => '1',
                ],
              ],
              'inventory_status' => [
                'data' => [
                  'type' => 'prodinventorystatuses',
                  'id' => 'in_stock',
                ],
              ],
              'pageTempalte' => [
                'data' => [
                  'type' => 'entityfieldfallbackvalues',
                  'id' => '355',
                ],
              ],
              'manageInventory' => [
                'data' => [
                  'type' => 'entityfieldfallbackvalues',
                  'id' => '466',
                ],
              ],
              'category' => [
                'data' => [
                  'type' => 'categories',
                  'id' => '4',
                ],
              ],
              'names' => [
                'data' => [
                  0 => [
                    'type' => 'productnames',
                    'id' => '807',
                  ],
                ],
              ],
              'slugPrototypes' => [
                'data' => [
                  0 => [
                    'type' => 'localizedfallbackvalues',
                    'id' => '907',
                  ],
                ],
              ],
              'primaryUnitPrecision' => [
                'data' => [
                  'type' => 'productunitprecisions',
                  'id' => '453',
                ],
              ],
              'unitPrecisions' => [
                'data' => [
                  0 => [
                    'type' => 'productunitprecisions',
                    'id' => '454',
                  ],
                  1 => [
                    'type' => 'productunitprecisions',
                    'id' => '455',
                  ],
                ],
              ],
            ],
          ],
          'included' => [
            0 => [
              'meta' => [
                'update' => true,
              ],
              'type' => 'entityfieldfallbackvalues',
              'id' => '466',
              'attributes' => [
                'fallback' => null,
                'scalarValue' => '0',
                'arrayValue' => null,
              ],
            ],
            1 => [
              'meta' => [
                'update' => true,
              ],
              'type' => 'localizedfallbackvalues',
              'id' => '907',
              'attributes' => [
                'fallback' => null,
                'string' => 'test-prod-slug-updated',
                'text' => null,
              ],
            ],
            2 => [
              'type' => 'productunitprecisions',
              'id' => '453',
              'attributes' => [
                'precision' => '7',
                'conversionRate' => '5',
                'sell' => '0',
              ],
              'relationships' => [
                'unit' => [
                  'data' => [
                    'type' => 'productunits',
                    'id' => 'set',
                  ],
                ],
              ],
            ],
          ],
        ]);

        $this->assertProduct($product);
    }

    /**
     * @return void
     * @throws IncompatiblePlatform
     * @throws UnrecognizedClientException
     */
    public function testGetProduct(): void
    {
        $this->mockApiCall(
            new Request(
                "GET",
                "/admin/api/products/1",
                [],
                ''
            ),
            new Response(
                200,
                [],
                $this->getProductResponse()
            )
        );

        $product = $this->apiClient->products->get("1");

        $this->assertProduct($product);
    }

    /**
     * @return void
     * @throws IncompatiblePlatform
     * @throws UnrecognizedClientException
     */
    public function testListProduct(): void
    {
        $this->mockApiCall(
            new Request(
                "GET",
                "/admin/api/products",
                [],
                ''
            ),
            new Response(
                200,
                [],
                $this->getProductCollectionResponse()
            )
        );

        $products = $this->apiClient->products->page();

        $this->assertInstanceOf(ProductCollection::class, $products);

        foreach ($products as $product) {
            $this->assertInstanceOf(Product::class, $product);
            $this->assertEquals("products", $product->type);
            $this->assertNotEmpty($product->attributes);
        }

        $linksObject = (object)[
            "self" => "https://myoroproxy.local/admin/api/products",
            "first" => "https://myoroproxy.local/admin/api/products?page%5Bsize%5D=1&sort=id",
            "prev" => "https://myoroproxy.local/admin/api/products?page%5Bsize%5D=1&sort=id",
            "next" => "https://myoroproxy.local/admin/api/products?page%5Bnumber%5D=2&page%5Bsize%5D=1&sort=id",
        ];
        $this->assertEquals($linksObject, $products->links);
    }

    /**
     * @return void
     * @throws IncompatiblePlatform
     * @throws UnrecognizedClientException
     */
    public function testDeletePrice(): void
    {
        $this->mockApiCall(
            new Request(
                "DELETE",
                "/admin/api/products?filter%5Bid%5D=1",
                [],
                '{}'
            ),
            new Response(204)
        );

        $result = $this->apiClient->products->delete(['id' => '1']);
        $this->assertNull($result);
    }


    /**
     * @param $product
     * @return void
     */
    protected function assertProduct($product): void
    {
        $this->assertInstanceOf(Product::class, $product);

        $this->assertEquals("products", $product->type);
        $this->assertEquals("1", $product->id);

        $attributesObject = (object)[
            "availability_date" => "2018-01-01T00:00:00Z",
            "sku" => "test-api-1",
            "status" => "enabled",
            "variantFields" => [],
            "createdAt" => "2021-12-16T11:12:03Z",
            "updatedAt" => "2021-12-16T11:12:04Z",
            "productType" => "simple",
            "featured" => true,
            "newArrival" => false,
        ];
        $this->assertEquals($attributesObject, $product->attributes);

        $linkObject = (object)["self" => "https://myoroproxy.local/admin/api/products/1"];
        $this->assertEquals($linkObject, $product->links);

        $relationshipsNameObject = (object)[
            "links" => (object)[
                "self" => "https://myoroproxy.local/admin/api/products/1/relationships/names",
                "related" => "https://myoroproxy.local/admin/api/products/1/names",
            ],
            "data" => [
              (object)[
                    "type" => "productnames",
                    "id" => "10",
              ],
              (object)[
                "type" => "productnames",
                "id" => "11",
              ],
              (object)[
                "type" => "productnames",
                "id" => "12",
              ],
            ],
        ];
        $this->assertEquals($relationshipsNameObject, $product->relationships->names);
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

    /**
     * @return string
     */
    protected function getProductCollectionResponse(): string
    {
        return '{
          "data": [
            {
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
            }
          ],
          "links": {
            "self": "https://myoroproxy.local/admin/api/products",
            "first": "https://myoroproxy.local/admin/api/products?page%5Bsize%5D=1&sort=id",
            "prev": "https://myoroproxy.local/admin/api/products?page%5Bsize%5D=1&sort=id",
            "next": "https://myoroproxy.local/admin/api/products?page%5Bnumber%5D=2&page%5Bsize%5D=1&sort=id"            
          }
        }';
    }
}
