<?php

namespace Tests\Digitalprint\Oro\Api\Endpoints;

use Digitalprint\Oro\Api\Exceptions\ApiException;
use Digitalprint\Oro\Api\Exceptions\IncompatiblePlatform;
use Digitalprint\Oro\Api\Exceptions\UnrecognizedClientException;
use Digitalprint\Oro\Api\Resources\User;
use Digitalprint\Oro\Api\Resources\Userrole;
use Digitalprint\Oro\Api\Resources\UserroleCollection;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use JsonException;

class UserroleEndpointTest extends BaseEndpointTest
{
    /**
     * @return void
     * @throws IncompatiblePlatform
     * @throws UnrecognizedClientException
     * @throws ApiException
     * @throws JsonException
     */
    public function testCreateUserrole(): void
    {
        $this->mockApiCall(
            new Request(
                "POST",
                "/admin/api/userroles",
                [],
                '{
                  "data": {
                    "type": "userroles",
                    "attributes": {
                      "extend_description": "A guest role",
                      "role": "IS_AUTHENTICATED_AT_FIRST",
                      "label": "Guest"
                    },
                    "relationships": {
                      "organization": {
                        "data": {
                          "type": "organizations",
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
                $this->getUserroleResponse()
            )
        );

        $userrole = $this->apiClient->userroles->create([
          'data' => [
            'type' => 'userroles',
            'attributes' => [
              'extend_description' => 'A guest role',
              'role' => 'IS_AUTHENTICATED_AT_FIRST',
              'label' => 'Guest',
            ],
            'relationships' => [
              'organization' => [
                'data' => [
                  'type' => 'organizations',
                  'id' => '1',
                ],
              ],
            ],
          ],
        ]);

        $this->assertUserrole($userrole);
    }

    /**
     * @return void
     * @throws ApiException
     * @throws IncompatiblePlatform
     * @throws JsonException
     * @throws UnrecognizedClientException
     */
    public function testUpdateUserrole(): void
    {
        $this->mockApiCall(
            new Request(
                "PATCH",
                "/admin/api/userroles",
                [],
                '{
                  "data": {
                    "type": "userroles",
                    "id": "1",
                    "attributes": {
                      "extend_description": "A guest role new",
                      "role": "IS_AUTHENTICATED_AT_FIRST",
                      "label": "Guest"
                    },
                    "relationships": {
                      "organization": {
                        "data": {
                          "type": "organizations",
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
                $this->getUserroleResponse()
            )
        );

        $userrole = $this->apiClient->userroles->update([
          'data' => [
            'type' => 'userroles',
            'id' => '1',
            'attributes' => [
              'extend_description' => 'A guest role new',
              'role' => 'IS_AUTHENTICATED_AT_FIRST',
              'label' => 'Guest',
            ],
            'relationships' => [
              'organization' => [
                'data' => [
                  'type' => 'organizations',
                  'id' => '1',
                ],
              ],
            ],
          ],
        ]);

        $this->assertUserrole($userrole);
    }

    /**
     * @return void
     * @throws ApiException
     * @throws IncompatiblePlatform
     * @throws UnrecognizedClientException
     */
    public function testGetUserrole(): void
    {
        $this->mockApiCall(
            new Request(
                "GET",
                "/admin/api/userroles/1",
                [],
                ''
            ),
            new Response(
                200,
                [],
                $this->getUserroleResponse()
            )
        );

        $userrole = $this->apiClient->userroles->get("1");

        $this->assertUserrole($userrole);
    }

    /**
     * @return void
     * @throws IncompatiblePlatform
     * @throws JsonException
     * @throws UnrecognizedClientException
     */
    public function testGetUserrolesOnUserresource(): void
    {
        $this->mockApiCall(
            new Request(
                "GET",
                "/admin/api/users/1/roles",
                [],
                ''
            ),
            new Response(
                200,
                [],
                $this->getUserroleCollectionResponse()
            )
        );

        $user = $this->getUser();

        $userroles = $user->roles();

        $this->assertInstanceOf(UserroleCollection::class, $userroles);
        $this->assertUserrole($userroles[0]);
    }

    /**
     * @return void
     * @throws ApiException
     * @throws IncompatiblePlatform
     * @throws UnrecognizedClientException
     */
    public function testListUserrole(): void
    {
        $this->mockApiCall(
            new Request(
                "GET",
                "/admin/api/userroles",
                [],
                ''
            ),
            new Response(
                200,
                [],
                $this->getUserroleCollectionResponse()
            )
        );

        $userroles = $this->apiClient->userroles->page();

        $this->assertInstanceOf(UserroleCollection::class, $userroles);

        foreach ($userroles as $userrole) {
            $this->assertInstanceOf(Userrole::class, $userrole);
            $this->assertEquals("userroles", $userrole->type);
            $this->assertNotEmpty($userrole->attributes);
        }

        $linksObject = (object)[
            "self" => "https://myoroproxy.local/admin/api/userroles",
            "first" => "https://myoroproxy.local/admin/api/userroles?page%5Bsize%5D=1&sort=id",
            "prev" => "https://myoroproxy.local/admin/api/userroles?page%5Bsize%5D=1&sort=id",
            "next" => "https://myoroproxy.local/admin/api/userroles?page%5Bnumber%5D=2&page%5Bsize%5D=1&sort=id",
        ];
        $this->assertEquals($linksObject, $userroles->links);
    }

    /**
     * @return void
     * @throws ApiException
     * @throws IncompatiblePlatform
     * @throws UnrecognizedClientException
     */
    public function testDeleteUserrole(): void
    {
        $this->mockApiCall(
            new Request(
                "DELETE",
                "/admin/api/userroles?filter%5Bid%5D=1",
                [],
                '{}'
            ),
            new Response(204)
        );

        $result = $this->apiClient->userroles->delete(['id' => '1']);
        $this->assertNull($result);
    }

    /**
     * @param $userrole
     * @return void
     */
    protected function assertUserrole($userrole): void
    {
        $this->assertInstanceOf(Userrole::class, $userrole);

        $this->assertEquals("userroles", $userrole->type);
        $this->assertEquals("1", $userrole->id);

        $attributesObject = (object)[
            "extend_description" => null,
            "role" => "IS_AUTHENTICATED_ANONYMOUSLY",
            "label" => "Anonymous",
        ];
        $this->assertEquals($attributesObject, $userrole->attributes);

        $linkObject = (object)["self" => "https://myoroproxy.local/admin/api/userroles/1"];
        $this->assertEquals($linkObject, $userrole->links);

        $relationshipsCountryObject = (object)[
          "links" => (object)[
            "self" => "https://myoroproxy.local/admin/api/userroles/1/relationships/users",
            "related" => "https://myoroproxy.local/admin/api/userroles/1/users",
          ],
          "data" => [],
        ];
        $this->assertEquals($relationshipsCountryObject, $userrole->relationships->users);
    }

    /**
     * @return string
     */
    protected function getUserroleResponse(): string
    {
        return '{
          "data": {
            "type": "userroles",
            "id": "1",
            "links": {
              "self": "https://myoroproxy.local/admin/api/userroles/1"
            },
            "attributes": {
              "extend_description": null,
              "role": "IS_AUTHENTICATED_ANONYMOUSLY",
              "label": "Anonymous"
            },
            "relationships": {
              "users": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/userroles/1/relationships/users",
                  "related": "https://myoroproxy.local/admin/api/userroles/1/users"
                },
                "data": []
              },
              "organization": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/userroles/1/relationships/organization",
                  "related": "https://myoroproxy.local/admin/api/userroles/1/organization"
                },
                "data": null
              }
            }
          },
          "links": {
            "self": "https://myoroproxy.local/admin/api/userroles"
          }
        }';
    }

    /**
     * @return string
     */
    protected function getUserroleCollectionResponse(): string
    {
        return '{
          "data": [
            {
              "type": "userroles",
              "id": "1",
              "links": {
                "self": "https://myoroproxy.local/admin/api/userroles/1"
              },
              "attributes": {
                "extend_description": null,
                "role": "IS_AUTHENTICATED_ANONYMOUSLY",
                "label": "Anonymous"
              },
              "relationships": {
                "users": {
                  "links": {
                    "self": "https://myoroproxy.local/admin/api/userroles/1/relationships/users",
                    "related": "https://myoroproxy.local/admin/api/userroles/1/users"
                  },
                  "data": []
                },
                "organization": {
                  "links": {
                    "self": "https://myoroproxy.local/admin/api/userroles/1/relationships/organization",
                    "related": "https://myoroproxy.local/admin/api/userroles/1/organization"
                  },
                  "data": null
                }
              }
            }
          ],
          "links": {
            "self": "https://myoroproxy.local/admin/api/userroles",
            "first": "https://myoroproxy.local/admin/api/userroles?page%5Bsize%5D=1&sort=id",
            "prev": "https://myoroproxy.local/admin/api/userroles?page%5Bsize%5D=1&sort=id",
            "next": "https://myoroproxy.local/admin/api/userroles?page%5Bnumber%5D=2&page%5Bsize%5D=1&sort=id"            
          }
        }';
    }

    /**
     * @return mixed
     * @throws JsonException
     */
    protected function getUser(): mixed
    {
        $userJson = $this->getUserResponse();

        return $this->copy(json_decode($userJson, false, 512, JSON_THROW_ON_ERROR)->data, new User($this->apiClient));
    }

    /**
     * @return string
     */
    protected function getUserResponse(): string
    {
        return '{
          "data": {
            "type": "users",
            "id": "1",
            "attributes": {
              "phone": null,
              "title": null,
              "googleId": null,
              "failed_login_count": 0,
              "password_expires_at": null,
              "ldap_distinguished_names": null,
              "username": "admin",
              "email": "oro@myoroproxy.local",
              "namePrefix": null,
              "firstName": "Oro",
              "middleName": null,
              "lastName": "Admin",
              "nameSuffix": null,
              "birthday": null,
              "enabled": true,
              "lastLogin": "2022-01-05T12:28:27Z",
              "createdAt": "2021-11-22T12:24:17Z",
              "updatedAt": "2021-11-25T13:54:42Z",
              "loginCount": 17,
              "passwordRequestedAt": null,
              "passwordChangedAt": "2021-11-25T13:42:49Z",
              "emails": []
            },
            "relationships": {
              "groups": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/users/1/relationships/groups",
                  "related": "https://myoroproxy.local/admin/api/users/1/groups"
                },              
                "data": []
              },
              "owner": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/users/1/relationships/owner",
                  "related": "https://myoroproxy.local/admin/api/users/1/owner"
                },            
                "data": {
                  "type": "businessunits",
                  "id": "1"
                }
              },
              "businessUnits": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/users/1/relationships/businessUnits",
                  "related": "https://myoroproxy.local/admin/api/users/1/businessUnits"
                },              
                "data": [
                  {
                    "type": "businessunits",
                    "id": "1"
                  }
                ]
              },
              "organizations": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/users/1/relationships/organizations",
                  "related": "https://myoroproxy.local/admin/api/users/1/organizations"
                },              
                "data": [
                  {
                    "type": "organizations",
                    "id": "1"
                  },
                  {
                    "type": "organizations",
                    "id": "4"
                  }
                ]
              },
              "roles": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/users/1/relationships/roles",
                  "related": "https://myoroproxy.local/admin/api/users/1/roles"
                },             
                "data": [
                  {
                    "type": "userroles",
                    "id": "3"
                  }
                ]
              },
              "organization": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/users/1/relationships/organization",
                  "related": "https://myoroproxy.local/admin/api/users/1/organization"
                },              
                "data": {
                  "type": "organizations",
                  "id": "1"
                }
              },
              "avatar": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/users/1/relationships/avatar",
                  "related": "https://myoroproxy.local/admin/api/users/1/avatar"
                },              
                "data": null
              },
              "auth_status": {
                "links": {
                  "self": "https://myoroproxy.local/admin/api/users/1/relationships/auth_status",
                  "related": "https://myoroproxy.local/admin/api/users/1/auth_status"
                },              
                "data": {
                  "type": "userauthstatuses",
                  "id": "active"
                }
              }
            }
          }
        }';
    }
}
