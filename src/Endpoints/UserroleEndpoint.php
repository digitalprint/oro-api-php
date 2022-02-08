<?php

namespace Digitalprint\Oro\Api\Endpoints;

use Digitalprint\Oro\Api\Exceptions\ApiException;
use Digitalprint\Oro\Api\Resources\BaseCollection;
use Digitalprint\Oro\Api\Resources\BaseResource;
use Digitalprint\Oro\Api\Resources\Userrole;
use Digitalprint\Oro\Api\Resources\UserroleCollection;
use stdClass;

class UserroleEndpoint extends CollectionEndpointAbstract
{
    /**
     * @var string
     */
    protected string $resourcePath = "api/userroles";

    /**
     * Get the object that is used by this API. Every API uses one type of object.
     *
     * @return BaseResource
     */
    protected function getResourceObject(): BaseResource
    {
        return new Userrole($this->client);
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
        return new UserroleCollection($this->client, $links);
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
     * @param string $userroleId
     * @param array $filter
     * @return Userrole
     * @throws ApiException
     */
    public function get(string $userroleId, array $filter = []): Userrole
    {
        return $this->rest_read($userroleId, $filter);
    }

    /**
     * @param string|null $number
     * @param string|null $size
     * @param array $filter
     *
     * @return UserroleCollection
     * @throws ApiException
     */
    public function page(string $number = null, string $size = null, array $filter = []): UserroleCollection
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
