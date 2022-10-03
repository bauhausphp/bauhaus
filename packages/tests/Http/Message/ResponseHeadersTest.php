<?php

namespace Bauhaus\Tests\Http\Message;

class ResponseHeadersTest extends ResponseTestCase
{
    /** @test */
    public function haveEmptyHeadersByDefault(): void
    {
        $this->assertEmpty($this->response->getHeaders());
    }

    public function caseSensitiveSamples(): array
    {
        return [
            'Both added and checked in lower-case' => ['h1', 'h1'],
            'Both added and checked in upper-case' => ['H1', 'H1'],
            'Added in upper-case and checked in lower-case' => ['H1', 'h1'],
            'Added in lower-case and checked in upper-case' => ['h1', 'H1'],
        ];
    }

    /**
     * @test
     * @dataProvider caseSensitiveSamples
     */
    public function haveHeaderAfterItWasAddedInAnInsensitiveManner(string $toAdd, string $toCheck): void
    {
        $response = $this->response->withHeader($toAdd, 'v1');

        $this->assertTrue($response->hasHeader($toCheck));
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

    /**
     * @test
     * @dataProvider caseSensitiveSamples
     */
    public function returnLineValuesAsArrayWhenItHasOnlyOneValue(string $toAdd, string $toCheck): void
    {
        $response = $this->response->withHeader($toAdd, 'v1');

        $this->assertEquals(['v1'], $response->getHeader($toCheck));
    }

    /**
     * @test
     * @dataProvider caseSensitiveSamples
     */
    public function returnLineValuesAsArrayWhenItHasMoreThanOneValue(string $toAdd, string $toCheck): void
    {
        $response = $this->response->withHeader($toAdd, ['v1', 'v2']);

        $this->assertEquals(['v1', 'v2'], $response->getHeader($toCheck));
    }

    /** @test */
    public function returnEmptyStringWhenItWasNeverAdded(): void
    {
        $this->assertEmpty($this->response->getHeaderLine('h1'));
    }

    /**
     * @test
     * @dataProvider caseSensitiveSamples
     */
    public function returnLineAsStringWhenItHasOnlyOneValue(string $toAdd, string $toCheck): void
    {
        $response = $this->response->withHeader($toAdd, 'v1');

        $this->assertEquals('v1', $response->getHeaderLine($toCheck));
    }

    /**
     * @test
     * @dataProvider caseSensitiveSamples
     */
    public function returnLineAsCommaSeparatedStringWhenItHasMoreThanOneValue(string $toAdd, string $toCheck): void
    {
        $response = $this->response->withHeader($toAdd, ['v1', 'v2']);

        $this->assertEquals('v1, v2', $response->getHeaderLine($toCheck));
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
