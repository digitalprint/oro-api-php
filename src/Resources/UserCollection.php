<?php

namespace Digitalprint\Oro\Api\Resources;

class UserCollection extends CursorCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName(): string
    {
        return "users";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject(): BaseResource
    {
        return new User($this->client);
    }
}
