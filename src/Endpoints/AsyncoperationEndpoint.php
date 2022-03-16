<?php

namespace Digitalprint\Oro\Api\Endpoints;

use Digitalprint\Oro\Api\Exceptions\ApiException;
use Digitalprint\Oro\Api\Resources\Asyncoperation;

class AsyncoperationEndpoint extends EndpointAbstract
{
    protected string $resourcePath = "api/asyncoperations";

    /**
     * Get the object that is used by this API. Every API uses one type of object.
     *
     * @return Asyncoperation
     */
    protected function getResourceObject(): Asyncoperation
    {
        return new Asyncoperation($this->client);
    }

    /**
     * @param string $asyncoperationId
     * @param array $filter
     * @return Asyncoperation
     * @throws ApiException
     */
    public function get(string $asyncoperationId, array $filter = []): Asyncoperation
    {
        return $this->rest_read($asyncoperationId, $filter);
    }
}
