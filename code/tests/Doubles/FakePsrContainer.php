<?php

namespace Bauhaus\Tests\Doubles;

use Psr\Container\ContainerInterface as PsrContainer;

final readonly class FakePsrContainer implements PsrContainer
{
    private array $services;

    public function __construct(object ...$services)
    {
    }

    public function has(string $id): bool
    {
    }

    public function get(string $id)
    {
    }
}
