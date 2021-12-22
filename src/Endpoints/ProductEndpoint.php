<?php

namespace Oro\Api\Endpoints;

use Oro\Api\Resources\BaseCollection;
use Oro\Api\Resources\BaseResource;
use Oro\Api\Resources\Product;
use Oro\Api\Resources\ProductCollection;
use stdClass;

/**
 *
 */
class ProductEndpoint extends CollectionEndpointAbstract
{
    /**
     * @var string
     */
    protected string $resourcePath = "api/products";

    /**
     * Get the object that is used by this API. Every API uses one type of object.
     *
     * @return \Oro\Api\Resources\BaseResource
     */
    protected function getResourceObject(): BaseResource
    {
        return new Product($this->client);
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
        return new ProductCollection($this->client, $links);
    }


    public function create(array $data = null): BaseResource
    {
        return $this->rest_create($data);
    }


    public function get(array $filters = [])
    {
        return $this->rest_read($filters);
    }


    public function update(array $data = []): ?BaseResource
    {
        return $this->rest_update($data);
    }


    public function delete(array $filter = []): ?BaseResource
    {
        return $this->rest_delete($filter);
    }
}
