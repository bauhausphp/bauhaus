<?php

namespace Bauhaus\Tests\Http\Message\Response;

use Bauhaus\Http\Body;

final class BodyTest extends TestCase
{
    /** @test */
    public function mutateBody(): void
    {
        $body = Body::fromString('new body');

        $response = $this->response->withBody($body);

        $this->assertEquals($body, $response->getBody());
    }
}
