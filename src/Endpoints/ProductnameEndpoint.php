<?php

namespace Digitalprint\Oro\Api\Endpoints;

use Digitalprint\Oro\Api\Exceptions\ApiException;
use Digitalprint\Oro\Api\Resources\Productname;
use Digitalprint\Oro\Api\Resources\ProductnameCollection;
use JsonException;
use stdClass;

/**
 *
 */
class ProductnameEndpoint extends CollectionEndpointAbstract
{
    /**
     * @var string
     */
    protected string $resourcePath = "api/productnames";

    /**
     * Get the object that is used by this API. Every API uses one type of object.
     *
     * @return Productname
     */
    protected function getResourceObject(): Productname
    {
        return new Productname($this->client);
    }

    /**
     * Get the collection object that is used by this API. Every API uses one type of collection object.
     *
     * @param stdClass $links
     *
     * @return ProductnameCollection
     */
    protected function getResourceCollectionObject(stdClass $links): ProductnameCollection
    {
        return new ProductnameCollection($this->client, $links);
    }

    /**
     * @param array|null $data
     * @return Productname
     * @throws ApiException
     * @throws JsonException
     */
    public function create(array $data = null): Productname
    {
        return $this->rest_create($data);
    }

    /**
     * @param string $productnameId
     * @param array $filter
     * @return Productname
     * @throws ApiException
     */
    public function get(string $productnameId, array $filter = []): Productname
    {
        return $this->rest_read($productnameId, $filter);
    }

    /**
     * @param string|null $number
     * @param string|null $size
     * @param array $filter
     *
     * @return ProductnameCollection
     * @throws ApiException
     */
    public function page(string $number = null, string $size = null, array $filter = []): ProductnameCollection
    {
        return $this->rest_list($number, $size, $filter);
    }

    /**
     * @param array $data
     * @return Productname
     * @throws ApiException
     * @throws JsonException
     */
    public function update(array $data = []): Productname
    {
        return $this->rest_update($data);
    }

}
