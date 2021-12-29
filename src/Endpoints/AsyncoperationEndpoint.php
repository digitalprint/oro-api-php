<?php

namespace Oro\Api\Endpoints;

use Oro\Api\Exceptions\ApiException;
use Oro\Api\Resources\Asyncoperation;
use Oro\Api\Resources\BaseResource;

class AsyncoperationEndpoint extends EndpointAbstract
{
    protected string $resourcePath = "api/asyncoperations";

    /**
     * Get the object that is used by this API. Every API uses one type of object.
     *
     * @return \Oro\Api\Resources\BaseResource
     */
    protected function getResourceObject(): BaseResource
    {
        return new Asyncoperation($this->client);
    }

    /**
     * @param string $asyncoperationId
     * @param array $parameters
     * @return Asyncoperation
     * @throws ApiException
     */
    public function get(string $asyncoperationId, array $filter = []): Asyncoperation
    {
        return $this->rest_read($asyncoperationId, $filters);
    }

}
