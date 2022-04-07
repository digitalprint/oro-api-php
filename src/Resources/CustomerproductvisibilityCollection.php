<?php

namespace Digitalprint\Oro\Api\Resources;

class CustomerproductvisibilityCollection extends CursorCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName(): string
    {
        return "customerproductvisibilities";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject(): BaseResource
    {
        return new Customerproductvisibility($this->client);
    }
}
