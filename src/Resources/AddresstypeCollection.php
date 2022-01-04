<?php

namespace Digitalprint\Oro\Api\Resources;

class AddresstypeCollection extends CursorCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName(): string
    {
        return "addresstypes";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject(): BaseResource
    {
        return new Addresstype($this->client);
    }
}