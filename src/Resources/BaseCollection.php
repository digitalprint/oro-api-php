<?php

namespace Oro\Api\Resources;

use ArrayObject;
use stdClass;

abstract class BaseCollection extends ArrayObject
{
    public $links;

    /**
     * @param stdClass $links
     */
    public function __construct($links)
    {
        $this->links = $links;
        parent::__construct();
    }

    /**
     * @return string|null
     */
    abstract public function getCollectionResourceName(): ?string;
}
