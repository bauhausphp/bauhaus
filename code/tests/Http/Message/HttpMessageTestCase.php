<?php

namespace Bauhaus\Tests\Http\Message;

use Bauhaus\Http\Message\RequestFactory;
use Bauhaus\Http\Message\ResponseFactory;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface as PsrRequest;
use Psr\Http\Message\ResponseInterface as PsrResponse;
use ReflectionClass;

abstract class HttpMessageTestCase extends TestCase
{
    protected readonly PsrRequest|PsrResponse $message;
    private readonly PsrRequest|PsrResponse $clonedMessage;

    /** @before */
    public function setUpImmutabilityAssertion(): void
    {
        $this->message = $this->createHttpMessage();
        $this->clonedMessage = clone $this->message;
    }

    /** @after */
    public function assertImmutability(): void
    {
        self::assertEquals($this->clonedMessage, $this->message, 'Immutability broken');
    }

    protected function createHttpMessage(): PsrRequest|PsrResponse
    {
        $rClass = new ReflectionClass($this);
        $namespace = explode('\\', $rClass->getNamespaceName());
        $namespace = array_pop($namespace);

        return match ($namespace) {
            'Response' => ResponseFactory::default()->createResponse(),
            'Request' => RequestFactory::default()->createRequest('GET', '/'),
        };
    }
}
