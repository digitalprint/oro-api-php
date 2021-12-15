<?php

namespace Oro\Api\Resources;

use Oro\Api\OroApiClient;

abstract class CursorCollection extends BaseCollection
{
    protected $client;

    /**
     * @param $client
     * @param \stdClass $links
     */
    final public function __construct($client, $links)
    {
        parent::__construct($links);

        $this->client = $client;
    }

    /**
     * @return BaseResource
     */
    abstract protected function createResourceObject(): BaseResource;

    /**
     * Return the next set of resources when available
     *
     * @return CursorCollection|null
     * @throws \Oro\Api\Exceptions\ApiException
     */
    final public function next(): static
    {
        if (! $this->hasNext()) {
            return null;
        }

        $result = $this->client->performHttpCallToFullUrl(OroApiClient::HTTP_GET, $this->links->next);

        $collection = new static($this->client, $result->links);

        foreach ($result->data as $dataResult) {
            $collection[] = ResourceFactory::createFromApiResult($dataResult, $this->createResourceObject());
        }

        return $collection;
    }

    /**
     * Return the previous set of resources when available
     *
     * @return CursorCollection|null
     * @throws \Oro\Api\Exceptions\ApiException
     */
    final public function previous(): static
    {
        if (! $this->hasPrevious()) {
            return null;
        }

        $result = $this->client->performHttpCallToFullUrl(OroApiClient::HTTP_GET, $this->links->prev);

        $collection = new static($this->client, $result->links);

        foreach ($result->data as $dataResult) {
            $collection[] = ResourceFactory::createFromApiResult($dataResult, $this->createResourceObject());
        }

        return $collection;
    }

    /**
     * Determine whether the collection has a next page available.
     *
     * @return bool
     */
    public function hasNext(): bool
    {
        return isset($this->links->next);
    }

    /**
     * Determine whether the collection has a previous page available.
     *
     * @return bool
     */
    public function hasPrevious(): bool
    {
        return isset($this->links->prev);
    }
}
