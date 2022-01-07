<?php

use Digitalprint\Oro\Api\Exceptions\IncompatiblePlatform;
use Digitalprint\Oro\Api\Exceptions\UnrecognizedClientException;
use Digitalprint\Oro\Api\Resources\User;
use Digitalprint\Oro\Api\Resources\UserCollection;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Tests\Digitalprint\Oro\Api\Endpoints\BaseEndpointTest;

class UserEndpointTest extends BaseEndpointTest
{
    /**
     * @return void
     * @throws IncompatiblePlatform
     * @throws UnrecognizedClientException
     */
    public function testCreateUser(): void
    {
        $this->mockApiCall(
            new Request(
                "POST",
                "/admin/api/users",
                [],
                '{
                  "data": {
                    "type": "users",
                    "attributes": {
                      "username": "testapiuser",
                      "email": "testuser@myoroproxy.local",
                      "firstName": "Bob",
                      "lastName": "Fedeson",
                      "password": "Password000!"
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
                      }
                    }
                  }
                }'
            ),
            new Response(
                201,
                [],
                $this->getUserResponse()
            )
        );

        $user = $this->apiClient->users->create([
          'data' => [
            'type' => 'users',
            'attributes' => [
              'username' => 'testapiuser',
              'email' => 'testuser@myoroproxy.local',
              'firstName' => 'Bob',
              'lastName' => 'Fedeson',
              'password' => 'Password000!',
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
            ],
          ],
        ]);

        $this->assertUser($user);
    }

    /**
     * @return void
     * @throws IncompatiblePlatform
     * @throws UnrecognizedClientException
     */
    public function testUpdateUser(): void
    {
        $this->mockApiCall(
            new Request(
                "PATCH",
                "/admin/api/users",
                [],
                '{
                  "data": {
                    "meta": {
                      "update": true
                    },
                    "type": "addresses",
                    "id": "3",
                    "attributes": {
                      "city": "Dallas"
                    }
                  }
                }'
            ),
            new Response(
                200,
                [],
                $this->getUserResponse()
            )
        );

        $user = $this->apiClient->users->update([
          'data' => [
            'meta' => [
              'update' => true,
            ],
            'type' => 'addresses',
            'id' => "3",
            'attributes' => [
              'city' => 'Dallas',
            ],
          ],
        ]);

        $this->assertUser($user);
    }

    /**
     * @return void
     * @throws IncompatiblePlatform
     * @throws UnrecognizedClientException
     */
    public function testGetUsers(): void
    {
        $this->mockApiCall(
            new Request(
                "GET",
                "/admin/api/users/1",
                [],
                ''
            ),
            new Response(
                200,
                [],
                $this->getUserResponse()
            )
        );

        $user = $this->apiClient->users->get("1");

        $this->assertUser($user);
    }

    /**
     * @return void
     * @throws IncompatiblePlatform
     * @throws UnrecognizedClientException
     */
    public function testListUser(): void
    {
        $this->mockApiCall(
            new Request(
                "GET",
                "/admin/api/users",
                [],
                ''
            ),
            new Response(
                200,
                [],
                $this->getUserCollectionResponse()
            )
        );

        $users = $this->apiClient->users->page();

        $this->assertInstanceOf(UserCollection::class, $users);

        foreach ($users as $user) {
            $this->assertInstanceOf(User::class, $user);
            $this->assertEquals("users", $user->type);
            $this->assertNotEmpty($user->attributes);
        }

        $linksObject = (object)[
            "self" => "https://myoroproxy.local/admin/api/users",
            "first" => "https://myoroproxy.local/admin/api/users?page%5Bsize%5D=1&sort=id",
            "prev" => "https://myoroproxy.local/admin/api/users?page%5Bsize%5D=1&sort=id",
            "next" => "https://myoroproxy.local/admin/api/users?page%5Bnumber%5D=2&page%5Bsize%5D=1&sort=id",
        ];
        $this->assertEquals($linksObject, $users->links);
    }

    /**
     * @return void
     * @throws IncompatiblePlatform
     * @throws UnrecognizedClientException
     */
    public function testDeleteUser(): void
    {
        $this->mockApiCall(
            new Request(
                "DELETE",
                "/admin/api/users?filter%5Bid%5D=1",
                [],
                '{}'
            ),
            new Response(204)
        );

        $result = $this->apiClient->users->delete(['id' => '1']);
        $this->assertNull($result);
    }

    /**
     * @param $user
     * @return void
     */
    protected function assertUser($user): void
    {
        $this->assertInstanceOf(User::class, $user);

        $this->assertEquals("users", $user->type);
        $this->assertEquals("1", $user->id);

        $attributesObject = (object)[
            "phone" => null,
            "title" => null,
            "googleId" => null,
            "failed_login_count" => 0,
            "password_expires_at" => null,
            "ldap_distinguished_names" => null,
            "username" => "admin",
            "email" => "oro@myoroproxy.local",
            "namePrefix" => null,
            "firstName" => "Oro",
            "middleName" => null,
            "lastName" => "Admin",
            "nameSuffix" => null,
            "birthday" => null,
            "enabled" => true,
            "lastLogin" => "2022-01-05T12:28:27Z",
            "createdAt" => "2021-11-22T12:24:17Z",
            "updatedAt" => "2021-11-25T13:54:42Z",
            "loginCount" => 17,
            "passwordRequestedAt" => null,
            "passwordChangedAt" => "2021-11-25T13:42:49Z",
            "emails" => [],
        ];
        $this->assertEquals($attributesObject, $user->attributes);

        $relationshipsUserrolesObject = (object)[
            "links" => (object)[
              "self" => "https://myoroproxy.local/admin/api/users/1/relationships/roles",
              "related" => "https://myoroproxy.local/admin/api/users/1/roles",
            ],
            "data" => [
                (object) [
                    "type" => "userroles",
                    "id" => "3",
                ],
            ],
        ];
        $this->assertEquals($relationshipsUserrolesObject, $user->relationships->roles);
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

    /**
     * @return string
     */
    protected function getUserCollectionResponse(): string
    {
        return '{
          "data": [
            {
              "type": "users",
              "id": "1",
              "links": {
                "self": "https://myoroproxy.local/admin/api/users/1"
              },
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
          ],
          "links": {
            "self": "https://myoroproxy.local/admin/api/users",
            "first": "https://myoroproxy.local/admin/api/users?page%5Bsize%5D=1&sort=id",
            "prev": "https://myoroproxy.local/admin/api/users?page%5Bsize%5D=1&sort=id",
            "next": "https://myoroproxy.local/admin/api/users?page%5Bnumber%5D=2&page%5Bsize%5D=1&sort=id"            
          }
        }';
    }
}
