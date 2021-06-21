<?php

namespace App\Controller\Api\V1;

use App\Repository\EmergencyRepository;
use App\Repository\WasteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmergencyAndWasteSelectorsController extends AbstractController
{
    /**
     * @Route("/api/v1/public/EmergencyAndWaste", name="api_v1_emergency_and_waste_selectors", methods={"GET"})
     */
    public function index(WasteRepository $wasteRepository, EmergencyRepository $emergencyRepository): Response
    {
        // get emergencies
        $emergencies = $emergencyRepository->findAll();

        // get wastes
        $wastes = $wasteRepository->findAll();

        return $this->json([
            'emergencies' => $emergencies,
            'wastes' => $wastes,
        ], 200, [], [
            'groups' => 'emergency_and_waste'
        ]);
    }
}
