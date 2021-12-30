<?php

namespace Oro\Api\Resources;

class ProductnameCollection extends CursorCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName(): string
    {
        return "productnames";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject(): BaseResource
    {
        return new Productname($this->client);
    }
}
