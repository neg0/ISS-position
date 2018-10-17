<?php

namespace App\Model;

class Distance implements Arrayable
{
    public const DEFAULT_UNIT = 'Kilometer';
    public const FIELD_DISTANCE = 'distance';
    public const FIELD_UNIT = 'unit';

    /**
     * @var float
     */
    public $distance;

    /**
     * @var string
     */
    public $unit;

    public function __construct(float $distance, string $unit = self::DEFAULT_UNIT)
    {
        $this->distance = number_format($distance, 2);
        $this->unit = $unit;
    }

    public function toArray(): array
    {
        return [
            self::FIELD_DISTANCE => $this->distance,
            self::FIELD_UNIT => $this->unit,
        ];
    }
}
