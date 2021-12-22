<?php

namespace Tests\Oro\API\HttpAdapter;

use GuzzleHttp\Client as GuzzleClient;
use Oro\Api\Exceptions\UnrecognizedClientException;
use Oro\Api\HttpAdapter\Guzzle6And7OroHttpAdapter;
use Oro\Api\HttpAdapter\OroHttpAdapterPicker;
use PHPUnit\Framework\TestCase;

class OroHttpAdapterPickerTest extends TestCase
{
    /** @test */
    public function createsAGuzzleAdapterIfNullIsPassedAndGuzzleIsDetected(): void
    {
        $picker = new OroHttpAdapterPicker;

        $adapter = $picker->pickHttpAdapter(null);

        $this->assertInstanceOf(Guzzle6And7OroHttpAdapter::class, $adapter);
    }

    /** @test */
    public function returnsTheAdapterThatWasPassedIn(): void
    {
        $picker = new OroHttpAdapterPicker;
        $mockAdapter = new MockOroHttpAdapter;

        $adapter = $picker->pickHttpAdapter($mockAdapter);

        $this->assertInstanceOf(MockOroHttpAdapter::class, $adapter);
        $this->assertEquals($mockAdapter, $adapter);
    }

    /** @test */
    public function wrapsAGuzzleClientIntoAnAdapter()
    {
        $picker = new OroHttpAdapterPicker;
        $guzzleClient = new GuzzleClient;

        $adapter = $picker->pickHttpAdapter($guzzleClient);

        $this->assertInstanceOf(Guzzle6And7OroHttpAdapter::class, $adapter);
    }

    /** @test */
    public function throwsAnExceptionWhenReceivingAnUnrecognizedClient()
    {
        $this->expectExceptionObject(new UnrecognizedClientException('The provided http client or adapter was not recognized'));
        $picker = new OroHttpAdapterPicker;
        $unsupportedClient = (object) ['foo' => 'bar'];

        $picker->pickHttpAdapter($unsupportedClient);
    }
}
