<?php

namespace Digitalprint\Oro\Api\Endpoints;

use Digitalprint\Oro\Api\Exceptions\ApiException;
use Digitalprint\Oro\Api\Resources\Address;
use Digitalprint\Oro\Api\Resources\AddressCollection;
use Digitalprint\Oro\Api\Resources\BaseCollection;
use Digitalprint\Oro\Api\Resources\BaseResource;
use stdClass;

class AddressEndpoint extends CollectionEndpointAbstract
{
    /**
     * @var string
     */
    protected string $resourcePath = "api/addresses";

    /**
     * Get the object that is used by this API. Every API uses one type of object.
     *
     * @return BaseResource
     */
    protected function getResourceObject(): BaseResource
    {
        return new Address($this->client);
    }

    /**
     * Get the collection object that is used by this API. Every API uses one type of collection object.
     *
     * @param stdClass $links
     *
     * @return BaseCollection
     */
    protected function getResourceCollectionObject(stdClass $links): BaseCollection
    {
        return new AddressCollection($this->client, $links);
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
     * @param string $addressId
     * @param array $filter
     * @return Address
     * @throws ApiException
     */
    public function get(string $addressId, array $filter = []): Address
    {
        return $this->rest_read($addressId, $filter);
    }

    /**
     * @param string|null $number
     * @param string|null $size
     * @param array $filter
     *
     * @return AddressCollection
     * @throws ApiException
     */
    public function page(string $number = null, string $size = null, array $filter = []): AddressCollection
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
