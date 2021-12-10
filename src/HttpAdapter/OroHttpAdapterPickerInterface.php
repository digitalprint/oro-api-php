<?php

namespace Oro\Api\HttpAdapter;

interface OroHttpAdapterPickerInterface
{
    /**
     * @param \GuzzleHttp\ClientInterface|\Oro\Api\HttpAdapter\OroHttpAdapterInterface $httpClient
     *
     * @return \Oro\Api\HttpAdapter\OroHttpAdapterInterface
     */
    public function pickHttpAdapter($httpClient);
}
