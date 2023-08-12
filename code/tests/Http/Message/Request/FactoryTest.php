<?php

namespace Bauhaus\Tests\Http\Message\Request;

use Bauhaus\Http\Message\RequestFactory;
use PHPUnit\Framework\TestCase;

final class FactoryTest extends TestCase
{
    use MethodDataProvider;

    private RequestFactory $factory;

    /** @before  */
    public function setUpFactory(): void
    {
        $this->factory = RequestFactory::default();
    }

    /** @test */
    public function createRequestWith1Point1ProtocolByDefault(): void
    {
        $request = $this->factory->createRequest('GET', '/');

        $this->assertEquals('1.1', $request->getProtocolVersion());
    }

    /** @test */
    public function createRequestWithEmptyHeadersByDefault(): void
    {
        $request = $this->factory->createRequest('GET', '/');

        $this->assertEmpty($request->getHeaders());
    }

    /** @test */
    public function createRequestWithEmptyBodyByDefault(): void
    {
        $request = $this->factory->createRequest('GET', '/');

        $this->assertEmpty((string) $request->getBody());
    }

    /** @test @dataProvider validMethods */
    public function createRequestWithProvidedMethod(string $method): void
    {
        $request = $this->factory->createRequest($method, '/');

        $this->assertEquals($method, $request->getMethod());
    }
}
