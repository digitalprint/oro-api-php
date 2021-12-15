<?php

namespace Oro\Api\Endpoints;

use Oro\Api\Exceptions\ApiException;
use Oro\Api\Resources\BaseCollection;
use Oro\Api\Resources\BaseResource;
use Oro\Api\Resources\Product;
use Oro\Api\Resources\ProductCollection;
use stdClass;

class ProductEndpoint extends CollectionEndpointAbstract
{
    protected $resourcePath = "api/products";

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
     * @param stdClass $_links
     *
     * @return \Oro\Api\Resources\BaseCollection
     */
    protected function getResourceCollectionObject(stdClass $_links): BaseCollection
    {
        return new ProductCollection($this->client, $_links);
    }

    /**
     * Retrieve an Invoice from Mollie.
     *
     * Will throw a ApiException if the invoice id is invalid or the resource cannot be found.
     *
     * @param string $productId
     * @param array $parameters
     *
     * @return \Oro\Api\Resources\BaseResource
     * @throws ApiException
     */
    public function get($productId, array $parameters = [])
    {
        return $this->rest_read($productId, $parameters);
    }

    /**
     * Retrieves a collection of Invoices from Mollie.
     *
     * @param int $limit
     * @param array $parameters
     *
     * @return \Oro\Api\Resources\BaseCollection
     * @throws ApiException
     */
    public function page($pageSize = null, array $parameters = [])
    {
        return $this->rest_list($pageSize, $parameters);
    }

}
