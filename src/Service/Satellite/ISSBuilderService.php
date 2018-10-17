<?php

namespace App\Service\Satellite;

use App\Exception\SatelliteNotFoundException;
use App\Model\Satellite;
use App\Service\Coordinate\CoordinateFinderService;

class ISSBuilderService
{
    public const NAME = 'iss';

    /**
     * @var SatelliteFinderService
     */
    private $satelliteFinderService;

    /**
     * @var CoordinateFinderService
     */
    private $coordinateFinderService;

    public function __construct(
        SatelliteFinderService $satelliteFinderService,
        CoordinateFinderService $coordinateFinderService
    ) {
        $this->satelliteFinderService = $satelliteFinderService;
        $this->coordinateFinderService = $coordinateFinderService;
    }

    /**
     * @throws \Exception
     */
    public function build(): ?Satellite
    {
        $satellites = $this->satelliteFinderService->find();
        if (null === $satellites) {
            throw new SatelliteNotFoundException();
        }

        foreach ($satellites as $satellite) {
            if (self::NAME === $satellite->getName()) {
                $coordinate = $this->coordinateFinderService->find($satellite->getId());

                return $satellite->setCoordinate($coordinate);
            }
        }

        return null;
    }
}
