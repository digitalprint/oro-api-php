<?php

namespace Tests\Oro\API\Exceptions;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Oro\Api\Exceptions\ApiException;
use PHPUnit\Framework\TestCase;

class ApiExceptionTest extends TestCase
{

    public function testCanGetRequestBodyIfRequestIsSet(): void
    {
        $response = new Response(
            422,
            [],
            /** @lang JSON */
          '{
                    "errors": [{
                      "status": 422,
                      "title": "Unprocessable Entity",
                      "detail": "Can not enable this entity"
                  }]
                }'
        );

        $request = new Request(
            'POST',
            'https://myoroproxy.local/v2/profiles/pfl_v9hTwCvYqw/methods/bancontact',
            [],
            /** @lang JSON */
            '{ "foo": "bar" }'
        );

        $exception = ApiException::createFromResponse($response, $request);

        $this->assertJsonStringEqualsJsonString(/** @lang JSON */'{ "foo": "bar" }', $exception->getRequest()->getBody()->__toString());
        $this->assertStringEndsWith('Error executing API call (422: Unprocessable Entity): Can not enable this entity. Request body: { "foo": "bar" }', $exception->getMessage());
    }
}
