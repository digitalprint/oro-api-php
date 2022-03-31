<?php

namespace Digitalprint\Oro\Api\Endpoints;

use Digitalprint\Oro\Api\Resources\BaseCollection;
use stdClass;

abstract class CollectionEndpointAbstract extends EndpointAbstract
{
    /**
     * @param stdClass $links
     * @param array $included
     * @return BaseCollection
     */
    abstract protected function getResourceCollectionObject(stdClass $links, array $included = []): BaseCollection;
}
