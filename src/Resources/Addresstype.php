<?php

namespace Digitalprint\Oro\Api\Resources;

use Digitalprint\Oro\Api\Exceptions\ApiException;
use Digitalprint\Oro\Api\OroApiClient;

class Addresstype extends BaseResource
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
            new Productprice($this->client)
        );
    }

}
