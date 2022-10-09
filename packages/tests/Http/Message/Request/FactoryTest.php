<?php

namespace Bauhaus\Tests\Http\Message\Request;

use Bauhaus\Http\Message\Body;

class FactoryTest extends TestCase
{
    /** @test */
    public function createRequestWith1Point1AsProtocolByDefault(): void
    {
        $this->assertEquals('1.1', $this->request->getProtocolVersion());
    }

    /** @test */
    public function createRequestWithEmptyHeadersByDefault(): void
    {
        $this->assertEmpty($this->request->getHeaders());
    }

    /** @test */
    public function createRequestWithEmptyBodyByDefault(): void
    {
        $this->assertEquals(Body::empty(), $this->request->getBody());
    }
}
