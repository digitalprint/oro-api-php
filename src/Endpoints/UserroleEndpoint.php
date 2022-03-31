<?php

namespace Digitalprint\Oro\Api\Endpoints;

use Digitalprint\Oro\Api\Exceptions\ApiException;
use Digitalprint\Oro\Api\Resources\Userrole;
use Digitalprint\Oro\Api\Resources\UserroleCollection;
use JsonException;
use stdClass;

class UserroleEndpoint extends CollectionEndpointAbstract
{
    /**
     * @var string
     */
    protected string $resourcePath = "api/userroles";

    /**
     * @param array $included
     * @return Userrole
     */
    protected function getResourceObject(array $included = []): Userrole
    {
        return new Userrole($this->client, $included);
    }

    /**
     * @param stdClass $links
     * @param array $included
     * @return UserroleCollection
     */
    protected function getResourceCollectionObject(stdClass $links, array $included = []): UserroleCollection
    {
        return new UserroleCollection($this->client, $links, $included);
    }

    /**
     * @param array|null $data
     * @return Userrole
     * @throws ApiException
     * @throws JsonException
     */
    public function create(array $data = null): Userrole
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
     * @return Userrole
     * @throws ApiException
     * @throws JsonException
     */
    public function update(array $data = []): Userrole
    {
        return $this->rest_update($data);
    }

    /**
     * @param array $filter
     * @return Userrole|null
     * @throws ApiException
     */
    public function delete(array $filter = []): ?Userrole
    {
        return $this->rest_delete($filter);
    }
}
