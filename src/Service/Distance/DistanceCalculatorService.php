<?php

namespace App\Service\Distance;

use App\Model\Coordinate;
use App\Model\Distance;
use App\Service\Satellite\ISSBuilderService;

class DistanceCalculatorService
{
    private const EARTH_RADIUS_IN_KILOMETER = 6371;
    private const ISS_DISTANCE_FROM_EARTH_IN_KILOMETER = 408;

    /**
     * @var ISSBuilderService
     */
    private $issBuilderService;

    public function __construct(ISSBuilderService $issBuilderService)
    {
        $this->issBuilderService = $issBuilderService;
    }

    public function getDistance(Coordinate $toCoordinate): ?Distance
    {
        try {
            $fromCoordinate = $this->issBuilderService->build()->getCoordinate();
            $distance = $this->calculate($fromCoordinate, $toCoordinate);

            return new Distance($distance);
        } catch (\Throwable $exception) {
        }

        return null;
    }

    private function calculate(Coordinate $fromCoordinate, Coordinate $toCoordinate): float
    {
        $fromLat = $fromCoordinate->getLat();
        $fromLng = $fromCoordinate->getLng();
        $toLat = $toCoordinate->getLat();
        $toLng = $toCoordinate->getLng();

        $dLat = deg2rad($toLat - $fromLat);
        $dLng = deg2rad($toLng - $fromLng);

        $toLatCos = cos(deg2rad($fromLat)) * cos(deg2rad($toLat));
        $toLngSin = sin($dLng / 2) * sin($dLng / 2);
        $radialLat = sin($dLat / 2) * sin($dLat / 2);

        $a = ($toLatCos * $toLngSin) + $radialLat;
        $c = 2 * asin(sqrt($a));

        return (self::EARTH_RADIUS_IN_KILOMETER + self::ISS_DISTANCE_FROM_EARTH_IN_KILOMETER) * $c;
    }
}
