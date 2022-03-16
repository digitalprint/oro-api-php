<?php

namespace Digitalprint\Oro\Api\Exceptions;

use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use JsonException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use stdClass;
use Throwable;

class ApiException extends Exception
{
    /**
     * @var string|null
     */
    protected ?string $field = null;

    /**
     * @var RequestInterface|null
     */
    protected ?RequestInterface $request;

    /**
     * @var ResponseInterface|null
     */
    protected ?ResponseInterface $response;

    /**
     * ISO8601 representation of the moment this exception was thrown
     *
     * @var DateTimeImmutable
     */
    protected DateTimeImmutable $raisedAt;

    /**
     * @var array
     */
    protected array $links = [];

    /**
     * @param string $message
     * @param int $code
     * @param string|null $field
     * @param RequestInterface|null $request
     * @param ResponseInterface|null $response
     * @param Throwable|null $previous
     * @throws ApiException
     * @throws JsonException
     */
    public function __construct(
        string $message = "",
        int $code = 0,
        $field = null,
        RequestInterface  $request = null,
        ResponseInterface $response = null,
        Throwable $previous = null
    ) {
        $this->raisedAt = new DateTimeImmutable();

        $formattedRaisedAt = $this->raisedAt->format(DateTimeInterface::ATOM);
        $message = "[$formattedRaisedAt] " . $message;

        if (! empty($field)) {
            $this->field = (string)$field;
            $message .= ". Field: $this->field";
        }

        if ($response !== null) {
            $this->response = $response;

            $object = static::parseResponseBody($this->response);

            if (isset($object->links)) {
                foreach ($object->links as $key => $value) {
                    $this->links[$key] = $value;
                }
            }
        }

        $this->request = $request;
        if ($request) {
            $requestBody = $request->getBody()->__toString();

            if ($requestBody) {
                $message .= ". Request body: $requestBody";
            }
        }

        parent::__construct($message, $code, $previous);
    }

    /**
     * @param ResponseInterface $response
     * @param RequestInterface|null $request
     * @param Throwable|null $previous
     * @return ApiException
     * @throws ApiException
     * @throws JsonException
     */
    public static function createFromResponse(ResponseInterface $response, RequestInterface $request = null, Throwable $previous = null): ApiException
    {
        $object = static::parseResponseBody($response);

        $field = null;
        $message = "Unknown Error executing API call";

        if (! empty($object->errors)) {
          
            $message = "Error executing API call ({$object->errors[0]->status}: {$object->errors[0]->title})";

            if (! empty($object->errors[0]->detail)) {
                $message .= ": {$object->errors[0]->detail}";
            }

            if (! empty($object->errors[0]->field)) {
                $field = $object->errors[0]->field;
            }
        }

        return new self(
            $message,
            $response->getStatusCode(),
            $field,
            $request,
            $response,
            $previous
        );
    }

    /**
     * @return string|null
     */
    public function getField(): ?string
    {
        return $this->field;
    }

    /**
     * @return ResponseInterface|null
     */
    public function getResponse(): ?ResponseInterface
    {
        return $this->response;
    }

    /**
     * @return bool
     */
    public function hasResponse(): bool
    {
        return $this->response !== null;
    }

    /**
     * @param $key
     * @return bool
     */
    public function hasLink($key): bool
    {
        return array_key_exists($key, $this->links);
    }

    /**
     * @param $key
     * @return mixed
     */
    public function getLink($key): mixed
    {
        if ($this->hasLink($key)) {
            return $this->links[$key];
        }

        return null;
    }

    /**
     * @param $key
     * @return null
     */
    public function getUrl($key)
    {
        if ($this->hasLink($key)) {
            return $this->getLink($key)->href;
        }

        return null;
    }

    /**
     * @return RequestInterface
     */
    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    /**
     * Get the ISO8601 representation of the moment this exception was thrown
     *
     * @return DateTimeImmutable
     */
    public function getRaisedAt(): DateTimeImmutable
    {
        return $this->raisedAt;
    }

    /**
     * @param ResponseInterface $response
     * @return stdClass
     * @throws ApiException
     * @throws JsonException
     */
    protected static function parseResponseBody(ResponseInterface $response): stdClass
    {
        $body = (string) $response->getBody();

        $object = @json_decode($body, false, 512, JSON_THROW_ON_ERROR);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new self("Unable to decode Oro response: '$body'.");
        }

        return $object;
    }
}
