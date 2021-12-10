<?php

namespace Oro\Api\Endpoints;

use Oro\Api\Exceptions\ApiException;
use Oro\Api\Resources\Product;
use Oro\Api\Resources\ResourceFactory;

class ProductEndpoint extends EndpointAbstract
{
    protected $resourcePath = "ppbackoffice/api/products";

    protected function getResourceCollectionObject($count, $links)
    {
        throw new \BadMethodCallException('not implemented');
    }

    protected function getResourceObject()
    {
        return new Product($this->client);
    }

    public function get($id) {
        return $this->rest_read($id, []);
    }

}