<?php

namespace App\Controller\Api\V1;

use App\Repository\DumpRepository;
use App\Repository\RemovalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatisticsController extends AbstractController
{
    /**
     * @Route("/api/v1/public/statistics", name="api_v1_statistics", methods={"GET"})
     */
    public function index(DumpRepository $dumpRepository, RemovalRepository $removalRepository): Response
    {

        // number of dumps posted
        $numberOfDumps = count($dumpRepository->findAll());
        
        // number of opened dumps
        $numberOfOpenedDumps = count($dumpRepository->findOpenedDumps());
        
        // number of closed dumps (dumps closed after removals)
        $cleanedDumps = count($dumpRepository->findCleanedDumps());
        
        // number of removals to sign up to (start date in the future)
        $scheduledRemovals = count($removalRepository->scheduledRemovals());


        return $this->json([
            'dumps déclarés' => $numberOfDumps,
            'dumps restant à nettoyer' => $numberOfOpenedDumps,
            'dumps nettoyés' => $cleanedDumps,
            'campagnes de ramassage ouvertes' => $scheduledRemovals,
            ]);
    }
}
