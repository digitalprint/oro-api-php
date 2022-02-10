<?php

namespace Digitalprint\Oro\Api\HttpAdapter;

use Composer\CaBundle\CaBundle;
use Digitalprint\Oro\Api\Exceptions\ApiException;
use Digitalprint\Oro\Api\OroApiClient;
use stdClass;

final class CurlOroHttpAdapter implements OroHttpAdapterInterface
{
    /**
     * Default response timeout (in seconds).
     */
    public const DEFAULT_TIMEOUT = 10;

    /**
     * Default connect timeout (in seconds).
     */
    public const DEFAULT_CONNECT_TIMEOUT = 2;

    /**
     * HTTP status code for an empty ok response.
     */
    public const HTTP_NO_CONTENT = 204;

    /**
     * @param string $httpMethod
     * @param string $url
     * @param array $headers
     * @param $httpBody
     * @return stdClass|null
     * @throws ApiException
     */
    public function send($httpMethod, $url, $headers, $httpBody): ?stdClass
    {
        $curl = curl_init($url);
        $headers["Content-Type"] = "application/json";

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->parseHeaders($headers));
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, self::DEFAULT_CONNECT_TIMEOUT);
        curl_setopt($curl, CURLOPT_TIMEOUT, self::DEFAULT_TIMEOUT);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_CAINFO, CaBundle::getBundledCaBundlePath());

        switch ($httpMethod) {
            case OroApiClient::HTTP_POST:
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS,  $httpBody);

                break;
            case OroApiClient::HTTP_GET:
                break;
            case OroApiClient::HTTP_PATCH:
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
                curl_setopt($curl, CURLOPT_POSTFIELDS, $httpBody);

                break;
            case OroApiClient::HTTP_DELETE:
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
                curl_setopt($curl, CURLOPT_POSTFIELDS,  $httpBody);

                break;
            default:
                throw new \InvalidArgumentException("Invalid http method: ". $httpMethod);
        }

        $response = curl_exec($curl);

        if ($response === false) {
            throw new ApiException("Curl error: " . curl_error($curl));
        }

        $statusCode = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);

        curl_close($curl);

        return $this->parseResponseBody($response, $statusCode, $httpBody);
    }

    /**
     * The version number for the underlying http client, if available.
     * @example Guzzle/6.3
     *
     * @return string|null
     */
    public function versionString(): ?string
    {
        return 'Curl/*';
    }

    /**
     * @param string $response
     * @param int $statusCode
     * @param string $httpBody
     * @return stdClass|null
     * @throws ApiException
     */
    protected function parseResponseBody($response, $statusCode, $httpBody): ?stdClass
    {
        if (empty($response)) {
            if ($statusCode === self::HTTP_NO_CONTENT) {
                return null;
            }

            throw new ApiException("No response body found.");
        }

        $body = @json_decode($response);

        // GUARDS
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new ApiException("Unable to decode Oro response: '{$response}'.");
        }

        if (isset($body->error)) {
            throw new ApiException($body->error->message);
        }

        if ($statusCode >= 400) {
            $field = null;
            $message = "Unknown Error executing API call";

            if (! empty($body->errors)) {
                $message = "Error executing API call ({$body->errors[0]->status}: {$body->errors[0]->title})";

                if (! empty($body->errors[0]->detail)) {
                    $message .= ": {$body->errors[0]->detail}";
                }

                if (! empty($body->errors[0]->field)) {
                    $field = $body->errors[0]->field;
                }

                if ($httpBody) {
                    $message .= ". Request body: {$httpBody}";
                }
            }

            throw new ApiException($message, $statusCode, $field);
        }

        return $body;
    }

    protected function parseHeaders($headers): array
    {
        $result = [];

        foreach ($headers as $key => $value) {
            $result[] = $key .': ' . $value;
        }

        return $result;
    }
}
