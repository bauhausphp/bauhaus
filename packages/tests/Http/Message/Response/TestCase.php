<?php

namespace Bauhaus\Tests\Http\Message\Response;

use Bauhaus\Http\ResponseFactory;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseFactoryInterface as PsrResponseFactory;
use Psr\Http\Message\ResponseInterface as PsrResponse;

abstract class ResponseTestCase extends TestCase
{
    use ResponseStatusCodesDataProvider;

    protected PsrResponseFactory $factory;
    protected PsrResponse $response;

    /** @before */
    public function setUpResponse(): void
    {
        $this->response = $this->factory->createResponse();
    }

    /** @before */
    public function setUpFactory(): void
    {
        $this->factory = new ResponseFactory();
    }
}
