<?php

namespace Digitalprint\Oro\Api\Endpoints;

use Digitalprint\Oro\Api\Exceptions\ApiException;
use Digitalprint\Oro\Api\OroApiClient;
use Digitalprint\Oro\Api\Resources\BaseCollection;
use Digitalprint\Oro\Api\Resources\BaseResource;
use Digitalprint\Oro\Api\Resources\ResourceFactory;
use InvalidArgumentException;
use JsonException;

abstract class EndpointAbstract
{
    public const REST_CREATE = OroApiClient::HTTP_POST;
    public const REST_UPDATE = OroApiClient::HTTP_PATCH;
    public const REST_READ = OroApiClient::HTTP_GET;
    public const REST_LIST = OroApiClient::HTTP_GET;
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

        return "?" . http_build_query($filters);
    }

    /**
     * @param array $filters
     * @return array
     */
    protected function buildFilters(array $filters): array
    {
        if (empty($filters)) {
            return [];
        }

        $res = [];

        foreach ($filters as $key => $value) {
            if (! empty($value)) {
                if (! in_array($key, ['include', 'meta', 'sort'])) {
                    if (in_array($key, ['size', 'number'])) {
                        $res["page[$key]"] = $value;
                    } else {
                        $res["filter[$key]"] = $value;
                    }
                } else {
                    $res[$key] = $value;
                }
            }
        }

        return $res;
    }

    /**
     * @param array $body
     * @return BaseResource
     * @throws ApiException
     * @throws JsonException
     */
    protected function rest_create(array $body): BaseResource
    {
        $result = $this->client->performHttpCall(
            self::REST_CREATE,
            $this->getResourcePath(),
            $this->parseRequestBody($body)
        );

        return ResourceFactory::createFromApiResult($result->data, $this->getResourceObject($result->included ?? []));
    }

    /**
     * Retrieves a single object from the REST API.
     *
     * @param string $id Id of the object to retrieve.
     * @param array $filter
     * @return BaseResource
     * @throws ApiException
     */
    protected function rest_read(string $id, array $filter): BaseResource
    {
        if (empty($id)) {
            throw new ApiException("Invalid resource id.");
        }

        $id = urlencode($id);
        $result = $this->client->performHttpCall(
            self::REST_READ,
            $this->getResourcePath() . "/" . $id . $this->buildQueryString($filter)
        );

        return ResourceFactory::createFromApiResult($result->data, $this->getResourceObject($result->included ?? []));
    }

    /**
     * Get a collection of objects from the REST API.
     *
     * @param int|null $number The first resource ID you want to include in your list.
     * @param int|null $size
     * @param array $filter
     *
     * @return BaseCollection
     * @throws ApiException
     */
    protected function rest_list(int $number = null, int $size = null, array $filter = []): BaseCollection
    {
        $filter = array_merge(["number" => $number, "size" => $size], $filter);
        $filter = $this->buildFilters($filter);

        $result = $this->client->performHttpCall(
            self::REST_LIST,
            $this->getResourcePath() . $this->buildQueryString($filter)
        );

        /** @var BaseCollection $collection */
        $collection = $this->getResourceCollectionObject($result->links, $result->included ?? []);

        foreach ($result->data as $dataResult) {
            $collection[] = ResourceFactory::createFromApiResult($dataResult, $this->getResourceObject($result->included ?? []));
        }

        return $collection;
    }

    /**
     * @param array $body
     * @return BaseResource|null
     * @throws ApiException
     * @throws JsonException
     */
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

        return ResourceFactory::createFromApiResult($result->data, $this->getResourceObject($result->included ?? []));
    }

    /**
     * @param array $filter
     * @return BaseResource|null
     * @throws ApiException
     */
    protected function rest_delete(array $filter = []): ?BaseResource
    {
        $filter = $this->buildFilters($filter);

        $result = $this->client->performHttpCall(
            self::REST_DELETE,
            $this->getResourcePath() . $this->buildQueryString($filter)
        );
        
        if ($result === null) {
            return null;
        }

        return ResourceFactory::createFromApiResult($result->data, $this->getResourceObject($result->included ?? []));
    }

    /**
     * @param array $included
     * @return BaseResource
     */
    abstract protected function getResourceObject(array $included = []): BaseResource;

    /**
     * @param string $resourcePath
     */
    public function setResourcePath(string $resourcePath): void
    {
        $this->resourcePath = strtolower($resourcePath);
    }

    /**
     * @return string
     * @throws ApiException
     */
    public function getResourcePath(): string
    {
        if (str_contains($this->resourcePath, "_")) {
            [$parentResource, $childResource] = explode("_", $this->resourcePath, 2);

            if (empty($this->parentId)) {
                throw new ApiException("Subresource '$this->resourcePath' used without parent '$parentResource' ID.");
            }

            return $parentResource . "/" . $this->parentId . "/" . $childResource;
        }

        return $this->resourcePath;
    }

    /**
     * @param array $body
     * @return null|string
     * @throws ApiException
     * @throws JsonException
     */
    protected function parseRequestBody(array $body): ?string
    {
        if (empty($body)) {
            return null;
        }

        try {
            $encoded = @json_encode($body, JSON_THROW_ON_ERROR);
        } catch (InvalidArgumentException $e) {
            throw new ApiException("Error encoding parameters into JSON: '".$e->getMessage()."'.");
        }

        return $encoded;
    }
}
