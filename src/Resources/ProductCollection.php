<?php

namespace Oro\Api\Resources;

class ProductCollection extends CursorCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName(): string
    {
        return "products";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject(): BaseResource
    {
        return new Product($this->client);
    }
}