<?php

namespace Bauhaus;

use Bauhaus\HttpPort\HttpPort;
use Psr\Http\Server\RequestHandlerInterface as PsrHandlerInterface;

final readonly class HttpPortSettings
{
    public static function new(): self
    {
        return new self();
    }

    public function build(): PsrHandlerInterface
    {
        return HttpPort::build($this);
    }
}
