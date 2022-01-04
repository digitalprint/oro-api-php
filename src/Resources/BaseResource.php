<?php

namespace Digitalprint\Oro\Api\Resources;

use Digitalprint\Oro\Api\OroApiClient;

abstract class BaseResource
{
    /**
     * @var OroApiClient
     */
    protected $client;

    /**
     * @param $client
     */
    public function __construct(OroApiClient $client)
    {
        $this->client = $client;
    }
}
