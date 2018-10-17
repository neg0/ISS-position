<?php

namespace App\Tests\Service\Distance;

use App\Model\Coordinate;
use App\Model\Distance;
use App\Model\Satellite;
use App\Service\Distance\DistanceCalculatorService;
use App\Service\Satellite\ISSBuilderService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DistanceCalculatorServiceTest extends TestCase
{
    /**
     * @var DistanceCalculatorService
     */
    private $sut;

    /**
     * @var ISSBuilderService | MockObject
     */
    private $issBuilderService;

    protected function setUp(): void
    {
        $this->issBuilderService = $this->createMock(ISSBuilderService::class);

        $this->sut = new DistanceCalculatorService($this->issBuilderService);
    }

    public function testShouldBeInstantiable(): void
    {
        $this->assertInstanceOf(DistanceCalculatorService::class, $this->sut);
    }

    public function testShouldCalculateDistanceBetweenTwoCoordinates(): void
    {
        $satellite = $this->createMock(Satellite::class);
        $toCoordinate = $this->createMock(Coordinate::class);
        $fromCoordinate = $this->createMock(Coordinate::class);

        $this->issBuilderService
            ->expects($this->once())
            ->method('build')
            ->willReturn($satellite);

        $satellite
            ->expects($this->once())
            ->method('getCoordinate')
            ->willReturn($fromCoordinate);

        $toCoordinate
            ->expects($this->once())
            ->method('getLat')
            ->willReturn(35.807931);

        $toCoordinate
            ->expects($this->once())
            ->method('getLng')
            ->willReturn(158.602656);

        $fromCoordinate
            ->expects($this->once())
            ->method('getLat')
            ->willReturn(53.480759);

        $fromCoordinate
            ->expects($this->once())
            ->method('getLng')
            ->willReturn(-2.242631);

        $this->assertInstanceOf(Distance::class, $this->sut->getDistance($toCoordinate));
    }
}
