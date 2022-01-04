<?php

namespace Digitalprint\Oro\Api\Resources;

class ProductdescriptionCollection extends CursorCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName(): string
    {
        return "productdescriptions";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject(): BaseResource
    {
        return new Productdescription($this->client);
    }
}
