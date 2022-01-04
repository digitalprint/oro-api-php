<?php

namespace Digitalprint\Oro\Api\Resources;

class AddressCollection extends CursorCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName(): string
    {
        return "addresses";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject(): BaseResource
    {
        return new Address($this->client);
    }
}
