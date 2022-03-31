<?php

namespace Digitalprint\Oro\Api\Endpoints;

use Digitalprint\Oro\Api\Exceptions\ApiException;
use Digitalprint\Oro\Api\Resources\Addresstype;

class AddresstypeEndpoint extends EndpointAbstract
{
    /**
     * @var string
     */
    protected string $resourcePath = "api/addresstypes";

    /**
     * @return Addresstype
     */
    protected function getResourceObject(): Addresstype
    {
        return new Addresstype($this->client);
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
