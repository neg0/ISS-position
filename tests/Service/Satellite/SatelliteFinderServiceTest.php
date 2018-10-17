<?php

namespace App\Tests\Service\Satellite;

use App\Bridge\Http\HttpClient;
use App\Bridge\Http\HttpResponse;
use App\Model\Satellite;
use App\Service\Satellite\SatelliteFinderService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class SatelliteFinderServiceTest extends TestCase
{
    private const MOCK_PATH = '/satellites';
    private const MOCK_SATELLITE_RESPONSE = [[
        Satellite::FIELD_ID => 7232,
        Satellite::FIELD_NAME => 'iss'
    ]];

    /**
     * @var SatelliteFinderService
     */
    private $sut;

    /**
     * @var HttpClient | MockObject
     */
    private $httpClient;

    /**
     * @var HttpResponse | MockObject
     */
    private $httpResponse;

    protected function setUp(): void
    {
        $this->httpClient = $this->createMock(HttpClient::class);
        $this->httpResponse = $this->createMock(HttpResponse::class);

        $this->sut = new SatelliteFinderService($this->httpClient, self::MOCK_PATH);
    }

    public function testShouldBeInstantiable(): void
    {
        $this->assertInstanceOf(SatelliteFinderService::class, $this->sut);
    }

    public function testSuccessfullyFoundAndCreatedSatellite(): void
    {
        $this->httpClient
            ->expects($this->once())
            ->method('get')
            ->willReturn($this->httpResponse);

        $this->httpResponse
            ->expects($this->once())
            ->method('getBody')
            ->willReturn(json_encode(self::MOCK_SATELLITE_RESPONSE));

        $this->assertInstanceOf(Satellite::class, $this->sut->find()[0]);
    }

    public function testCouldNotFindAndFailedCreatingSatelliteByReturningNull(): void
    {
        $this->httpClient
            ->expects($this->once())
            ->method('get')
            ->willReturn($this->httpResponse);

        $this->httpResponse
            ->expects($this->once())
            ->method('getBody')
            ->willReturn(json_encode([[]]));

        $this->assertNull($this->sut->find()[0]);
    }
}
