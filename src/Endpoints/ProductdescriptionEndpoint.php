<?php

namespace Digitalprint\Oro\Api\Endpoints;

use Digitalprint\Oro\Api\Exceptions\ApiException;
use Digitalprint\Oro\Api\Resources\Productdescription;
use Digitalprint\Oro\Api\Resources\ProductdescriptionCollection;
use JsonException;
use stdClass;

class ProductdescriptionEndpoint extends CollectionEndpointAbstract
{
    /**
     * @var string
     */
    protected string $resourcePath = "api/productdescriptions";

    /**
     * @param array $included
     * @return Productdescription
     */
    protected function getResourceObject(array $included = []): Productdescription
    {
        return new Productdescription($this->client, $included);
    }

    /**
     * @param stdClass $links
     * @param array $included
     * @return ProductdescriptionCollection
     */
    protected function getResourceCollectionObject(stdClass $links, array $included = []): ProductdescriptionCollection
    {
        return new ProductdescriptionCollection($this->client, $links, $included);
    }

    /**
     * @param array|null $data
     * @return Productdescription
     * @throws ApiException
     * @throws JsonException
     */
    public function create(array $data = null): Productdescription
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
     * @return Productdescription
     * @throws ApiException
     * @throws JsonException
     */
    public function update(array $data = []): Productdescription
    {
        return $this->rest_update($data);
    }

}
