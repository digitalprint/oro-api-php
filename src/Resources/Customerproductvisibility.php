<?php

namespace Digitalprint\Oro\Api\Resources;

use Digitalprint\Oro\Api\Exceptions\ApiException;
use Digitalprint\Oro\Api\OroApiClient;
use JsonException;

class Customerproductvisibility extends BaseResource
{
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
            new Customerproductvisibility($this->client)
        );
    }

    /**
     * @param array $body
     * @return BaseResource|null
     * @throws ApiException
     * @throws JsonException
     */
    public function update(array $body = []): ?BaseResource
    {
        $result = $this->client->performHttpCallToFullUrl(
            OroApiClient::HTTP_PATCH,
            $this->links->self,
            json_encode($body, JSON_THROW_ON_ERROR)
        );

        if ($result === null) {
            return null;
        }

        return ResourceFactory::createFromApiResult($result->data, new Customerproductvisibility($this->client));
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
}
