<?php

namespace App\Controller;

use App\Entity\Removal;
use App\Form\RemovalType;
use App\Repository\RemovalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/removal", name="admin_removal_")
 */
class RemovalController extends AbstractController
{
    /**
     * @Route("/", name="browse", methods={"GET"})
     */
    public function browse(RemovalRepository $removalRepository): Response
    {
        return $this->render('admin/removal/browse.html.twig', [
            'removals' => $removalRepository->findAll(),
        ]);
    }

    /**
     * @Route("/add", name="add", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $removal = new Removal();
        $form = $this->createForm(RemovalType::class, $removal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($removal);
            $entityManager->flush();

            return $this->redirectToRoute('admin_removal_browse');
        }

        return $this->render('admin/removal/add.html.twig', [
            'removal' => $removal,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="read", methods={"GET"})
     */
    public function show(Removal $removal): Response
    {
        return $this->render('admin/removal/read.html.twig', [
            'removal' => $removal,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Removal $removal): Response
    {
        $form = $this->createForm(RemovalType::class, $removal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $removal->setUpdatedAt(new \DateTime());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_removal_browse');
        }

        return $this->render('admin/removal/edit.html.twig', [
            'removal' => $removal,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, Removal $removal): Response
    {
        // if csrf token is not valid, the request is not executed
        if ($this->isCsrfTokenValid('delete'.$removal->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($removal);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_removal_browse');
    }
}
