<?php

namespace Oro\Api\Resources;

class UserroleCollection extends CursorCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName(): string
    {
        return "userroles";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject(): BaseResource
    {
        return new Userrole($this->client);
    }
}
