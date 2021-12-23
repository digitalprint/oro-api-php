<?php

namespace Oro\Api\Endpoints;

use Oro\Api\Resources\BaseCollection;
use Oro\Api\Resources\BaseResource;
use Oro\Api\Resources\Addresstype;
use Oro\Api\Resources\AddresstypeCollection;
use stdClass;

/**
 *
 */
class AddresstypeEndpoint extends CollectionEndpointAbstract
{
    /**
     * @var string
     */
    protected string $resourcePath = "api/addresstypes";

    /**
     * Get the object that is used by this API. Every API uses one type of object.
     *
     * @return \Oro\Api\Resources\BaseResource
     */
    protected function getResourceObject(): BaseResource
    {
        return new Addresstype($this->client);
    }

    /**
     * Get the collection object that is used by this API. Every API uses one type of collection object.
     *
     * @param stdClass $links
     *
     * @return \Oro\Api\Resources\BaseCollection
     */
    protected function getResourceCollectionObject(stdClass $links): BaseCollection
    {
        return new AddresstypeCollection($this->client, $links);
    }

    /**
     * @param array $filters
     * @return \Oro\Api\Resources\CursorCollection|null
     * @throws \Oro\Api\Exceptions\ApiException
     */
    public function get(array $filters = [])
    {
        return $this->rest_read($filters);
    }

}
