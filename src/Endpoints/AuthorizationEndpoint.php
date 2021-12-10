<?php

namespace Oro\Api\Endpoints;

use Oro\Api\Exceptions\ApiException;
use Oro\Api\Resources\Authorization;
use Oro\Api\Resources\ResourceFactory;

class AuthorizationEndpoint extends EndpointAbstract
{
    protected $resourcePath = "oauth2-token";

    protected function getResourceCollectionObject($count, $links)
    {
        throw new \BadMethodCallException('not implemented');
    }

    protected function getResourceObject()
    {
        return new Authorization($this->client);
    }

    public function create($parameters)
    {

        $body = $this->parseRequestBody(array_merge([
            'grant_type' => 'client_credentials'
        ], $parameters));

        $result = $this->client->performHttpCallAuthorization(
            self::REST_CREATE,
            $this->getResourcePath(),
            $body
        );

        return ResourceFactory::createFromApiResult($result, $this->getResourceObject());

    }

}