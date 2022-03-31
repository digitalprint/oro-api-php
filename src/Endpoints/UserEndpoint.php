<?php

namespace Digitalprint\Oro\Api\Endpoints;

use Digitalprint\Oro\Api\Exceptions\ApiException;
use Digitalprint\Oro\Api\Resources\User;
use Digitalprint\Oro\Api\Resources\UserCollection;
use JsonException;
use stdClass;

class UserEndpoint extends CollectionEndpointAbstract
{
    /**
     * @var string
     */
    protected string $resourcePath = "api/users";

    /**
     * @param array $included
     * @return User
     */
    protected function getResourceObject(array $included = []): User
    {
        return new User($this->client, $included);
    }

    /**
     * @param stdClass $links
     * @param array $included
     * @return UserCollection
     */
    protected function getResourceCollectionObject(stdClass $links, array $included = []): UserCollection
    {
        return new UserCollection($this->client, $links, $included);
    }

    /**
     * @param array|null $data
     * @return User
     * @throws ApiException
     * @throws JsonException
     */
    public function create(array $data = null): User
    {
        return $this->rest_create($data);
    }

    /**
     * @param string $userId
     * @param array $filter
     * @return User
     * @throws ApiException
     */
    public function get(string $userId, array $filter = []): User
    {
        return $this->rest_read($userId, $filter);
    }

    /**
     * @param string|null $number
     * @param string|null $size
     * @param array $filter
     *
     * @return UserCollection
     * @throws ApiException
     */
    public function page(string $number = null, string $size = null, array $filter = []): UserCollection
    {
        return $this->rest_list($number, $size, $filter);
    }

    /**
     * @param array $data
     * @return User
     * @throws ApiException
     * @throws JsonException
     */
    public function update(array $data = []): User
    {
        return $this->rest_update($data);
    }

    /**
     * @param array $filter
     * @return User|null
     * @throws ApiException
     */
    public function delete(array $filter = []): ?User
    {
        return $this->rest_delete($filter);
    }
}
