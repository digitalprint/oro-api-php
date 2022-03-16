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
     * Get the object that is used by this API. Every API uses one type of object.
     *
     * @return User
     */
    protected function getResourceObject(): User
    {
        return new User($this->client);
    }

    /**
     * Get the collection object that is used by this API. Every API uses one type of collection object.
     *
     * @param stdClass $links
     *
     * @return UserCollection
     */
    protected function getResourceCollectionObject(stdClass $links): UserCollection
    {
        return new UserCollection($this->client, $links);
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
