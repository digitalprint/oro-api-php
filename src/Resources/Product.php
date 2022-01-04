<?php

namespace Digitalprint\Oro\Api\Resources;

use Digitalprint\Oro\Api\Exceptions\ApiException;
use Digitalprint\Oro\Api\OroApiClient;

class Product extends BaseResource
{
    /**
     * @var string
     */
    public string $resource;

    /**
     * @var string
     */
    public string $type;

    /**
     * @var string
     */
    public string $id;

    /**
     * @var object
     */
    public object $attributes;

    /**
     * @var object
     */
    public object $relationships;

    /**
     * @return BaseResource
     * @throws ApiException
     */
    public function get(): BaseResource
    {
        $result = $this->client->performHttpCallToFullUrl(
            OroApiClient::HTTP_GET,
            $this->links->self
        );

        return ResourceFactory::createFromApiResult(
            $result->data,
            new Product($this->client)
        );
    }

    /**
     * @param array $body
     * @return BaseResource|null
     * @throws ApiException
     */
    public function update(array $body = []): ?BaseResource
    {
        $result = $this->client->performHttpCallToFullUrl(
            OroApiClient::HTTP_PATCH,
            $this->links->self,
            json_encode($body)
        );

        if ($result === null) {
            return null;
        }

        return ResourceFactory::createFromApiResult($result->data, new Product($this->client));
    }

    /**
     * @return null
     * @throws ApiException
     */
    public function delete()
    {
        if (! isset($this->links->self)) {
            return $this;
        }

        return $this->client->performHttpCallToFullUrl(
            OroApiClient::HTTP_DELETE,
            $this->links->self
        );
    }

    /**
     * @return ProductnameCollection
     * @throws ApiException
     */
    public function names(): ProductnameCollection
    {
        if (! isset($this->relationships->names->links->related)) {
            return new ProductnameCollection($this->client, null);
        }

        $result = $this->client->performHttpCallToFullUrl(
            OroApiClient::HTTP_GET,
            $this->relationships->names->links->related
        );

        return ResourceFactory::createCursorResourceCollection(
            $this->client,
            $result->data,
            Productname::class,
            $result->links
        );
    }

    /**
     * @return ProductdescriptionCollection
     * @throws ApiException
     */
    public function descriptions(): ProductdescriptionCollection
    {
        if (! isset($this->relationships->descriptions->links->related)) {
            return new ProductdescriptionCollection($this->client, null);
        }

        $result = $this->client->performHttpCallToFullUrl(
            OroApiClient::HTTP_GET,
            $this->relationships->descriptions->links->related
        );

        return ResourceFactory::createCursorResourceCollection(
            $this->client,
            $result->data,
            Productdescription::class,
            $result->links
        );
    }

    /**
     * @return ProductimageCollection
     * @throws ApiException
     */
    public function images(): ProductimageCollection
    {
        if (! isset($this->relationships->images->links->related)) {
            return new ProductimageCollection($this->client, null);
        }

        $result = $this->client->performHttpCallToFullUrl(
            OroApiClient::HTTP_GET,
            $this->relationships->images->links->related
        );

        return ResourceFactory::createCursorResourceCollection(
            $this->client,
            $result->data,
            Productimage::class,
            $result->links
        );
    }
}
