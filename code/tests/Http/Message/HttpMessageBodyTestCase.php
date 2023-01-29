<?php

namespace Bauhaus\Tests\Http\Message;

use Bauhaus\Http\Message\StringBody;

abstract class HttpMessageBodyTestCase extends HttpMessageTestCase
{
      /** @test */
    public function haveNewBodyAfterAddingIt(): void
    {
        $message = $this->message->withBody(StringBody::with('content'));

        self::assertEquals(StringBody::with('content'), $message->getBody());
    }
}
