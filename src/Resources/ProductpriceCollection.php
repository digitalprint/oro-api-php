<?php

namespace Oro\Api\Resources;

class ProductpriceCollection extends CursorCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName(): string
    {
        return "productprices";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject(): BaseResource
    {
        return new Productprice($this->client);
    }
}