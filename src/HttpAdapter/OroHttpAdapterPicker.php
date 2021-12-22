<?php

namespace Oro\Api\HttpAdapter;

use GuzzleHttp\ClientInterface;
use Oro\Api\Exceptions\UnrecognizedClientException;

class OroHttpAdapterPicker implements OroHttpAdapterPickerInterface
{
    /**
     * @param ClientInterface|OroHttpAdapterInterface $httpClient
     *
     * @return OroHttpAdapterInterface
     * @throws UnrecognizedClientException
     */
    public function pickHttpAdapter($httpClient): OroHttpAdapterInterface
    {
        if (! $httpClient) {
            if ($this->guzzleIsDetected()) {
                $guzzleVersion = $this->guzzleMajorVersionNumber();
                
                if (in_array($guzzleVersion, [6, 7], true)) {
                    return Guzzle6And7OroHttpAdapter::createDefault();
                }
            }

            return new CurlOroHttpAdapter;
        }

        if ($httpClient instanceof OroHttpAdapterInterface) {
            return $httpClient;
        }

        if ($httpClient instanceof ClientInterface) {
            return new Guzzle6And7OroHttpAdapter($httpClient);
        }

        throw new UnrecognizedClientException('The provided http client or adapter was not recognized.');
    }

    /**
     * @return bool
     */
    private function guzzleIsDetected(): bool
    {
        return interface_exists("\GuzzleHttp\ClientInterface");
    }

    /**
     * @return int|null
     */
    private function guzzleMajorVersionNumber(): ?int
    {
        // Guzzle 7
        if (defined('\GuzzleHttp\ClientInterface::MAJOR_VERSION')) {
            return (int) ClientInterface::MAJOR_VERSION;
        }

        // Before Guzzle 7
        if (defined('\GuzzleHttp\ClientInterface::VERSION')) {
            return (int) ClientInterface::VERSION[0];
        }

        return null;
    }
}
