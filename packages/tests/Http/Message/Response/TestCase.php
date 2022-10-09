<?php

namespace Bauhaus\Tests\Http\Message\Response;

use Bauhaus\Http\Message\ResponseFactory;
use PHPUnit\Framework\TestCase as PhpUnitTestCase;
use Psr\Http\Message\ResponseFactoryInterface as PsrResponseFactory;
use Psr\Http\Message\ResponseInterface as PsrResponse;

abstract class TestCase extends PhpUnitTestCase
{
    protected readonly PsrResponseFactory $factory;
    protected readonly PsrResponse $response;
    private readonly PsrResponse $responseCopy;

    /** @before */
    public function copyResponse(): void
    {
        $this->responseCopy = clone $this->response;
    }

    /** @before */
    public function setUpResponse(): void
    {
        $this->response = $this->factory->createResponse();
    }

    /** @before */
    public function setUpFactory(): void
    {
        $this->factory = ResponseFactory::withDefaults();
    }

    /** @after */
    public function assertImmutability(): void
    {
        $this->assertEquals(
            $this->responseCopy,
            $this->response,
            'Response immutability assertion',
        );
    }
}
