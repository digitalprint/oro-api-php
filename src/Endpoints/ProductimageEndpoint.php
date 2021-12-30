<?php

namespace Oro\Api\Endpoints;

use Oro\Api\Exceptions\ApiException;
use Oro\Api\Resources\BaseCollection;
use Oro\Api\Resources\BaseResource;
use Oro\Api\Resources\Productimage;
use Oro\Api\Resources\ProductimagesCollection;
use stdClass;

/**
 *
 */
class ProductimageEndpoint extends CollectionEndpointAbstract
{
    /**
     * @var string
     */
    protected string $resourcePath = "api/productimages";

    /**
     * Get the object that is used by this API. Every API uses one type of object.
     *
     * @return BaseResource
     */
    protected function getResourceObject(): BaseResource
    {
        return new Productimage($this->client);
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
        return new ProductimageCollection($this->client, $links);
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
     * @param string $productnameId
     * @param array $filter
     * @return Productimage
     * @throws ApiException
     */
    public function get(string $productimageId, array $filter = []): Productimage
    {
        return $this->rest_read($productimageId, $filter);
    }

    /**
     * @param string|null $number
     * @param string|null $size
     * @param array $filter
     *
     * @return ProductimageCollection
     * @throws ApiException
     */
    public function page(string $number = null, string $size = null, array $filter = []): ProductimageCollection
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
