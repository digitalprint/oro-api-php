<?php

namespace Digitalprint\Oro\Api\Endpoints;

use Digitalprint\Oro\Api\Exceptions\ApiException;
use Digitalprint\Oro\Api\Resources\Productname;
use Digitalprint\Oro\Api\Resources\ProductnameCollection;
use JsonException;
use stdClass;

class ProductnameEndpoint extends CollectionEndpointAbstract
{
    /**
     * @var string
     */
    protected string $resourcePath = "api/productnames";

    /**
     * @param array $included
     * @return Productname
     */
    protected function getResourceObject(array $included = []): Productname
    {
        return new Productname($this->client, $included);
    }

    /**
     * @param stdClass $links
     * @param array $included
     * @return ProductnameCollection
     */
    protected function getResourceCollectionObject(stdClass $links, array $included = []): ProductnameCollection
    {
        return new ProductnameCollection($this->client, $links, $included);
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
