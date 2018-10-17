<?php

namespace App\Tests\Bridge\Http;

use App\Bridge\Http\GuzzleHttpClient;
use App\Bridge\Http\HttpResponse;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class GuzzleHttpClientTest extends TestCase
{
    private const HTTP_OK_STATUS = 200;

    /**
     * @var GuzzleHttpClient
     */
    private $sut;

    protected function setUp(): void
    {
        $mock = new MockHandler([
            new Response(self::HTTP_OK_STATUS, [ 'Content-Length' => 0 ]),
        ]);
        $options['handler'] = HandlerStack::create($mock);
        $logger = $this->createMock(LoggerInterface::class);

        $this->sut = new GuzzleHttpClient('https://example.io', $logger, $options['handler']);
    }

    protected function tearDown(): void
    {
        unset($this->sut);
    }

    public function testShouldBeInstantiable(): void
    {
        $this->assertInstanceOf(GuzzleHttpClient::class, $this->sut);
    }

    public function testShouldSendPostRequestWithSuccess(): void
    {
        $response = $this->sut->get('/slug');
        $this->assertInstanceOf(HttpResponse::class, $response);
        $this->assertEquals(self::HTTP_OK_STATUS, $response->getCode());
    }
}
