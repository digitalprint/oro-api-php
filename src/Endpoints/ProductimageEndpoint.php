<?php

namespace Digitalprint\Oro\Api\Endpoints;

use Digitalprint\Oro\Api\Exceptions\ApiException;
use Digitalprint\Oro\Api\Resources\Productimage;
use Digitalprint\Oro\Api\Resources\ProductimageCollection;
use JsonException;
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
     * @return Productimage
     */
    protected function getResourceObject(): Productimage
    {
        return new Productimage($this->client);
    }

    /**
     * Get the collection object that is used by this API. Every API uses one type of collection object.
     *
     * @param stdClass $links
     *
     * @return ProductimageCollection
     */
    protected function getResourceCollectionObject(stdClass $links): ProductimageCollection
    {
        return new ProductimageCollection($this->client, $links);
    }

    /**
     * @param array|null $data
     * @return Productimage
     * @throws ApiException
     * @throws JsonException
     */
    public function create(array $data = null): Productimage
    {
        return $this->rest_create($data);
    }

    /**
     * @param string $productimageId
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
     * @return Productimage
     * @throws ApiException
     * @throws JsonException
     */
    public function update(array $data = []): Productimage
    {
        return $this->rest_update($data);
    }

    /**
     * @param array $filter
     * @return Productimage|null
     * @throws ApiException
     */
    public function delete(array $filter = []): ?Productimage
    {
        return $this->rest_delete($filter);
    }
}
