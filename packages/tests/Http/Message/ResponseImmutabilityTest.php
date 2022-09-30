<?php

namespace Bauhaus\Tests\Http\Message;

class ResponseImmutabilityTest extends ResponseTestCase
{
    /** @test */
    public function createNewInstanceOnAnyMutation(): void
    {
        $initial = $this->response;

        $mutated = $initial
            ->withStatus(404);

        $this->assertNotSame($initial, $mutated);
    }

    /** @test */
    public function remainUnchangedAfterAnyMutations(): void
    {
        $initial = $this->response;
        $clonedInitial = clone $initial;

        $initial
            ->withStatus(404);

        $this->assertEquals($clonedInitial, $initial);
    }
}
