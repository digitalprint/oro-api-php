<?php

namespace Oro\Api\Resources;

class ProductimageCollection extends CursorCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName(): string
    {
        return "productimagess";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject(): BaseResource
    {
        return new Productimage($this->client);
    }
}
