<?php

namespace Bauhaus\Tests\Http\Message\Response;

use Bauhaus\Tests\Http\Message\HttpMessageTestCase;

class StatusTest extends HttpMessageTestCase
{
    use StatusDataProvider;

    /**
     * @test
     * @dataProvider validStatusCodes
     */
    public function createNewInstanceWithProvidedStatusCode(int $code): void
    {
        $response = $this->message->withStatus($code);

        $this->assertEquals($code, $response->getStatusCode());
    }

//    /** @test @dataProvider statusCodesWithIanaReasonPhrases */
//    public function useReasonPhraseFromIanaRegistryByDefault(int $code, string $reasonPhrase): void
//    {
//        $response = $this->response->withStatus($code);
//
//        $this->assertEquals($reasonPhrase, $response->getReasonPhrase());
//    }
//
//    /** @test @dataProvider validStatusCodes */
//    public function overwriteReasonPhraseIfOneIsProvided(int $code): void
//    {
//        $response = $this->response->withStatus($code, 'Custom Reason Phrase');
//
//        $this->assertEquals('Custom Reason Phrase', $response->getReasonPhrase());
//    }
//
//    /** @test @dataProvider invalidStatusCodes */
//    public function throwExceptionIfProvidedCodeIsInvalid(int $invalidCode): void
//    {
//        self::expectException(InvalidArgumentException::class);
//        self::expectExceptionMessage('Invalid status code');
//
//        $this->response->withStatus($invalidCode);
//    }
}
