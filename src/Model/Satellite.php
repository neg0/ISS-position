<?php

namespace App\Model;

class Satellite implements Arrayable
{
    public const FIELD_ID = 'id';
    public const FIELD_NAME = 'name';

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Coordinate | null
     */
    private $coordinate;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCoordinate(): ?Coordinate
    {
        return $this->coordinate;
    }

    public function setCoordinate(Coordinate $coordinate): self
    {
        $this->coordinate = $coordinate;

        return $this;
    }

    public function toArray(): array
    {
        $array = [
            self::FIELD_ID => $this->id,
            self::FIELD_NAME => $this->name,
        ];

        if ($this->coordinate) {
            $array[Coordinate::NAME] = $this->coordinate->toArray();
        }

        return $array;
    }
}
