<?php

namespace Digitalprint\Oro\Api\Resources;

use Digitalprint\Oro\Api\OroApiClient;

abstract class BaseResource
{
    /**
     * @var OroApiClient
     */
    protected OroApiClient $client;

    /**
     * @var string
     */
    public string $resource;

    /**
     * @var string
     */
    public string $type;

    /**
     * @var string
     */
    public string $id;

    /**
     * @var object
     */
    public object $links;

    /**
     * @var object
     */
    public object $attributes;

    /**
     * @var object
     */
    public object $relationships;

    /**
     * @param OroApiClient $client
     */
    public function __construct(OroApiClient $client)
    {
        $this->client = $client;
    }
}
