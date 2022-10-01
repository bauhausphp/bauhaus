<?php

namespace Bauhaus\Tests\Http\Message;

class ResponseHeadersTest extends ResponseTestCase
{
    /** @test */
    public function haveEmptyHeadersByDefault(): void
    {
        $this->assertEmpty($this->response->getHeaders());
    }

    /** @test */
    public function haveHeaderAfterItWasAdded(): void
    {
        $response = $this->response->withHeader('h1', 'v1');

        $this->assertTrue($response->hasHeader('h1'));
    }

    /** @test */
    public function doNotHaveHeaderAfterItsRemoval(): void
    {
        $response = $this->response
            ->withHeader('h1', 'v1')
            ->withoutHeader('h1');

        $this->assertFalse($response->hasHeader('h1'));
    }

    /** @test */
    public function returnEmptyArrayWhenItWasNeverAdded(): void
    {
        $this->assertEmpty($this->response->getHeader('h1'));
    }

    /** @test */
    public function returnLineValuesAsArrayWhenItHasOnlyOneValue(): void
    {
        $response = $this->response->withHeader('h1', 'v1');

        $this->assertEquals(['v1'], $response->getHeader('h1'));
    }

    /** @test */
    public function returnLineValuesAsArrayWhenItHasMoreThanOneValue(): void
    {
        $response = $this->response
            ->withHeader('h1', ['v1', 'v2']);

        $this->assertEquals(['v1', 'v2'], $response->getHeader('h1'));
    }

    /** @test */
    public function returnEmptyStringWhenItWasNeverAdded(): void
    {
        $this->assertEmpty($this->response->getHeaderLine('h1'));
    }

    /** @test */
    public function returnLineAsStringWhenItHasOnlyOneValue(): void
    {
        $response = $this->response->withHeader('h1', 'v1');

        $this->assertEquals('v1', $response->getHeaderLine('h1'));
    }

    /** @test */
    public function returnLineValuesAsCommaSeparatedStringWhenItHasMoreThanOneValue(): void
    {
        $response = $this->response
            ->withHeader('h1', ['v1', 'v2']);

        $this->assertEquals('v1, v2', $response->getHeaderLine('h1'));
    }

    /** @test */
    public function overwritePreviousValuesIfItAlreadyExists(): void
    {
        $response = $this->response
            ->withHeader('h1', 'v1')
            ->withHeader('h1', 'v2');

        $this->assertEquals(['v2'], $response->getHeader('h1'));
    }

    /** @test */
    public function allowAppendNewValuesIfItAlreadyExists(): void
    {
        $response = $this->response
            ->withHeader('h1', 'v1')
            ->withAddedHeader('h1', 'v2');

        $this->assertEquals(['v1', 'v2'], $response->getHeader('h1'));
    }

    /** @test */
    public function returnEverythingAsArray(): void
    {
        $response = $this->response
            ->withHeader('h1', 'v1')
            ->withHeader('h2', 'v2')
            ->withHeader('h1', ['v3', 'v4'])
            ->withAddedHeader('h1', 'v5')
            ->withHeader('h3', ['v6', 'v7'])
            ->withoutHeader('h3');

        $this->assertEquals(
            ['h1' => ['v3', 'v4', 'v5'], 'h2' => ['v2']],
            $response->getHeaders(),
        );
    }
}
