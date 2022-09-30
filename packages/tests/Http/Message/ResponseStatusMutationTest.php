<?php

namespace Bauhaus\Tests\Http\Message;

use Bauhaus\Http\Message\Response\InvalidStatusCode;

class ResponseStatusMutationTest extends ResponseTestCase
{
    /**
     * @test
     * @dataProvider validStatusCodes
     */
    public function mutateStatusCode(int $code): void
    {
        $response = $this->response->withStatus($code);

        $this->assertEquals($code, $response->getStatusCode());
    }

    /**
     * @test
     * @dataProvider statusCodesWithIanaReasonPhrases
     */
    public function useReasonPhraseFromIanaRegistryByDefault(int $code, string $reasonPhrase): void
    {
        $response = $this->response->withStatus($code);

        $this->assertEquals($reasonPhrase, $response->getReasonPhrase());
    }

    /**
     * @test
     * @dataProvider validStatusCodes
     */
    public function overwriteReasonPhraseIfOneIsProvided(int $code): void
    {
        $response = $this->response->withStatus($code, 'Custom Reason Phrase');

        $this->assertEquals('Custom Reason Phrase', $response->getReasonPhrase());
    }

    /**
     * @test
     * @dataProvider invalidStatusCodes
     */
    public function throwExceptionIfProvidedCodeIsInvalid(int $invalidCode): void
    {
        $this->expectException(InvalidStatusCode::class);

        $this->response->withStatus($invalidCode);
    }
}
