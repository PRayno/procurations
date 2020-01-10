<?php

namespace App\Controller;

use App\Entity\Scrutin;
use App\Form\Scrutin1Type;
use App\Repository\ScrutinRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/scrutin")
 */
class ScrutinController extends AbstractController
{
    /**
     * @Route("/", name="scrutin_index", methods={"GET"})
     */
    public function index(ScrutinRepository $scrutinRepository): Response
    {
        return $this->render('scrutin/index.html.twig', [
            'scrutins' => $scrutinRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="scrutin_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $scrutin = new Scrutin();
        $form = $this->createForm(Scrutin1Type::class, $scrutin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($scrutin);
            $entityManager->flush();

            return $this->redirectToRoute('scrutin_index');
        }

        return $this->render('scrutin/new.html.twig', [
            'scrutin' => $scrutin,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="scrutin_show", methods={"GET"})
     */
    public function show(Scrutin $scrutin): Response
    {
        return $this->render('scrutin/show.html.twig', [
            'scrutin' => $scrutin,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="scrutin_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Scrutin $scrutin): Response
    {
        $form = $this->createForm(Scrutin1Type::class, $scrutin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('scrutin_index', [
                'id' => $scrutin->getId(),
            ]);
        }

        return $this->render('scrutin/edit.html.twig', [
            'scrutin' => $scrutin,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="scrutin_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Scrutin $scrutin): Response
    {
        if ($this->isCsrfTokenValid('delete'.$scrutin->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($scrutin);
            $entityManager->flush();
        }

        return $this->redirectToRoute('election_index');
    }
}
