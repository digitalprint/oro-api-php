<?php

namespace Digitalprint\Oro\Api\Endpoints;

use Digitalprint\Oro\Api\Exceptions\ApiException;
use Digitalprint\Oro\Api\Resources\Customerproductvisibility;
use Digitalprint\Oro\Api\Resources\CustomerproductvisibilityCollection;
use JsonException;
use stdClass;

class CustomerproductvisibilityEndpoint extends CollectionEndpointAbstract
{
    /**
     * @var string
     */
    protected string $resourcePath = "api/customerproductvisibilities";

    /**
     * @param array $included
     * @return Customerproductvisibility
     */
    protected function getResourceObject(array $included = []): Customerproductvisibility
    {
        return new Customerproductvisibility($this->client, $included);
    }

    /**
     * @param stdClass $links
     * @param array $included
     * @return CustomerproductvisibilityCollection
     */
    protected function getResourceCollectionObject(stdClass $links, array $included = []): CustomerproductvisibilityCollection
    {
        return new CustomerproductvisibilityCollection($this->client, $links, $included);
    }

    /**
     * @param array|null $data
     * @return Customerproductvisibility
     * @throws ApiException
     * @throws JsonException
     */
    public function create(array $data = null): Customerproductvisibility
    {
        return $this->rest_create($data);
    }

    /**
     * @param string $productpriceId
     * @param array $filter
     * @return Customerproductvisibility
     * @throws ApiException
     */
    public function get(string $customerproductvisibilityId, array $filter = []): Customerproductvisibility
    {
        return $this->rest_read($customerproductvisibilityId, $filter);
    }

    /**
     * @param string|null $number
     * @param string|null $size
     * @param array $filter
     *
     * @return CustomerproductvisibilityCollection
     * @throws ApiException
     */
    public function page(string $number = null, string $size = null, array $filter = []): CustomerproductvisibilityCollection
    {
        return $this->rest_list($number, $size, $filter);
    }

    /**
     * @param array $data
     * @return Customerproductvisibility
     * @throws ApiException
     * @throws JsonException
     */
    public function update(array $data = []): Customerproductvisibility
    {
        return $this->rest_update($data);
    }

    /**
     * @param array $filter
     * @return Customerproductvisibility|null
     * @throws ApiException
     */
    public function delete(array $filter = []): ?Customerproductvisibility
    {
        return $this->rest_delete($filter);
    }
}
