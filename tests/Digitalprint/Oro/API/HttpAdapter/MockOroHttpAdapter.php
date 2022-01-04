<?php

namespace Tests\Digitalprint\Oro\API\HttpAdapter;

use Digitalprint\Oro\Api\HttpAdapter\OroHttpAdapterInterface;
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
