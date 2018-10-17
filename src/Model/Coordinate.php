<?php

namespace App\Model;

use App\Exception\LatitudeInvalidException;
use App\Exception\LongitudeInvalidException;

class Coordinate implements Arrayable
{
    public const NAME = 'coordinates';
    public const FIELD_LAT = 'latitude';
    public const FIELD_LNG = 'longitude';

    /**
     * @var float
     */
    private $lat;

    /**
     * @var float
     */
    private $lng;

    public function __construct(float $lat, float $lng)
    {
        if ($lat < -90 || $lat > 90) {
            throw new LatitudeInvalidException();
        }

        if ($lng < -180 || $lng > 180) {
            throw new LongitudeInvalidException();
        }

        $this->lat = $lat;
        $this->lng = $lng;
    }

    public function getLat(): float
    {
        return $this->lat;
    }

    public function getLng(): float
    {
        return $this->lng;
    }

    public function toArray(): array
    {
        return [
            self::FIELD_LAT => $this->lat,
            self::FIELD_LNG => $this->lng,
        ];
    }
}
