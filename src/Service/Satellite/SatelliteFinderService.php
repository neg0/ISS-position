<?php

namespace App\Service\Satellite;

use App\Model\AbstractHttpClient;
use App\Model\Satellite;
use App\Service\FinderInterface;

class SatelliteFinderService extends AbstractHttpClient implements FinderInterface
{
    /**
     * @return Satellite[] | null
     */
    public function find(?int $id = null): ?array
    {
        try {
            $response = $this->httpClient->get($this->path);
            $response = json_decode($response->getBody(), true);

            $result = [];
            foreach ($response as $satellite) {
                array_push($result, SatelliteCreationService::createFrom($satellite));
            }

            return $result;
        } catch (\Throwable $exception) {
        }

        return null;
    }
}
