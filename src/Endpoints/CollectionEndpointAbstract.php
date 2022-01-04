<?php

namespace Digitalprint\Oro\Api\Endpoints;

use Digitalprint\Oro\Api\Resources\BaseCollection;
use stdClass;

abstract class CollectionEndpointAbstract extends EndpointAbstract
{
    /**
     * Get the collection object that is used by this API endpoint. Every API endpoint uses one type of collection object.
     *
     * @param stdClass $links
     *
     * @return BaseCollection
     */
    abstract protected function getResourceCollectionObject(stdClass $links): BaseCollection;
}
