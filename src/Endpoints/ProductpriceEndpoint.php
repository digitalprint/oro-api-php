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
     * @param array $included
     * @return Productprice
     */
    protected function getResourceObject(array $included = []): Productprice
    {
        return new Productprice($this->client, $included);
    }

    /**
     * @param stdClass $links
     * @param array $included
     * @return ProductpriceCollection
     */
    protected function getResourceCollectionObject(stdClass $links, array $included = []): ProductpriceCollection
    {
        return new ProductpriceCollection($this->client, $links, $included);
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
