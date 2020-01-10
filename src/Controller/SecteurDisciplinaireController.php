<?php

namespace App\Controller;

use App\Entity\SecteurDisciplinaire;
use App\Form\SecteurDisciplinaireType;
use App\Repository\SecteurDisciplinaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/secteur/disciplinaire")
 */
class SecteurDisciplinaireController extends AbstractController
{
    /**
     * @Route("/", name="secteur_disciplinaire_index", methods={"GET"})
     */
    public function index(SecteurDisciplinaireRepository $secteurDisciplinaireRepository): Response
    {
        return $this->render('secteur_disciplinaire/index.html.twig', [
            'secteur_disciplinaires' => $secteurDisciplinaireRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="secteur_disciplinaire_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $secteurDisciplinaire = new SecteurDisciplinaire();
        $form = $this->createForm(SecteurDisciplinaireType::class, $secteurDisciplinaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($secteurDisciplinaire);
            $entityManager->flush();

            return $this->redirectToRoute('secteur_disciplinaire_index');
        }

        return $this->render('secteur_disciplinaire/new.html.twig', [
            'secteur_disciplinaire' => $secteurDisciplinaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="secteur_disciplinaire_show", methods={"GET"})
     */
    public function show(SecteurDisciplinaire $secteurDisciplinaire): Response
    {
        return $this->render('secteur_disciplinaire/show.html.twig', [
            'secteur_disciplinaire' => $secteurDisciplinaire,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="secteur_disciplinaire_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SecteurDisciplinaire $secteurDisciplinaire): Response
    {
        $form = $this->createForm(SecteurDisciplinaireType::class, $secteurDisciplinaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('secteur_disciplinaire_index', [
                'id' => $secteurDisciplinaire->getId(),
            ]);
        }

        return $this->render('secteur_disciplinaire/edit.html.twig', [
            'secteur_disciplinaire' => $secteurDisciplinaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="secteur_disciplinaire_delete", methods={"DELETE"})
     */
    public function delete(Request $request, SecteurDisciplinaire $secteurDisciplinaire): Response
    {
        if ($this->isCsrfTokenValid('delete'.$secteurDisciplinaire->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($secteurDisciplinaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('secteur_disciplinaire_index');
    }
}
