<?php

namespace Oro\Api\Endpoints;

use Oro\Api\Resources\BaseCollection;

abstract class CollectionEndpointAbstract extends EndpointAbstract
{
    /**
     * Get the collection object that is used by this API endpoint. Every API endpoint uses one type of collection object.
     *
     * @param \stdClass $_links
     *
     * @return BaseCollection
     */
    abstract protected function getResourceCollectionObject(\stdClass $_links): BaseCollection;
}
