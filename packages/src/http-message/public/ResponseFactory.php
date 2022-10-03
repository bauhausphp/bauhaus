<?php

namespace Bauhaus\Http;

use Bauhaus\Http\Message\Headers\Headers;
use Bauhaus\Http\Message\Protocol;
use Bauhaus\Http\Message\Response\Status;
use Psr\Http\Message\ResponseFactoryInterface as PsrResponseFactory;
use Psr\Http\Message\ResponseInterface as PsrResponse;

final class ResponseFactory implements PsrResponseFactory
{
    public function createResponse(int $code = 200, string $reasonPhrase = ''): PsrResponse
    {
        return new Response(
            Protocol::V_1_1,
            new Status($code, $reasonPhrase),
            Headers::empty(),
        );
    }
}
