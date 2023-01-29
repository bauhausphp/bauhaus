<?php

namespace Bauhaus\Http\Message;

use Psr\Http\Message\StreamInterface as PsrStream;
use Stringable;

final readonly class StringBody implements PsrStream, Stringable
{
    private function __construct(
        private string $content,
    ) {
    }

    public static function empty(): self
    {
        return new self('');
    }

    public static function with(string $str): self
    {
        return new self($str);
    }

    public function __toString(): string
    {
        return $this->content;
    }

    public function close(): void
    {
    }

    public function detach(): void
    {
    }

    public function getSize(): int
    {
    }

    public function tell()
    {
    }

    public function eof()
    {
    }

    public function isSeekable()
    {
    }

    public function seek($offset, $whence = SEEK_SET)
    {
    }

    public function rewind()
    {
    }

    public function isWritable()
    {
    }

    public function write($string)
    {
    }

    public function isReadable()
    {
    }

    public function read($length)
    {
    }

    public function getContents(): string
    {
    }

    public function getMetadata($key = null)
    {
    }
}
