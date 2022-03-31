<?php

namespace Digitalprint\Oro\Api\Endpoints;

use Digitalprint\Oro\Api\Exceptions\ApiException;
use Digitalprint\Oro\Api\Resources\Product;
use Digitalprint\Oro\Api\Resources\ProductCollection;
use JsonException;
use stdClass;

class ProductEndpoint extends CollectionEndpointAbstract
{
    /**
     * @var string
     */
    protected string $resourcePath = "api/products";

    /**
     * @param array $included
     * @return Product
     */
    protected function getResourceObject(array $included = []): Product
    {
        return new Product($this->client, $included);
    }

    /**
     * @param stdClass $links
     * @param array $included
     * @return ProductCollection
     */
    protected function getResourceCollectionObject(stdClass $links, array $included = []): ProductCollection
    {
        return new ProductCollection($this->client, $links, $included);
    }

    /**
     * @param array|null $data
     * @return Product
     * @throws ApiException
     * @throws JsonException
     */
    public function create(array $data = null): Product
    {
        return $this->rest_create($data);
    }

    /**
     * @param string $productId
     * @param array $filter
     * @return Product
     * @throws ApiException
     */
    public function get(string $productId, array $filter = []): Product
    {
        return $this->rest_read($productId, $filter);
    }

    /**
     * @param string|null $number
     * @param string|null $size
     * @param array $filter
     *
     * @return ProductCollection
     * @throws ApiException
     */
    public function page(string $number = null, string $size = null, array $filter = []): ProductCollection
    {
        return $this->rest_list($number, $size, $filter);
    }

    /**
     * @param array $data
     * @return Product
     * @throws ApiException
     * @throws JsonException
     */
    public function update(array $data = []): Product
    {
        return $this->rest_update($data);
    }

    /**
     * @param array $filter
     * @return Product|null
     * @throws ApiException
     */
    public function delete(array $filter = []): ?Product
    {
        return $this->rest_delete($filter);
    }
}
