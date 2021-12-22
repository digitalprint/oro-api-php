<?php

namespace Tests\Oro\API\HttpAdapter;

use Oro\Api\HttpAdapter\OroHttpAdapterInterface;
use stdClass;

class MockOroHttpAdapter implements OroHttpAdapterInterface
{
    /**
     * @inheritDoc
     */
    public function send($httpMethod, $url, $headers, $httpBody): ?stdClass
    {
        return (object) ['foo' => 'bar'];
    }

    /**
     * @inheritDoc
     */
    public function versionString(): ?string
    {
        return 'mock-client/1.0';
    }
}
