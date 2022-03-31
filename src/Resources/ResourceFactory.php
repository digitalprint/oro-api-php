<?php

namespace Digitalprint\Oro\Api\Resources;

use Digitalprint\Oro\Api\OroApiClient;

class ResourceFactory
{
    /**
     * Create resource object from Api result
     *
     * @param object $apiResult
     * @param BaseResource $resource
     *
     * @return BaseResource
     */
    public static function createFromApiResult(object $apiResult, BaseResource $resource): BaseResource
    {
        foreach ($apiResult as $property => $value) {
            $resource->{$property} = $value;
        }

        return $resource;
    }

    /**
     * @param OroApiClient $client
     * @param string $resourceClass
     * @param array $data
     * @param null $_links
     * @param null $resourceCollectionClass
     * @return mixed
     */
    public static function createBaseResourceCollection(
        OroApiClient $client,
        string       $resourceClass,
        array        $data,
        $_links = null,
        $resourceCollectionClass = null
    ): mixed {
        $resourceCollectionClass = $resourceCollectionClass ?: $resourceClass . 'Collection';
        $data = $data ?: [];

        $result = new $resourceCollectionClass($_links);
        foreach ($data as $item) {
            $result[] = static::createFromApiResult($item, new $resourceClass($client));
        }

        return $result;
    }

    /**
     * @param OroApiClient $client
     * @param array $input
     * @param string $resourceClass
     * @param null $_links
     * @param null $resourceCollectionClass
     * @return mixed
     */
    public static function createCursorResourceCollection(
        OroApiClient $client,
        array        $input,
        string       $resourceClass,
        $_links = null,
        $resourceCollectionClass = null
    ): mixed {
        if (null === $resourceCollectionClass) {
            $resourceCollectionClass = $resourceClass.'Collection';
        }
        
        $data = new $resourceCollectionClass($client, $_links);
        foreach ($input as $item) {
            $data[] = static::createFromApiResult($item, new $resourceClass($client, []));
        }

        return $data;
    }
}
