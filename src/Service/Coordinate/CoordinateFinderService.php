<?php

namespace App\Service\Coordinate;

use App\Exception\SatelliteIdExpectedException;
use App\Model\AbstractHttpClient;
use App\Model\Coordinate;
use App\Service\FinderInterface;

class CoordinateFinderService extends AbstractHttpClient implements FinderInterface
{
    public function find(?int $id): ?Coordinate
    {
        if (null === $id) {
            throw new SatelliteIdExpectedException();
        }

        try {
            $response = $this->httpClient->get($this->path . "/{$id}");
            $response = json_decode($response->getBody(), true);

            return CoordinateCreationService::createFrom($response);
        } catch (\Throwable $exception) {
        }

        return null;
    }
}
