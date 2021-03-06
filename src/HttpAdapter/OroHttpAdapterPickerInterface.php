<?php

namespace Digitalprint\Oro\Api\HttpAdapter;

use GuzzleHttp\ClientInterface;

interface OroHttpAdapterPickerInterface
{
    /**
     * @param ClientInterface|OroHttpAdapterInterface $httpClient
     *
     * @return OroHttpAdapterInterface
     */
    public function pickHttpAdapter(OroHttpAdapterInterface|ClientInterface $httpClient): OroHttpAdapterInterface;
}
