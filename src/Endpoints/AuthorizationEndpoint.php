<?php

namespace Oro\Api\Endpoints;

use Oro\Api\Resources\Authorization;
use Oro\Api\Resources\BaseCollection;
use Oro\Api\Resources\BaseResource;
use Oro\Api\Resources\ResourceFactory;

class AuthorizationEndpoint extends EndpointAbstract
{
    protected string $resourcePath = "oauth2-token";

    protected function getResourceCollectionObject($count, $links): BaseCollection
    {
        throw new \BadMethodCallException('not implemented');
    }

    protected function getResourceObject(): BaseResource
    {
        return new Authorization($this->client);
    }

    public function create($parameters)
    {
        $body = $this->parseRequestBody(array_merge([
            'grant_type' => 'client_credentials',
        ], $parameters));

        $result = $this->client->performHttpCallAuthorization(
            self::REST_CREATE,
            $this->getResourcePath(),
            $body
        );

        return ResourceFactory::createFromApiResult($result, $this->getResourceObject());
    }
}
