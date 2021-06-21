<?php

namespace App\Controller\Api\V1;

use App\Entity\Removal;
use App\Form\RemovalType;
use App\Repository\RemovalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/api/v1/removals", name="api_v1_removals_")
 */
class RemovalController extends AbstractController
{
    /**
     * @Route("/", name="browse", methods={"GET"})
     */
    public function browse(RemovalRepository $removalRepository): Response
    {
        // get all removals
        $removals = $removalRepository->findAll();

        // return list of removals in JSON format 
        return $this->json($removals, 200, [] ,[
            'groups' => 'removal_browse',
        ]);
    }
    
    /**
     * @Route("/add", name="add", methods={"POST"})
     */
    public function add(Request $request): Response
    {
        $removal = new Removal();

        $form = $this->createForm(RemovalType::class, $removal, [
            'csrf_protection' => false,
        ]);
        
        $sentData = json_decode($request->getContent(), true);
        
        $form->submit($sentData);
       
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($removal);
            
            $em->flush();
            
            return $this->json($removal, 201, [], [
                'groups' => ['removal_read'],
            ]);
        } else {
            // if form is not valid, we send errors messages
                // first parameter with true : collect errors in all form'fields
                // second parameter with false : errors are organised by field
            $errors = $form->getErrors(true, false);
            // transform errors in string
            $errorString = (string) $errors;
          
            // we send http 400 error, it's an error on the validation so due to invalidates datas
            return $this->json($errorString, 400);
        }
    }

    /**
     * @Route("/{id}", name="edit", methods={"PUT", "PATCH"})
     */
    public function edit(Removal $removal, Request $request)
    {   
        $this->denyAccessUnlessGranted('edit', $removal);

        $form = $this->createForm(RemovalType::class, $removal, [
            'csrf_protection' => false,
        ]);

        $serializer = new Serializer(array(new DateTimeNormalizer()));

        $sentData = json_decode($request->getContent(), true);
    
        $dateAsObject = $serializer->denormalize($sentData['date'], \DateTime::class);

        $form->submit($sentData);

        $removal->setDate($dateAsObject);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $removal->setUpdatedAt(new \DateTime());
            $this->getDoctrine()->getManager()->flush();

            return $this->json($removal, 200, [], [
                'groups' => ['removal_read'],
            ]);
        }

        return $this->json($form->getErrors(true, false)->__toString(), 400);
    }

    /**
     * @Route("/close/{id}", name="close", methods={"PUT", "PATCH"})
     */
    public function close(Removal $removal, Request $request)
    {   
        $this->denyAccessUnlessGranted('edit', $removal);

        $form = $this->createForm(RemovalType::class, $removal, [
            'csrf_protection' => false,
        ]);

        $serializer = new Serializer(array(new DateTimeNormalizer()));

        $sentData = json_decode($request->getContent(), true);

        $sentData['date'] = $removal->getDate()->format('Y-m-d H:i:s');
        $sentData['dump'] = $removal->getDump()->getId();
        $sentData['creator'] = $removal->getCreator()->getId();
        $sentData['isFinished'] = true;
    
        $dateAsObject = $serializer->denormalize($sentData['date'], \DateTime::class);

        $form->submit($sentData);

        $removal->setDate($dateAsObject);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $removal->setUpdatedAt(new \DateTime());
            $this->getDoctrine()->getManager()->flush();

            return $this->json($removal, 200, [], [
                'groups' => ['removal_read'],
            ]);
        }

        return $this->json($form->getErrors(true, false)->__toString(), 400);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"}, requirements={"id": "\d+"})
     */
    public function delete(Removal $removal): Response
    {
        $this->denyAccessUnlessGranted('delete', $removal);

        $em = $this->getDoctrine()->getManager();
        $em->remove($removal);
        $em->flush();

        // send no content 204 response
        return $this->json(null, 204);
    }

    /**
     * @Route("/subscribe/{id}", name="subscribeToRemoval", methods={"POST"})
     */
    public function subscribToRemoval(RemovalRepository $removalRepository, Removal $removal)
    {
        $user = $this->getUser();


        $user->addSubscribedRemoval($removal);

        $this->getDoctrine()->getManager()->flush();

        return $this->json($removal, 200, [], [
            'groups' => ['subscribeToRemoval'],
        ]);

    }

    /**
     * @Route("/unsubscribe/{id}", name="unsubscribeToRemoval", methods={"POST"})
     */
    public function unsubscribToRemoval(RemovalRepository $removalRepository, Removal $removal)
    {
        $user = $this->getUser();

        $user->removeSubscribedRemoval($removal);

        $this->getDoctrine()->getManager()->flush();

        return $this->json($removal, 200, [], [
            'groups' => ['subscribeToRemoval'],
        ]);

    }
}
