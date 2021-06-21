<?php

namespace App\Controller;

use App\Entity\Waste;
use App\Form\WasteType;
use App\Repository\WasteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/waste", name="admin_waste_")
 */
class WasteController extends AbstractController
{
    /**
     * @Route("/", name="browse", methods={"GET"})
     */
    public function browse(WasteRepository $wasteRepository): Response
    {
        return $this->render('admin/waste/browse.html.twig', [
            'wastes' => $wasteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/add", name="add", methods={"GET","POST"})
     */
    public function add(Request $request): Response
    {
        $waste = new Waste();
        $form = $this->createForm(WasteType::class, $waste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($waste);
            $entityManager->flush();

            return $this->redirectToRoute('admin_waste_browse');
        }

        return $this->render('admin/waste/add.html.twig', [
            'waste' => $waste,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="read", methods={"GET"})
     */
    public function read(Waste $waste): Response
    {
        return $this->render('admin/waste/read.html.twig', [
            'waste' => $waste,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Waste $waste): Response
    {
        $form = $this->createForm(WasteType::class, $waste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $waste->setUpdatedAt(new \DateTime);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_waste_browse');
        }

        return $this->render('admin/waste/edit.html.twig', [
            'waste' => $waste,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, Waste $waste): Response
    {
        if ($this->isCsrfTokenValid('delete'.$waste->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($waste);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_waste_browse');
    }
}
