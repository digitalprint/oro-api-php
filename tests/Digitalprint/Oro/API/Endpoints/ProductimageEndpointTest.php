<?php

use Digitalprint\Oro\Api\Exceptions\IncompatiblePlatform;
use Digitalprint\Oro\Api\Exceptions\UnrecognizedClientException;
use Digitalprint\Oro\Api\Resources\Product;
use Digitalprint\Oro\Api\Resources\Productimage;
use Digitalprint\Oro\Api\Resources\ProductimageCollection;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Tests\Digitalprint\Oro\Api\Endpoints\BaseEndpointTest;

class ProductimageEndpointTest extends BaseEndpointTest
{
    /**
     * @return void
     * @throws IncompatiblePlatform
     * @throws UnrecognizedClientException
     */
    public function testCreateProductimage(): void
    {
        $this->mockApiCall(
            new Request(
                "POST",
                "/admin/api/productimages",
                [],
                '{
                  "data": {
                    "type": "productimages",
                    "id": "product-image-1",
                    "relationships": {
                      "product": {
                        "data": {
                          "type": "products",
                          "id": "1"
                        }
                      },
                      "types": {
                        "data": [
                          {
                            "type": "productimagetypes",
                            "id": "product-image-type-1"
                          }
                        ]
                      },
                      "image": {
                        "data": {
                          "type": "files",
                          "id": "file-1"
                        }
                      }
                    }
                  },
                  "included": [
                    {
                      "type": "files",
                      "id": "file-1",
                      "attributes": {
                        "mimeType": "image/jpeg",
                        "originalFilename": "onedot.jpg",
                        "fileSize": 631,
                        "content": "/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAIBAQIBAQICAgICAgICAwUDAwMDAwYEBAMFBwYHBwcGBwcICQsJCAgKCAcHCg0KCgsMDAwMBwkODw0MDgsMDAz/2wBDAQICAgMDAwYDAwYMCAcIDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAz/wAARCAABAAEDASIAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwD+f+iiigD/2Q=="
                      }
                    },
                    {
                      "type": "productimagetypes",
                      "id": "product-image-type-1",
                      "attributes": {
                        "productImageTypeType": "main"
                      },
                      "relationships": {
                        "productImage": {
                          "data": {
                            "type": "productimages",
                            "id": "product-image-1"
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
                $this->getProductimageResponse()
            )
        );

        $productimage = $this->apiClient->productimages->create([
          'data' => [
            'type' => 'productimages',
            'id' => 'product-image-1',
            'relationships' => [
              'product' => [
                'data' => [
                  'type' => 'products',
                  'id' => '1',
                ],
              ],
              'types' => [
                'data' => [
                  0 => [
                    'type' => 'productimagetypes',
                    'id' => 'product-image-type-1',
                  ],
                ],
              ],
              'image' => [
                'data' => [
                  'type' => 'files',
                  'id' => 'file-1',
                ],
              ],
            ],
          ],
          'included' => [
            0 => [
              'type' => 'files',
              'id' => 'file-1',
              'attributes' => [
                'mimeType' => 'image/jpeg',
                'originalFilename' => 'onedot.jpg',
                'fileSize' => 631,
                'content' => '/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAIBAQIBAQICAgICAgICAwUDAwMDAwYEBAMFBwYHBwcGBwcICQsJCAgKCAcHCg0KCgsMDAwMBwkODw0MDgsMDAz/2wBDAQICAgMDAwYDAwYMCAcIDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAz/wAARCAABAAEDASIAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwD+f+iiigD/2Q==',
              ],
            ],
            1 => [
              'type' => 'productimagetypes',
              'id' => 'product-image-type-1',
              'attributes' => [
                'productImageTypeType' => 'main',
              ],
              'relationships' => [
                'productImage' => [
                  'data' => [
                    'type' => 'productimages',
                    'id' => 'product-image-1',
                  ],
                ],
              ],
            ],
          ],
        ]);

        $this->assertProductimage($productimage);
    }

    /**
     * @return void
     * @throws IncompatiblePlatform
     * @throws UnrecognizedClientException
     */
    public function testUpdateProductimage(): void
    {
        $this->mockApiCall(
            new Request(
                "PATCH",
                "/admin/api/productimages",
                [],
                '{
                  "data": {
                    "type": "productimages",
                    "id": "1",
                    "attributes": {
                      "updatedAt": "2017-09-07T08:14:35Z"
                    },
                    "relationships": {
                      "product": {
                        "data": {
                          "type": "products",
                          "id": "1"
                        }
                      },
                      "types": {
                        "data": [
                          {
                            "type": "productimagetypes",
                            "id": "1"
                          },
                          {
                            "type": "productimagetypes",
                            "id": "2"
                          },
                          {
                            "type": "productimagetypes",
                            "id": "3"
                          }
                        ]
                      },
                      "image": {
                        "data": {
                          "type": "files",
                          "id": "1"
                        }
                      }
                    }
                  },
                  "included": [
                    {
                      "meta": {
                        "update": true
                      },
                      "type": "files",
                      "id": "1",
                      "attributes": {
                        "mimeType": "image/jpeg",
                        "originalFilename": "onedot.jpg",
                        "fileSize": 631,
                        "content": "/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAIBAQIBAQICAgICAgICAwUDAwMDAwYEBAMFBwYHBwcGBwcICQsJCAgKCAcHCg0KCgsMDAwMBwkODw0MDgsMDAz/2wBDAQICAgMDAwYDAwYMCAcIDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAz/wAARCAABAAEDASIAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwD+f+iiigD/2Q=="
                      }
                    }
                  ]
                }'
            ),
            new Response(
                200,
                [],
                $this->getProductimageResponse()
            )
        );

        $productimage = $this->apiClient->productimages->update([
          'data' => [
            'type' => 'productimages',
            'id' => '1',
            'attributes' => [
              'updatedAt' => '2017-09-07T08:14:35Z',
            ],
            'relationships' => [
              'product' => [
                'data' => [
                  'type' => 'products',
                  'id' => '1',
                ],
              ],
              'types' => [
                'data' => [
                  0 => [
                    'type' => 'productimagetypes',
                    'id' => '1',
                  ],
                  1 => [
                    'type' => 'productimagetypes',
                    'id' => '2',
                  ],
                  2 => [
                    'type' => 'productimagetypes',
                    'id' => '3',
                  ],
                ],
              ],
              'image' => [
                'data' => [
                  'type' => 'files',
                  'id' => '1',
                ],
              ],
            ],
          ],
          'included' => [
            0 => [
              'meta' => [
                'update' => true,
              ],
              'type' => 'files',
              'id' => '1',
              'attributes' => [
                'mimeType' => 'image/jpeg',
                'originalFilename' => 'onedot.jpg',
                'fileSize' => 631,
                'content' => '/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAIBAQIBAQICAgICAgICAwUDAwMDAwYEBAMFBwYHBwcGBwcICQsJCAgKCAcHCg0KCgsMDAwMBwkODw0MDgsMDAz/2wBDAQICAgMDAwYDAwYMCAcIDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAz/wAARCAABAAEDASIAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwD+f+iiigD/2Q==',
              ],
            ],
          ],
        ]);

        $this->assertProductimage($productimage);
    }

    /**
     * @return void
     * @throws IncompatiblePlatform
     * @throws UnrecognizedClientException
     */
    public function testGetProductimage(): void
    {
        $this->mockApiCall(
            new Request(
                "GET",
                "/admin/api/productimages/1",
                [],
                ''
            ),
            new Response(
                200,
                [],
                $this->getProductimageResponse()
            )
        );

        $productimage = $this->apiClient->productimages->get("1");

        $this->assertProductimage($productimage);
    }

    /**
     * @return void
     * @throws IncompatiblePlatform
     * @throws JsonException
     * @throws UnrecognizedClientException
     */
    public function testGetProductimageOnProductResource(): void
    {
        $this->mockApiCall(
            new Request(
                "GET",
                "/admin/api/products/1/images",
                [],
                ''
            ),
            new Response(
                200,
                [],
                $this->getProductimageCollectionResponse()
            )
        );

        $product = $this->getProduct(1);

        $productimages = $product->images();

        $this->assertProductimage($productimages[0]);
    }

    /**
     * @return void
     * @throws IncompatiblePlatform
     * @throws UnrecognizedClientException
     */
    public function testListProductimages(): void
    {
        $this->mockApiCall(
            new Request(
                "GET",
                "/admin/api/productimages",
                [],
                ''
            ),
            new Response(
                200,
                [],
                $this->getProductimageCollectionResponse()
            )
        );

        $productimages = $this->apiClient->productimages->page();

        $this->assertInstanceOf(ProductimageCollection::class, $productimages);

        foreach ($productimages as $productimage) {
            $this->assertInstanceOf(Productimage::class, $productimage);
            $this->assertEquals("productimages", $productimage->type);
            $this->assertNotEmpty($productimage->attributes);
        }

        $linksObject = (object)[
            "self" => "https://myoroproxy.local/admin/api/productimages",
            "first" => "https://myoroproxy.local/admin/api/productimages?page%5Bsize%5D=1&sort=id",
            "prev" => "https://myoroproxy.local/admin/api/productimages?page%5Bsize%5D=1&sort=id",
            "next" => "https://myoroproxy.local/admin/api/productimages?page%5Bnumber%5D=2&page%5Bsize%5D=1&sort=id",
        ];
        $this->assertEquals($linksObject, $productimages->links);
    }

    /**
     * @return void
     * @throws IncompatiblePlatform
     * @throws UnrecognizedClientException
     */
    public function testDeleteProductimage(): void
    {
        $this->mockApiCall(
            new Request(
                "DELETE",
                "/admin/api/productimages?filter%5Bid%5D=1",
                [],
                '{}'
            ),
            new Response(204)
        );

        $result = $this->apiClient->productimages->delete(['id' => '1']);
        $this->assertNull($result);
    }

    /**
     * @param $productimage
     * @return void
     */
    protected function assertProductimage($productimage): void
    {
        $this->assertInstanceOf(Productimage::class, $productimage);

        $this->assertEquals("productimages", $productimage->type);
        $this->assertEquals("1", $productimage->id);
        
        $attributesObject = (object)[
            "updatedAt" => "2022-01-05T11:41:41Z",
        ];
        $this->assertEquals($attributesObject, $productimage->attributes);

        $linkObject = (object)["self" => "https://myoroproxy.local/admin/api/productimages/1"];
        $this->assertEquals($linkObject, $productimage->links);

        $relationshipsProductObject = (object)[
            "links" => (object)[
                "self" => "https://myoroproxy.local/admin/api/productimages/1/relationships/product",
               "related" => "https://myoroproxy.local/admin/api/productimages/1/product",
            ],
            "data" => (object)[
                "type" => "products",
                "id" => "1",
            ],
        ];
        $this->assertEquals($relationshipsProductObject, $productimage->relationships->product);
    }

    /**
     * @return string
     */
    protected function getProductimageResponse(): string
    {
        return '{
          "data": {
            "type": "productimages",
            "id": "1",
            "links": {
              "self": "https://myoroproxy.local/admin/api/productimages/1"
            },
            "attributes": {
              "updatedAt": "2022-01-05T11:41:41Z"
            },
            "relationships": {
              "product": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/productimages/1/relationships/product",
                  "related": "https://myoroproxy.local/admin/api/productimages/1/product"
                },
                "data": {
                  "type": "products",
                  "id": "1"
                }
              },
              "types": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/productimages/1/relationships/types",
                  "related": "https://myoroproxy.local/admin/api/productimages/1/types"
                },
                "data": [
                  {
                    "type": "productimagetypes",
                    "id": "1"
                  }
                ]
              },
              "image": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/productimages/1/relationships/image",
                  "related": "https://myoroproxy.local/admin/api/productimages/1/image"
                },
                "data": {
                  "type": "files",
                  "id": "25"
                }
              }
            }
          },
          "links": {
            "self": "https://myoroproxy.local/admin/api/productimages"
          }
        }';
    }

    /**
     * @return string
     */
    protected function getProductimageCollectionResponse(): string
    {
        return '{
          "data": [
            {
              "type": "productimages",
              "id": "1",
              "links": {
                "self": "https://myoroproxy.local/admin/api/productimages/1"
              },
              "attributes": {
                "updatedAt": "2022-01-05T11:41:41Z"
              },
              "relationships": {
                "product": {
                  "links": {
                    "self": "https://myoroproxy.local/admin/api/productimages/1/relationships/product",
                    "related": "https://myoroproxy.local/admin/api/productimages/1/product"
                  },
                  "data": {
                    "type": "products",
                    "id": "1"
                  }
                },
                "types": {
                  "links": {
                    "self": "https://myoroproxy.local/admin/api/productimages/1/relationships/types",
                    "related": "https://myoroproxy.local/admin/api/productimages/1/types"
                  },
                  "data": [
                    {
                      "type": "productimagetypes",
                      "id": "1"
                    }
                  ]
                },
                "image": {
                  "links": {
                    "self": "https://myoroproxy.local/admin/api/productimages/1/relationships/image",
                    "related": "https://myoroproxy.local/admin/api/productimages/1/image"
                  },
                  "data": {
                    "type": "files",
                    "id": "25"
                  }
                }
              }
            }
          ],
          "links": {
            "self": "https://myoroproxy.local/admin/api/productimages",
            "first": "https://myoroproxy.local/admin/api/productimages?page%5Bsize%5D=1&sort=id",
            "prev": "https://myoroproxy.local/admin/api/productimages?page%5Bsize%5D=1&sort=id",
            "next": "https://myoroproxy.local/admin/api/productimages?page%5Bnumber%5D=2&page%5Bsize%5D=1&sort=id"            
          }
        }';
    }

    /**
     * @param $id
     * @return mixed
     */
    protected function getProduct($id): mixed
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
