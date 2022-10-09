<?php

namespace Bauhaus\Tests\Http\Message\Response;

use InvalidArgumentException;

class StatusTest extends TestCase
{
    use StatusDataProvider;

    /** @test @dataProvider validStatusCodes */
    public function mutateStatusCode(int $code): void
    {
        $response = $this->response->withStatus($code);

        $this->assertEquals($code, $response->getStatusCode());
    }

    /** @test @dataProvider statusCodesWithIanaReasonPhrases */
    public function useReasonPhraseFromIanaRegistryByDefault(int $code, string $reasonPhrase): void
    {
        $response = $this->response->withStatus($code);

        $this->assertEquals($reasonPhrase, $response->getReasonPhrase());
    }

    /** @test @dataProvider validStatusCodes */
    public function overwriteReasonPhraseIfOneIsProvided(int $code): void
    {
        $response = $this->response->withStatus($code, 'Custom Reason Phrase');

        $this->assertEquals('Custom Reason Phrase', $response->getReasonPhrase());
    }

    /** @test @dataProvider invalidStatusCodes */
    public function throwExceptionIfProvidedCodeIsInvalid(int $invalidCode): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid status code');

        $this->response->withStatus($invalidCode);
    }
}
