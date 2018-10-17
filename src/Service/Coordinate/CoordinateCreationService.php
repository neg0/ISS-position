<?php

namespace App\Service\Coordinate;

use App\Model\Coordinate;
use App\Service\CollectionInterface;

class CoordinateCreationService implements CollectionInterface
{
    private function __construct()
    {
    }

    public static function createFrom(array $data): Coordinate
    {
        return new Coordinate(
            $data[Coordinate::FIELD_LAT],
            $data[Coordinate::FIELD_LNG]
        );
    }
}
