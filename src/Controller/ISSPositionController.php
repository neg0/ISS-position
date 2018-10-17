<?php

namespace App\Controller;

use App\Form\CoordinateType;
use App\Model\Coordinate;
use App\Service\Distance\DistanceCalculatorService;
use App\Service\Satellite\ISSBuilderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ISSPositionController extends AbstractController
{
    /**
     * @Route("/iss/position", name="iss_position", methods={"GET"})
     */
    public function readISSPosition(ISSBuilderService $issBuilderService): JsonResponse
    {
        try {
            $iss = $issBuilderService->build();

            return $this->json($iss->toArray());
        } catch (\Throwable $exception) {
        }

        return $this->json([ 'error' => 'Could not find the ISS' ], Response::HTTP_NOT_FOUND);
    }

    /**
     * @Route("/iss/position/distance", name="iss_distance", methods={"POST"})
     */
    public function createISSDistance(Request $request, DistanceCalculatorService $distanceCalculator): JsonResponse
    {
        $form = $this->createForm(CoordinateType::class);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isValid()) {
            try {
                /** @var Coordinate $toCoordinate */
                $toCoordinate = $form->getData();
                $distance = $distanceCalculator->getDistance($toCoordinate);

                return $this->json($distance->toArray());
            } catch (\Throwable $exception) {
            }

            return $this->json([ 'error' => 'Could not find the ISS' ], Response::HTTP_NOT_FOUND);
        }
    }
}
