<?php

namespace Bauhaus\Tests\Http\Message\Request;

use Bauhaus\Http\Message\RequestFactory;
use PHPUnit\Framework\TestCase as PhpUnitTestCase;
use Psr\Http\Message\RequestFactoryInterface as PsrRequestFactory;
use Psr\Http\Message\RequestInterface as PsrRequest;

abstract class TestCase extends PhpUnitTestCase
{
    protected readonly PsrRequestFactory $factory;
    protected readonly PsrRequest $request;
    private readonly PsrRequest $requestCopy;

    /** @before */
    public function copyRequest(): void
    {
        $this->requestCopy = clone $this->request;
    }

    /** @before */
    public function setUpRequest(): void
    {
        $this->request = $this->factory->createRequest('GET', '/');
    }

    /** @before */
    public function setUpFactory(): void
    {
        $this->factory = RequestFactory::withDefaults();
    }

    /** @after */
    public function assertImmutability(): void
    {
        $this->assertEquals(
            $this->requestCopy,
            $this->request,
            'Request immutability assertion',
        );
    }
}
