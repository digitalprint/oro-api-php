<?php

namespace Oro\Api\Endpoints;

use Oro\Api\Exceptions\ApiException;
use Oro\Api\Resources\BaseResource;
use Oro\Api\Resources\Asyncoperation;
use stdClass;

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
     * Retrieve an Asyncoperation from Oro.
     *
     * @param string $asyncoperationId
     *
     * @return \Oro\Api\Resources\BaseResource
     * @throws ApiException
     */
    public function get(string $asyncoperationId): BaseResource
    {
        return $this->rest_read($asyncoperationId, []);
    }

}
