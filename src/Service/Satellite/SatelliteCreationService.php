<?php

namespace App\Service\Satellite;

use App\Model\Satellite;
use App\Service\CollectionInterface;

class SatelliteCreationService implements CollectionInterface
{
    private function __construct()
    {
    }

    public static function createFrom(array $data): Satellite
    {
        return new Satellite(
            $data[Satellite::FIELD_ID],
            $data[Satellite::FIELD_NAME]
        );
    }
}
