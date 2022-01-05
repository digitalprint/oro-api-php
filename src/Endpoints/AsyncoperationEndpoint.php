<?php

namespace Digitalprint\Oro\Api\Endpoints;

use Digitalprint\Oro\Api\Resources\Asyncoperation;
use Digitalprint\Oro\Api\Resources\BaseResource;

class AsyncoperationEndpoint extends EndpointAbstract
{
    protected string $resourcePath = "api/asyncoperations";

    /**
     * Get the object that is used by this API. Every API uses one type of object.
     *
     * @return BaseResource
     */
    protected function getResourceObject(): BaseResource
    {
        return new Asyncoperation($this->client);
    }

    /**
     * @param string $asyncoperationId
     * @param array $filter
     * @return Asyncoperation
     */
    public function get(string $asyncoperationId, array $filter = []): Asyncoperation
    {
        return $this->rest_read($asyncoperationId, $filter);
    }
}
