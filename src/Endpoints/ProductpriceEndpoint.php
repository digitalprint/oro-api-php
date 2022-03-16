<?php

namespace Digitalprint\Oro\Api\Endpoints;

use Digitalprint\Oro\Api\Exceptions\ApiException;
use Digitalprint\Oro\Api\Resources\Productprice;
use Digitalprint\Oro\Api\Resources\ProductpriceCollection;
use JsonException;
use stdClass;

class ProductpriceEndpoint extends CollectionEndpointAbstract
{
    /**
     * @var string
     */
    protected string $resourcePath = "api/productprices";

    /**
     * Get the object that is used by this API. Every API uses one type of object.
     *
     * @return Productprice
     */
    protected function getResourceObject(): Productprice
    {
        return new Productprice($this->client);
    }

    /**
     * Get the collection object that is used by this API. Every API uses one type of collection object.
     *
     * @param stdClass $links
     *
     * @return ProductpriceCollection
     */
    protected function getResourceCollectionObject(stdClass $links): ProductpriceCollection
    {
        return new ProductpriceCollection($this->client, $links);
    }

    /**
     * @param array|null $data
     * @return Productprice
     * @throws ApiException
     * @throws JsonException
     */
    public function create(array $data = null): Productprice
    {
        return $this->rest_create($data);
    }

    /**
     * @param string $productpriceId
     * @param array $filter
     * @return Productprice
     * @throws ApiException
     */
    public function get(string $productpriceId, array $filter = []): Productprice
    {
        return $this->rest_read($productpriceId, $filter);
    }

    /**
     * @param string|null $number
     * @param string|null $size
     * @param array $filter
     *
     * @return ProductpriceCollection
     * @throws ApiException
     */
    public function page(string $number = null, string $size = null, array $filter = []): ProductpriceCollection
    {
        return $this->rest_list($number, $size, $filter);
    }

    /**
     * @param array $data
     * @return Productprice
     * @throws ApiException
     * @throws JsonException
     */
    public function update(array $data = []): Productprice
    {
        return $this->rest_update($data);
    }

    /**
     * @param array $filter
     * @return Productprice|null
     * @throws ApiException
     */
    public function delete(array $filter = []): ?Productprice
    {
        return $this->rest_delete($filter);
    }
}
