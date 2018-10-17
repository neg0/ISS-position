<?php

namespace App\Tests\Bridge\Http;

use App\Bridge\Http\HttpClient;
use App\Bridge\Http\HttpClientInterface;
use App\Bridge\Http\HttpResponse;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class HttpClientTest extends TestCase
{
    private const MOCK_URI = '/any-slug';
    private const MOCK_HTTP_CLIENT_OPTIONS = [ 'form_params' => [ 'name' => 'iss' ] ];

    /**
     * @var HttpClient
     */
    private $sut;

    /**
     * @var HttpClientInterface | MockObject
     */
    private $httpClient;

    protected function setUp(): void
    {
        $this->httpClient = $this->getHttpClient();

        $this->sut = new HttpClient($this->httpClient);
    }

    protected function tearDown(): void
    {
        unset($this->sut);
    }

    public function testShouldBeInstantiable(): void
    {
        $this->assertInstanceOf(HttpClient::class, $this->sut);
    }

    public function testPostRequestShouldReturnResponse(): void
    {
        $responseInterface = $this->createMock(HttpResponse::class);
        $this->httpClient
            ->expects($this->once())
            ->method('get')
            ->willReturn($responseInterface);

        $response = $this->sut->get(self::MOCK_URI, self::MOCK_HTTP_CLIENT_OPTIONS);

        $this->assertInstanceOf(HttpResponse::class, $response);
    }

    private function getHttpClient(): MockObject
    {
        return $this->createMock(HttpClientInterface::class);
    }
}
