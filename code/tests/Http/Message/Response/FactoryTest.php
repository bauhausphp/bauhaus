<?php

namespace Bauhaus\Tests\Http\Message\Response;

use InvalidArgumentException;
use Bauhaus\Http\Message\ResponseFactory;
use PHPUnit\Framework\TestCase;

class FactoryTest extends TestCase
{
    use StatusDataProvider;

    private ResponseFactory $factory;

    /** @before  */
    public function setUpFactory(): void
    {
        $this->factory = ResponseFactory::default();
    }

    /** @test */
    public function createResponseWith200StatusCodeIfNoneIsProvided(): void
    {
        $response = $this->factory->createResponse();

        $this->assertEquals(200, $response->getStatusCode());
    }

    /** @test */
    public function createResponseWith1Point1ProtocolByDefault(): void
    {
        $response = $this->factory->createResponse();

        $this->assertEquals('1.1', $response->getProtocolVersion());
    }

    /** @test */
    public function createResponseWithEmptyHeadersByDefault(): void
    {
        $response = $this->factory->createResponse();

        $this->assertEmpty($response->getHeaders());
    }

    /** @test */
    public function createResponseWithEmptyBodyByDefault(): void
    {
        $response = $this->factory->createResponse();

        $this->assertEmpty((string) $response->getBody());
    }

    /**
     * @test
     * @dataProvider validStatusCodes
     */
    public function createResponseWithProvidedStatusCode(int $code): void
    {
        $response = $this->factory->createResponse($code);

        $this->assertEquals($code, $response->getStatusCode());
    }

    /**
     * @tes
     * @dataProvider statusCodesWithIanaReasonPhrases
     */
    public function useReasonPhraseFromIanaRegistryIfItWasNotProvided(int $code, string $reasonPhrase): void
    {
        $response = $this->factory->createResponse($code);

        $this->assertEquals($reasonPhrase, $response->getReasonPhrase());
    }

    /**
     * @test
     * @dataProvider validStatusCodes
     */
    public function createResponseWithProvidedReasonPhraseRegardlessOfProvidedCode(int $code): void
    {
        $response = $this->factory->createResponse($code, 'Custom Reason Phrase');

        $this->assertEquals('Custom Reason Phrase', $response->getReasonPhrase());
    }

    /**
     * @test
     * @dataProvider invalidStatusCodes
     */
    public function throwExceptionIfInvalidStatusCodeIsProvided(int $invalidCode): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid status code');

        $this->factory->createResponse($invalidCode);
    }
}
