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
    public object $attributes;

    /**
     * @var object
     */
    public object $relationships;

    /**
     * @var object
     */
    public object $links;

    /**
     * @var array
     */
    public array $included;

    /**
     * @param OroApiClient $client
     * @param array $included
     */
    public function __construct(OroApiClient $client, array $included = [])
    {
        $this->included = $included;
        $this->client = $client;
    }
}
