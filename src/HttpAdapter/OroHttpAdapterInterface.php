<?php

namespace Digitalprint\Oro\Api\HttpAdapter;

use Digitalprint\Oro\Api\Exceptions\ApiException;
use stdClass;

interface OroHttpAdapterInterface
{
    /**
     * Send a request to the specified Oro api url.
     *
     * @param $httpMethod
     * @param $url
     * @param $headers
     * @param $httpBody
     * @return stdClass|null
     * @throws ApiException
     */
    public function send($httpMethod, $url, $headers, $httpBody): ?stdClass;

    /**
     * The version number for the underlying http client, if available.
     * @example Guzzle/6.3
     *
     * @return string|null
     */
    public function versionString(): ?string;
}
