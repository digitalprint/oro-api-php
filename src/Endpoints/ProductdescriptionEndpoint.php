<?php

namespace Oro\Api\Endpoints;

use Oro\Api\Exceptions\ApiException;
use Oro\Api\Resources\BaseCollection;
use Oro\Api\Resources\BaseResource;
use Oro\Api\Resources\Productdescription;
use Oro\Api\Resources\ProductdescriptionCollection;
use stdClass;

/**
 *
 */
class ProductdescriptionEndpoint extends CollectionEndpointAbstract
{
    /**
     * @var string
     */
    protected string $resourcePath = "api/productdescriptions";

    /**
     * Get the object that is used by this API. Every API uses one type of object.
     *
     * @return BaseResource
     */
    protected function getResourceObject(): BaseResource
    {
        return new Productdescription($this->client);
    }

    /**
     * Get the collection object that is used by this API. Every API uses one type of collection object.
     *
     * @param stdClass $links
     *
     * @return BaseCollection
     */
    protected function getResourceCollectionObject($links): BaseCollection
    {
        return new ProductdescriptionCollection($this->client, $links);
    }

    /**
     * @param array|null $data
     * @return BaseResource
     * @throws ApiException
     */
    public function create(array $data = null): BaseResource
    {
        return $this->rest_create($data);
    }

    /**
     * @param string $productdescriptionId
     * @param array $filter
     * @return Productdescription
     * @throws ApiException
     */
    public function get(string $productdescriptionId, array $filter = []): Productdescription
    {
        return $this->rest_read($productdescriptionId, $filter);
    }

    /**
     * @param string|null $number
     * @param string|null $size
     * @param array $filter
     *
     * @return ProductdescriptionCollection
     * @throws ApiException
     */
    public function page(string $number = null, string $size = null, array $filter = []): ProductdescriptionCollection
    {
        return $this->rest_list($number, $size, $filter);
    }

    /**
     * @param array $data
     * @return BaseResource|null
     * @throws ApiException
     */
    public function update(array $data = []): ?BaseResource
    {
        return $this->rest_update($data);
    }

    /**
     * @param array $filter
     * @return BaseResource|null
     * @throws ApiException
     */
    public function delete(array $filter = []): ?BaseResource
    {
        return $this->rest_delete($filter);
    }
}