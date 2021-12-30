<?php

namespace Oro\Api\Resources;

use Oro\Api\Exceptions\ApiException;
use Oro\Api\OroApiClient;

class User extends BaseResource
{
    /**
     * @var string
     */
    public string $resource;

    /**
     * @var string
     */
    public string $type;

    /**
     * @var string
     */
    public string $id;

    /**
     * @var object
     */
    public object $attributes;

    /**
     * @var object
     */
    public object $relationships;

    /**
     * @return BaseResource
     * @throws ApiException
     */
    public function get(): BaseResource
    {
        $result = $this->client->performHttpCallToFullUrl(
            OroApiClient::HTTP_GET,
            $this->links->self
        );

        return ResourceFactory::createFromApiResult(
            $result->data,
            new User($this->client)
        );
    }

    /**
     * @param array $body
     * @return BaseResource|null
     * @throws ApiException
     */
    public function update(array $body = []): ?BaseResource
    {
        $result = $this->client->performHttpCallToFullUrl(
            OroApiClient::HTTP_PATCH,
            $this->links->self,
            json_encode($body)
        );

        if ($result === null) {
            return null;
        }

        return ResourceFactory::createFromApiResult(
            $result->data,
            new User($this->client)
        );
    }

    /**
     * @return null
     * @throws ApiException
     */
    public function delete()
    {
        if (! isset($this->links->self)) {
            return $this;
        }

        return $this->client->performHttpCallToFullUrl(
            OroApiClient::HTTP_DELETE,
            $this->links->self
        );
    }

    /**
     * @return UserroleCollection
     * @throws ApiException
     */
    public function roles(): UserroleCollection
    {
        if (! isset($this->relationships->roles->links->related)) {
            return new UserroleCollection($this->client, null);
        }

        $result = $this->client->performHttpCallToFullUrl(
            OroApiClient::HTTP_GET,
            $this->relationships->roles->links->related
        );

        return ResourceFactory::createCursorResourceCollection(
            $this->client,
            $result->data,
            Userrole::class,
            $result->links
        );
    }
}
