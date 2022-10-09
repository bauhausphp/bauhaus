<?php

namespace Bauhaus\Tests\Http\Message\Response;

use Bauhaus\Http\InvalidStatusCode;

class FactoryTest extends TestCase
{
    use StatusDataProvider;

    /** @test */
    public function createResponseWith200AsStatusCodeIfNoneIsProvided(): void
    {
        $this->assertEquals(200, $this->response->getStatusCode());
    }

    /** @test @dataProvider validStatusCodes */
    public function createResponseWithProvidedStatusCode(int $code): void
    {
        $response = $this->factory->createResponse($code);

        $this->assertEquals($code, $response->getStatusCode());
    }

    /** @test @dataProvider statusCodesWithIanaReasonPhrases */
    public function useReasonPhraseFromIanaRegistryIfNoneIsProvided(int $code, string $reasonPhrase): void
    {
        $response = $this->factory->createResponse($code);

        $this->assertEquals($reasonPhrase, $response->getReasonPhrase());
    }

    /** @test @dataProvider validStatusCodes */
    public function overwriteReasonPhraseIfOneIsProvided(int $code): void
    {
        $response = $this->factory->createResponse($code, 'Custom Reason Phrase');

        $this->assertEquals('Custom Reason Phrase', $response->getReasonPhrase());
    }

    /** @test @dataProvider invalidStatusCodes */
    public function throwExceptionIfProvidedStatusCodeIsInvalid(int $invalidCode): void
    {
        $this->expectException(InvalidStatusCode::class);

        $this->factory->createResponse($invalidCode);
    }
}
