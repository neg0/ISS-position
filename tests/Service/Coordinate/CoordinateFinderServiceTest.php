<?php

namespace App\Tests\Service\Coordinate;

use App\Bridge\Http\HttpClient;
use App\Bridge\Http\HttpResponse;
use App\Exception\SatelliteIdExpectedException;
use App\Model\Coordinate;
use App\Service\Coordinate\CoordinateFinderService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CoordinateFinderServiceTest extends TestCase
{
    private const MOCK_PATH = '/satellites';
    private const MOCK_SATELLITE_ID = 23232;
    private const MOCK_COORDINATE_RESPONSE = [
        Coordinate::FIELD_LNG => 32.323221,
        Coordinate::FIELD_LAT => 21.323422,
    ];

    /**
     * @var CoordinateFinderService
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

        $this->sut = new CoordinateFinderService($this->httpClient, self::MOCK_PATH);
    }

    public function testShouldBeInstantiable(): void
    {
        $this->assertInstanceOf(CoordinateFinderService::class, $this->sut);
    }

    public function testItShouldFindCoordinateBySatelliteId(): void
    {
        $this->httpClient
            ->expects($this->once())
            ->method('get')
            ->willReturn($this->httpResponse);

        $this->httpResponse
            ->expects($this->once())
            ->method('getBody')
            ->willReturn(json_encode(self::MOCK_COORDINATE_RESPONSE));

        $this->assertInstanceOf(Coordinate::class, $this->sut->find(self::MOCK_SATELLITE_ID));
    }

    public function testItShouldFailToFindCoordinateBySatelliteId(): void
    {
        $this->httpClient
            ->expects($this->once())
            ->method('get')
            ->willReturn($this->httpResponse);

        $this->httpResponse
            ->expects($this->once())
            ->method('getBody')
            ->willReturn(json_encode([]));

        $this->assertNull($this->sut->find(self::MOCK_SATELLITE_ID));
    }

    public function testItShouldFailToFindCoordinateByEmptySatelliteIdAndThrowException(): void
    {
        $this->expectException(SatelliteIdExpectedException::class);

        $this->assertNull($this->sut->find(null));
    }
}
