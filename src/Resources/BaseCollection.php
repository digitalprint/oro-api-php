<?php

namespace Digitalprint\Oro\Api\Resources;

use ArrayObject;
use stdClass;

abstract class BaseCollection extends ArrayObject
{

    /**
     * @var array
     */
    public array $included;

    /**
     * @var stdClass
     */
    public stdClass $links;

    /**
     * @param stdClass $links
     * @param array $included
     */
    public function __construct(stdClass $links, array $included = [])
    {
        $this->links = $links;
        $this->included = $included;
        parent::__construct();
    }

    /**
     * @return string|null
     */
    abstract public function getCollectionResourceName(): ?string;
}
