<?php

namespace Digitalprint\Oro\Api\Endpoints;

use BadMethodCallException;
use Digitalprint\Oro\Api\Exceptions\ApiException;
use Digitalprint\Oro\Api\Resources\Authorization;
use Digitalprint\Oro\Api\Resources\BaseCollection;
use Digitalprint\Oro\Api\Resources\ResourceFactory;
use JsonException;

class AuthorizationEndpoint extends EndpointAbstract
{
    /**
     * @var string
     */
    protected string $resourcePath = "oauth2-token";

    /**
     * @return BaseCollection
     */
    protected function getResourceCollectionObject(): BaseCollection
    {
        throw new BadMethodCallException('not implemented');
    }

    /**
     * @param array $included
     * @return Authorization
     */
    protected function getResourceObject(array $included = []): Authorization
    {
        return new Authorization($this->client, $included);
    }

    /**
     * @param $parameters
     * @return Authorization
     * @throws ApiException
     * @throws JsonException
     */
    public function create($parameters): Authorization
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
