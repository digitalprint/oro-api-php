<?php

namespace Digitalprint\Oro\Api\Endpoints;

use Digitalprint\Oro\Api\Exceptions\ApiException;
use Digitalprint\Oro\Api\Resources\Addresstype;
use Digitalprint\Oro\Api\Resources\AddresstypeCollection;
use Digitalprint\Oro\Api\Resources\BaseCollection;
use Digitalprint\Oro\Api\Resources\BaseResource;
use Digitalprint\Oro\Api\Resources\ResourceFactory;
use stdClass;

/**
 *
 */
class AddresstypeEndpoint extends CollectionEndpointAbstract
{
    /**
     * @var string
     */
    protected string $resourcePath = "api/addresstypes";

    /**
     * Get the object that is used by this API. Every API uses one type of object.
     *
     * @return BaseResource
     */
    protected function getResourceObject(): BaseResource
    {
        return new Addresstype($this->client);
    }

    /**
     * Get the collection object that is used by this API. Every API uses one type of collection object.
     *
     * @param stdClass $links
     *
     * @return BaseCollection
     */
    protected function getResourceCollectionObject(stdClass $links = null): BaseCollection
    {
        return new AddresstypeCollection($this->client, $links);
    }

    /**
     * @param string $addresstypeId
     * @param array $filter
     * @return Addresstype
     * @throws ApiException
     */
    public function get(string $addresstypeId, array $filter = []): Addresstype
    {
        return $this->rest_read($addresstypeId, $filter);
    }

    /**
     * @param string|null $number
     * @param string|null $size
     * @param array $filter
     *
     * @return AddresstypeCollection
     * @throws ApiException
     */
    public function page(string $number = null, string $size = null, array $filter = []): AddresstypeCollection
    {
        $filter = array_merge(["number" => $number, "size" => $size], $filter);
        $filter = $this->buildFilters($filter);

        $result = $this->client->performHttpCall(
            self::REST_LIST,
            $this->getResourcePath() . $this->buildQueryString($filter)
        );

        /** @var AddresstypeCollection $collection */
        $collection = $this->getResourceCollectionObject();

        foreach ($result->data as $dataResult) {
            $collection[] = ResourceFactory::createFromApiResult($dataResult, $this->getResourceObject());
        }

        return $collection;
    }
}
