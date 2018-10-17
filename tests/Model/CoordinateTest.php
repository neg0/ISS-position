<?php

namespace App\Tests\Model;

use App\Exception\LatitudeInvalidException;
use App\Exception\LongitudeInvalidException;
use App\Model\Coordinate;
use PHPUnit\Framework\TestCase;

class CoordinateTest extends TestCase
{
    /**
     * @var Coordinate
     */
    private $sut;

    public function testShouldNotCreateCoordinateAndThrowExceptionForInvalidLatitude(): void
    {
        $this->expectException(LatitudeInvalidException::class);

        $this->sut = new Coordinate(-110.23232, 23.323234);
    }

    public function testShouldNotCreateCoordinateAndThrowExceptionForInvalidLongitude(): void
    {
        $this->expectException(LongitudeInvalidException::class);

        $this->sut = new Coordinate(-71.23232, 182.323234);
    }
}
