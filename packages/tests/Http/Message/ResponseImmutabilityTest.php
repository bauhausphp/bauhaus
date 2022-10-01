<?php

namespace Bauhaus\Tests\Http\Message;

class ResponseImmutabilityTest extends ResponseTestCase
{
    /** @test */
    public function createNewInstanceOnAnyMutation(): void
    {
        $initial = $this->response;

        $mutated = $initial
            ->withProtocolVersion('1.0')
            ->withStatus(404)
            ->withHeader('h1', 'v1');

        $this->assertNotSame($initial, $mutated);
    }

    /** @test */
    public function remainUnchangedAfterAnyMutations(): void
    {
        $initial = $this->response;
        $clonedInitial = clone $initial;

        $initial
            ->withProtocolVersion('1.0')
            ->withStatus(404)
            ->withHeader('h1', 'v1');

        $this->assertEquals($clonedInitial, $initial);
    }
}
