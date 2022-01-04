<?php

namespace Tests\Digitalprint\Oro\API\HttpAdapter;

use Digitalprint\Oro\Api\Exceptions\UnrecognizedClientException;
use Digitalprint\Oro\Api\HttpAdapter\Guzzle6And7OroHttpAdapter;
use Digitalprint\Oro\Api\HttpAdapter\OroHttpAdapterPicker;
use GuzzleHttp\Client as GuzzleClient;
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
