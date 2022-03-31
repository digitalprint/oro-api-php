<?php

namespace Digitalprint\Oro\Api\Endpoints;

use BadMethodCallException;
use Digitalprint\Oro\Api\Exceptions\ApiException;
use Digitalprint\Oro\Api\Resources\Addresstype;
use Digitalprint\Oro\Api\Resources\BaseCollection;

class AddresstypeEndpoint extends EndpointAbstract
{
    /**
     * @var string
     */
    protected string $resourcePath = "api/addresstypes";

    /**
     * @param array $included
     * @return Addresstype
     */
    protected function getResourceObject(array $included = []): Addresstype
    {
        return new Addresstype($this->client);
    }

    /**
     * @return BaseCollection
     */
    protected function getResourceCollectionObject(): BaseCollection
    {
        throw new BadMethodCallException('not implemented');
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

}
