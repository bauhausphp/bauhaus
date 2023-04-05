<?php

namespace Bauhaus\Tests\Http\Message;

use Bauhaus\Http\Message\StringBody;

abstract class HttpMessageBodyTestCase extends HttpMessageTestCase
{
      /** @test */
    public function haveNewBodyAfterAddingIt(): void
    {
        $newBody = StringBody::with('content');

        $message = $this->message->withBody(StringBody::with('content'));

        self::assertEquals($newBody, $message->getBody());
    }
}
