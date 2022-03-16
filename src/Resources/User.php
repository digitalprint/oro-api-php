<?php

namespace Digitalprint\Oro\Api\Resources;

use Digitalprint\Oro\Api\Exceptions\ApiException;
use Digitalprint\Oro\Api\OroApiClient;
use JsonException;

class User extends BaseResource
{

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
     * @throws JsonException
     */
    public function update(array $body = []): ?BaseResource
    {
        $result = $this->client->performHttpCallToFullUrl(
            OroApiClient::HTTP_PATCH,
            $this->links->self,
            json_encode($body, JSON_THROW_ON_ERROR)
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
