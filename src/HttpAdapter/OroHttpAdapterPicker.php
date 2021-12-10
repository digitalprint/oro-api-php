<?php

namespace Oro\Api\HttpAdapter;

use Oro\Api\Exceptions\UnrecognizedClientException;

class OroHttpAdapterPicker implements OroHttpAdapterPickerInterface
{
    /**
     * @param \GuzzleHttp\ClientInterface|\Oro\Api\HttpAdapter\OroHttpAdapterInterface $httpClient
     *
     * @return \Oro\Api\HttpAdapter\OroHttpAdapterInterface
     * @throws \Oro\Api\Exceptions\UnrecognizedClientException
     */
    public function pickHttpAdapter($httpClient)
    {
        if (! $httpClient) {
            if ($this->guzzleIsDetected()) {
                $guzzleVersion = $this->guzzleMajorVersionNumber();
                
                if ($guzzleVersion && in_array($guzzleVersion, [6, 7])) {
                    return Guzzle6And7OroHttpAdapter::createDefault();
                }
            }

            return new CurlOroHttpAdapter;
        }

        if ($httpClient instanceof OroHttpAdapterInterface) {
            return $httpClient;
        }

        if ($httpClient instanceof \GuzzleHttp\ClientInterface) {
            return new Guzzle6And7OroHttpAdapter($httpClient);
        }

        throw new UnrecognizedClientException('The provided http client or adapter was not recognized.');
    }

    /**
     * @return bool
     */
    private function guzzleIsDetected()
    {
        return interface_exists("\GuzzleHttp\ClientInterface");
    }

    /**
     * @return int|null
     */
    private function guzzleMajorVersionNumber()
    {
        // Guzzle 7
        if (defined('\GuzzleHttp\ClientInterface::MAJOR_VERSION')) {
            return (int) \GuzzleHttp\ClientInterface::MAJOR_VERSION;
        }

        // Before Guzzle 7
        if (defined('\GuzzleHttp\ClientInterface::VERSION')) {
            return (int) \GuzzleHttp\ClientInterface::VERSION[0];
        }

        return null;
    }
}
