<?php

namespace Oro\Api\Endpoints;

use Oro\Api\Exceptions\ApiException;
use Oro\Api\OroApiClient;
use Oro\Api\Resources\BaseResource;
use Oro\Api\Resources\CursorCollection;
use Oro\Api\Resources\ResourceFactory;

abstract class EndpointAbstract
{
    public const REST_CREATE = OroApiClient::HTTP_POST;
    public const REST_UPDATE = OroApiClient::HTTP_PATCH;
    public const REST_READ = OroApiClient::HTTP_GET;
    public const REST_DELETE = OroApiClient::HTTP_DELETE;

    /**
     * @var OroApiClient
     */
    protected OroApiClient $client;

    /**
     * @var string
     */
    protected string $resourcePath;

    /**
     * @param OroApiClient $api
     */
    public function __construct(OroApiClient $api)
    {
        $this->client = $api;
    }

    /**
     * @param array $filters
     * @return string
     */
    protected function buildQueryString(array $filters): string
    {
        if (empty($filters)) {
            return "";
        }

        foreach ($filters as $key => $value) {
            if ($value === true) {
                $filters[$key] = "true";
            }

            if ($value === false) {
                $filters[$key] = "false";
            }
        }

        return "?" . http_build_query($filters, "", "&");
    }

    protected function buildFilters(array $filters): array
    {
        if (empty($filters)) {
            return [];
        }

        $res = [];

        foreach ($filters as $key => $value) {
            if (! in_array($key, ['include', 'meta', 'sort'])) {
                if (in_array($key, ['size', 'number'])) {
                    $res["page[${key}]"] = $value;
                } else {
                    $res["filter[${key}]"] = $value;
                }
            } else {
                $res[$key] = $value;
            }
        }

        return $res;
    }

    protected function rest_create(array $body): BaseResource
    {
        $result = $this->client->performHttpCall(
            self::REST_CREATE,
            $this->getResourcePath(),
            $this->parseRequestBody($body)
        );

        return ResourceFactory::createFromApiResult($result->data, $this->getResourceObject());
    }

    protected function rest_read(array $filters = []): ?CursorCollection
    {
        $filters = $this->buildFilters($filters);

        $result = $this->client->performHttpCall(
            self::REST_READ,
            $this->getResourcePath() . $this->buildQueryString($filters)
        );

        if ($result === null) {
            return null;
        }

        $collection = $this->getResourceCollectionObject($result->links);

        foreach ($result->data as $dataResult) {
            $collection[] = ResourceFactory::createFromApiResult($dataResult, $this->getResourceObject());
        }

        return $collection;
    }
    
    protected function rest_update(array $body = []): ?BaseResource
    {
        $result = $this->client->performHttpCall(
            self::REST_UPDATE,
            $this->getResourcePath(),
            $this->parseRequestBody($body)
        );

        if ($result === null) {
            return null;
        }

        return ResourceFactory::createFromApiResult($result->data, $this->getResourceObject());
    }

    protected function rest_delete(array $filters = []): ?BaseResource
    {
        $filters = $this->buildFilters($filters);

        $result = $this->client->performHttpCall(
            self::REST_DELETE,
            $this->getResourcePath() . $this->buildQueryString($filters)
        );
        
        if ($result === null) {
            return null;
        }

        return ResourceFactory::createFromApiResult($result->data, $this->getResourceObject());
    }

    /**
     * Get the object that is used by this API endpoint. Every API endpoint uses one type of object.
     *
     * @return BaseResource
     */
    abstract protected function getResourceObject(): BaseResource;

    /**
     * @param string $resourcePath
     */
    public function setResourcePath($resourcePath): void
    {
        $this->resourcePath = strtolower($resourcePath);
    }

    /**
     * @return string
     * @throws ApiException
     */
    public function getResourcePath(): string
    {
        if (strpos($this->resourcePath, "_") !== false) {
            list($parentResource, $childResource) = explode("_", $this->resourcePath, 2);

            if (empty($this->parentId)) {
                throw new ApiException("Subresource '{$this->resourcePath}' used without parent '$parentResource' ID.");
            }

            return "$parentResource/{$this->parentId}/$childResource";
        }

        return $this->resourcePath;
    }

    /**
     * @param array $body
     * @return null|string
     * @throws ApiException
     */
    protected function parseRequestBody(array $body): ?string
    {
        if (empty($body)) {
            return null;
        }

        try {
            $encoded = @json_encode($body);
        } catch (\InvalidArgumentException $e) {
            throw new ApiException("Error encoding parameters into JSON: '".$e->getMessage()."'.");
        }

        return $encoded;
    }
}
