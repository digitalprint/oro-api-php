<?php

namespace Digitalprint\Oro\Api\Endpoints;

use BadMethodCallException;
use Digitalprint\Oro\Api\Exceptions\ApiException;
use Digitalprint\Oro\Api\Resources\Asyncoperation;
use Digitalprint\Oro\Api\Resources\BaseCollection;

class AsyncoperationEndpoint extends EndpointAbstract
{
    protected string $resourcePath = "api/asyncoperations";

    /**
     * @param array $included
     * @return Asyncoperation
     */
    protected function getResourceObject(array $included = []): Asyncoperation
    {
        return new Asyncoperation($this->client, $included);
    }

    /**
     * @return BaseCollection
     */
    protected function getResourceCollectionObject(): BaseCollection
    {
        throw new BadMethodCallException('not implemented');
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
