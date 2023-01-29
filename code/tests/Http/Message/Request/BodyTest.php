<?php

namespace Bauhaus\Tests\Http\Message\Request;

use Bauhaus\Http\Message\Body;

final class BodyTest extends TestCase
{
    /** @test */
    public function mutateBody(): void
    {
        $body = Body::fromString('new body');

        $response = $this->request->withBody($body);

        $this->assertEquals($body, $response->getBody());
    }
}
