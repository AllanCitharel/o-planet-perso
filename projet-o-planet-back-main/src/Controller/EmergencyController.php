<?php

namespace App\Controller;

use App\Entity\Emergency;
use App\Form\EmergencyType;
use App\Repository\EmergencyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/emergency", name="admin_emergency_")
 */
class EmergencyController extends AbstractController
{
    /**
     * @Route("/", name="browse", methods={"GET"})
     */
    public function browse(EmergencyRepository $emergencyRepository): Response
    {
        return $this->render('admin/emergency/browse.html.twig', [
            'emergencies' => $emergencyRepository->findAll(),
        ]);
    }

    /**
     * @Route("/add", name="add", methods={"GET","POST"})
     */
    public function add(Request $request): Response
    {
        $emergency = new Emergency();
        $form = $this->createForm(EmergencyType::class, $emergency);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($emergency);
            $entityManager->flush();

            return $this->redirectToRoute('admin_emergency_browse');
        }

        return $this->render('admin/emergency/add.html.twig', [
            'emergency' => $emergency,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="read", methods={"GET"})
     */
    public function read(Emergency $emergency): Response
    {
        return $this->render('admin/emergency/read.html.twig', [
            'emergency' => $emergency,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","PUT","PATCH"})
     */
    public function edit(Request $request, Emergency $emergency): Response
    {
        $form = $this->createForm(EmergencyType::class, $emergency ,[
            'method' => 'PATCH',
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_emergency_browse');
        }

        return $this->render('admin/emergency/edit.html.twig', [
            'emergency' => $emergency,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, Emergency $emergency): Response
    {
        if ($this->isCsrfTokenValid('delete'.$emergency->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($emergency);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_emergency_browse');
    }
}
