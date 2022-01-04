<?php

namespace Digitalprint\Oro\Api\Endpoints;

use Digitalprint\Oro\Api\Exceptions\ApiException;
use Digitalprint\Oro\Api\Resources\Authorization;
use Digitalprint\Oro\Api\Resources\BaseCollection;
use Digitalprint\Oro\Api\Resources\BaseResource;
use Digitalprint\Oro\Api\Resources\ResourceFactory;

class AuthorizationEndpoint extends EndpointAbstract
{
    /**
     * @var string
     */
    protected string $resourcePath = "oauth2-token";

    /**
     * @param $count
     * @param $links
     * @return BaseCollection
     */
    protected function getResourceCollectionObject($count, $links): BaseCollection
    {
        throw new \BadMethodCallException('not implemented');
    }

    /**
     * @return BaseResource
     */
    protected function getResourceObject(): BaseResource
    {
        return new Authorization($this->client);
    }

    /**
     * @param $parameters
     * @return BaseResource
     * @throws ApiException
     */
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
