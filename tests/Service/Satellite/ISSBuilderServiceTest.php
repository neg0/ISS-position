<?php

namespace App\Tests\Service\Satellite;

use App\Model\Coordinate;
use App\Model\Satellite;
use App\Service\Coordinate\CoordinateFinderService;
use App\Service\Satellite\ISSBuilderService;
use App\Service\Satellite\SatelliteFinderService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ISSBuilderServiceTest extends TestCase
{
    private const MOCK_SATELLITE_ID = 75623;

    /**
     * @var ISSBuilderService
     */
    private $sut;

    /**
     * @var SatelliteFinderService | MockObject
     */
    private $satelliteFinderService;

    /**
     * @var CoordinateFinderService | MockObject
     */
    private $coordinateFinderService;

    protected function setUp(): void
    {
        $this->satelliteFinderService = $this->createMock(SatelliteFinderService::class);
        $this->coordinateFinderService = $this->createMock(CoordinateFinderService::class);

        $this->sut = new ISSBuilderService(
            $this->satelliteFinderService,
            $this->coordinateFinderService
        );
    }

    public function testShouldBeInstantiable(): void
    {
        $this->assertInstanceOf(ISSBuilderService::class, $this->sut);
    }

    public function testShouldNotBuildISSAndThrowException(): void
    {
        $this->expectException(\Exception::class);

        $this->satelliteFinderService
            ->expects($this->once())
            ->method('find')
            ->willReturn(null);

        $this->assertNull($this->sut->build());
    }

    public function testShouldBuildISS(): void
    {
        $satellite = $this->createMock(Satellite::class);
        $coordinate = $this->createMock(Coordinate::class);

        $this->satelliteFinderService
            ->expects($this->once())
            ->method('find')
            ->willReturn([$satellite]);

        $satellite
            ->expects($this->once())
            ->method('getName')
            ->willReturn(ISSBuilderService::NAME);

        $satellite
            ->expects($this->once())
            ->method('getId')
            ->willReturn(self::MOCK_SATELLITE_ID);

        $this->coordinateFinderService
            ->expects($this->once())
            ->method('find')
            ->willReturn($coordinate);

        $satellite
            ->expects($this->once())
            ->method('setCoordinate')
            ->willReturn($satellite);

        $this->assertInstanceOf(Satellite::class, $this->sut->build());
    }
}
