<?php

namespace App\Controller;

use App\Entity\Dump;
use App\Form\DumpType;
use App\Form\TestDumpType;
use App\Repository\DumpRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/testdump", name="admin_testdump_")
 */
class TestDumpController extends AbstractController
{
    /**
     * @Route("/", name="browse", methods={"GET"})
     */
    public function browse(DumpRepository $dumpRepository): Response
    {

        // dd($dumpRepository->findAll());
        // send list of dumps to admin browse view
        return $this->render('admin/dump/browse.html.twig', [
            'dumps' => $dumpRepository->findAll(),
        ]);
    }

    /**
     * @Route("/add", name="add", methods={"GET","POST"})
     */
    public function add(Request $request): Response
    {
        // Generate a dump form
        $dump = new Dump();
        $form = $this->createForm(TestDumpType::class, $dump);

        // Allow form to get the elements in the request
        $form->handleRequest($request);

        // add dump to database if form is submitted and valid
        if ($form->isSubmitted() && $form->isValid()) {

            
            // // redirect to admin browse page
            // return $this->redirectToRoute('admin_testdump_browse');
            // dump($dump);
            $dumpImages = $request->files->get('test_dump');

            foreach($dumpImages as $dumpImage){
                if ($dumpImage !== null){
                    $imageUniqueId = uniqid('dump') . '.' . $dumpImage->getClientOriginalExtension();
                    $dump->setPicture1($imageUniqueId);

                    file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/images/dumps/' . $imageUniqueId , file_get_contents($dumpImage));
                }
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($dump);
            $entityManager->flush();

            return $this->redirectToRoute('admin_dump_browse');
        }


        // return to add page if form is incorrect
        return $this->render('admin/dump/add.html.twig', [
            'dump' => $dump,
            'form' => $form->createView(),
            ]);

    }
            
    /**
     * @Route("/{id}", name="read", methods={"GET"})
     */
    public function read(Dump $dump): Response
    {
        // show page to display a dump's detail
        return $this->render('admin/dump/read.html.twig', [
            'dump' => $dump,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","PUT","PATCH"})
     */
    public function edit(Request $request, Dump $dump): Response
    {
        // Generate a dump form with the information for a given dump
        $form = $this->createForm(DumpType::class, $dump);
        $form->handleRequest($request);

        // send dump updates to database if form is submitted and valid
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            // redirect to admin browse page
            return $this->redirectToRoute('admin_testdump_browse');
        }

        // return to edit page if form is incorrect
        return $this->render('admin/dump/edit.html.twig', [
            'dump' => $dump,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, Dump $dump): Response
    {
        // Remove dump from database if form token from submitted form is the same as the one set when form was generated 
        if ($this->isCsrfTokenValid('delete'.$dump->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($dump);
            $entityManager->flush();
        }

        // return to dump browse page
        return $this->redirectToRoute('admin_testdump_browse');
    }
}
