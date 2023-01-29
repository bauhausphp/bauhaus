<?php

namespace Bauhaus\Tests\Http\Message;

use Bauhaus\Http\Message\RequestFactory;
use Bauhaus\Http\Message\ResponseFactory;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\MessageInterface as PsrHttpMessage;
use ReflectionClass;

abstract class HttpMessageTestCase extends TestCase
{
    protected readonly PsrHttpMessage $message;
    private readonly PsrHttpMessage $clonedMessage;

    /** @before */
    public function setUpMessage(): void
    {
        $this->message = $this->createMessage();
        $this->clonedMessage = clone $this->message;
    }

    /** @after */
    public function assertImmutability(): void
    {
        self::assertEquals($this->clonedMessage, $this->message, 'Immutability broken');
    }

    private function createMessage(): PsrHttpMessage
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
