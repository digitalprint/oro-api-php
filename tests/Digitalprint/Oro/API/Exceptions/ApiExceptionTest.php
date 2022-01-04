<?php

namespace Tests\Digitalprint\Oro\API\Exceptions;

use Digitalprint\Oro\Api\Exceptions\ApiException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
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
