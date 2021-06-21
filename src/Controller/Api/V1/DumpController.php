<?php

namespace App\Controller\Api\V1;

use App\Entity\Dump;
use App\Form\DumpType;
use App\Repository\DumpRepository;
use App\Service\SaveFiles;
use App\Service\SaveImages;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/api/v1", name="api_v1_dumps_")
 */
class DumpController extends AbstractController
{
    /**
     * @Route("/public/dumps", name="browse", methods={"GET"})
     */
    public function browse(Request $request, DumpRepository $dumpRepository): Response
    {
        if(count($request->query) != 0) {
            // check if request contains GET parameters
            $longitudeCoordinatesGET = $request->query->get("longitudeCoordinate");
            $latitudeCoordinatesGET = $request->query->get("latitudeCoordinate");
            $emergency = $request->query->get("emergency");
            $wastesGET = $request->query->get("wastes");

            // get dumps coordinates
            if($longitudeCoordinatesGET && $latitudeCoordinatesGET){
                $longitudeCoordinates = explode(",", $longitudeCoordinatesGET);
                $latitudeCoordinates = explode(",", $latitudeCoordinatesGET);
            } else {
                $longitudeCoordinates = null;
                $latitudeCoordinates = null;
            }

            // get list of wastes
            if ($wastesGET) {
                $wastesIds = explode(",", $wastesGET);
            } else {
                $wastesIds = null;
            }
            
            // get list of dumps with GET parameters as filters
            // ?latitudeCoordinate=12.3,123.6&longitudeCoordinate=12.3,123.6&emergency=1&wastes=1,3
            $dumps = $dumpRepository->findDumpsWithGetParameters(
                $longitudeCoordinates,
                $latitudeCoordinates,
                $emergency,
                $wastesIds
            );
        } else {
            // get all dumps
            $dumps = $dumpRepository->findAllByCreationDateDesc();
        }

        // return list of dump in JSON format 
        return $this->json($dumps, 200, [] ,[
            'groups' => 'browse',
        ]);
    }


    /**
     * @Route("/public/dumps/{id}", name="read", requirements={"id" : "\d+"}, methods={"GET"})
     */
    public function read(DumpRepository $dumpRepository, Dump $dump): Response
    {
        // get requested dump
        $dump = $dumpRepository->find($dump);

        // return dump info in JSON format 
        return $this->json($dump, 200, [] ,[
            'groups' => 'read',
        ]);
    }

    /**
     * @Route("/dumps", name="add", methods={"POST"})
     *
     */
    public function add(Request $request, SaveFiles $saveFiles) :Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
       
        // Generate a dump form
        $dump = new Dump();
        $form = $this->createForm(DumpType::class, $dump, [
            'csrf_protection' => false,
        ]);

        try{
            $sentData = json_decode($request->request->get('dump'), true);
           
        }catch(Exception $e){
            return $this->json('no dump object found in post request');
        }

        if (count($sentData['wastes']) === 0 || $sentData['wastes'] == []){
            return $this->json('Waste cannot be null', 404);
        }

        // Submit form
        $form->submit($sentData);
        
        // add dump to database if form is submitted and valid
        if ($form->isSubmitted() && $form->isValid()) {

            $dumpImages = $request->files;

            if(count($dumpImages) != 0){

                // return $this->json($dump);
                foreach($dumpImages as $dumpImage){
                    if ($dumpImage !== null){

                        $imageUniqueId = $saveFiles->saveImageWithUniqueId($dumpImage);
                        
                        // $imageUniqueId = uniqid('dump') . '.' . $dumpImage->getClientOriginalExtension();
                        $dump->setPicture1($imageUniqueId);
                        
                        // file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/images/dumps/' . $imageUniqueId , file_get_contents($dumpImage));
                    }
                }
                
            } else {
                $dump->setPicture1('000-dump-placeholder.jpg');
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($dump);
            try {
                //code...
                $entityManager->flush();
            } catch (\Throwable $th) {
                //throw $th;
                return $this->json($th);
            }

            return $this->json($dump->getId(), 201);
        }

        // return error bad request
        return $this->json('Une erreur est survenu lors de l\'ajout du dump. veuillez Recommencer.' , 400);

    }

    /**
     * @Route("/dumps/{id}", name="edit", methods={"PUT", "PATCH"})
     *
     */
    public function edit(Request $request, Dump $dump, SaveFiles $saveFiles) :Response
    {
        // return $this->json($dump, 200, [], [
        //     'groups' => 'read',
        // ]);
                                                                                
        $this->denyAccessUnlessGranted('edit', $dump);
        $sentData = json_decode($request->getContent(), true);
        // $sentData = json_decode($request->request->get('dump'), true);

        // get userId, picture1 and removals from database
        $sentData['user'] = $dump->getUser()->getId();
        $currentPicture = $dump->getPicture1();
        $sentData['picture1'] = $currentPicture;

        $oldRemovals = null;
        if($dump->getRemovals()){
            foreach($dump->getRemovals() as $removal){
                $oldRemovals[] = $removal;
            }
        }
        
        // send error form doesn't have any wastes
        if (count($sentData['wastes']) === 0 || $sentData['wastes'] == []){
            return $this->json('Waste cannot be null', 404);
        }
        
        $form = $this->createForm(DumpType::class, $dump, [
            'csrf_protection' => false
            ]);
            
        $form->submit($sentData);
        
        if($form->isValid()){

            $dumpImages = $request->files;

            // return $this->json($dumpImages);
            if(count($dumpImages) != 0){

                // return $this->json($dump);
                foreach($dumpImages as $dumpImage){
                    if ($dumpImage !== null){

                        $imageUniqueId = $saveFiles->saveImageWithUniqueId($dumpImage);
                        
                        $dump->setPicture1($imageUniqueId);
                        
                    }
                }
                
            } else {
                $dump->setPicture1($currentPicture);
            }
            
            $dump->setUpdatedAt(new \DateTime());
            
            // populate removals with all removals assigned to dump
            if($oldRemovals){
                foreach($oldRemovals as $removal){
                    $dump->addRemovals($removal);
                }
            }
            // return $this->json($request->files);
            // return $this->json($dump, 200, [], ['groups' => 'read']);
            
            $this->getDoctrine()->getManager()->flush();
            
            // return $this->json($form);
            
            return $this->json($dump, 201, [], [
                'groups' => 'read'
                ]);
        } 

        return $this->json('form not valid', 400);

    }

    /**
     * @Route("/dumps/close/{id}", name="close", methods={"PUT", "PATCH"})
     *
     */
    public function close(Request $request, Dump $dump) :Response
    {                                                                           
        $this->denyAccessUnlessGranted('edit', $dump);
        $sentData = json_decode($request->getContent(), true);

        $sentData['user'] = $dump->getUser()->getId();
        $sentData['picture1'] = $dump->getPicture1();
        $sentData['title'] = $dump->getTitle();
        $sentData['latitudeCoordinate'] = $dump->getLatitudeCoordinate();
        $sentData['longitudeCoordinate'] = $dump->getLongitudeCoordinate();
        $sentData['description'] = $dump->getDescription();
        $sentData['emergency'] = $dump->getEmergency()->getId();
        $sentData['isClosed'] = true;
        foreach ($dump->getWastes() as $waste) {
            $wasteArray[] = $waste->getId();
            $sentData['wastes'] = $wasteArray;
        }

        if (count($sentData['wastes']) === 0 || $sentData['wastes'] == []){
            return $this->json('Waste cannot be null', 404);
        }
        
        $form = $this->createForm(DumpType::class, $dump, [
            'csrf_protection' => false
        ]);

        $form->submit($sentData);

        if($form->isValid()){

            $dump->setUpdatedAt(new \DateTime());
            
            $this->getDoctrine()->getManager()->flush();
            
            return $this->json($dump, 201, [], [
                'groups' => 'read'
                ]);
        } 

        return $this->json($form->getErrors(true, false)->__toString(), 400);
    }



    /**
     * @Route("/dumps/{id}", name="delete", methods={"DELETE"}, requirements={"id" : "\d+"},)
     *
     */
    public function delete(Request $request, Dump $dump)
    {
        $this->denyAccessUnlessGranted('delete', $dump);

        $sentData['user'] = $dump->getUser()->getId();

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($dump);
        $entityManager->flush();

        // return to dump browse page
        return $this->json('dump deleted', 204);
    }
    
}
