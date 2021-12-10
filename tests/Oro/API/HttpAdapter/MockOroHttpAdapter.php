<?php

namespace Tests\Oro\API\HttpAdapter;

class MockOroHttpAdapter implements \Oro\Api\HttpAdapter\OroHttpAdapterInterface
{
    /**
     * @inheritDoc
     */
    public function send($httpMethod, $url, $headers, $httpBody)
    {
        return (object) ['foo' => 'bar'];
    }

    /**
     * @inheritDoc
     */
    public function versionString()
    {
        return 'mock-client/1.0';
    }
}
