<?php

namespace App\Controller;

use App\Entity\Election;
use App\Form\ElectionType;
use App\Repository\ElectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/election")
 */
class ElectionController extends AbstractController
{
    /**
     * @Route("/", name="election_index", methods={"GET"})
     */
    public function index(ElectionRepository $electionRepository): Response
    {
        return $this->render('election/index.html.twig', [
            'elections' => $electionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="election_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $election = new Election();
        $form = $this->createForm(ElectionType::class, $election);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($election);
            foreach ($election->getScrutins() as $scrutin) {
                $scrutin->setElection($election);
                $entityManager->persist($scrutin);
            }
            $entityManager->flush();

            return $this->redirectToRoute('election_index');
        }

        return $this->render('election/new.html.twig', [
            'election' => $election,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="election_show", methods={"GET"})
     */
    public function show(Election $election): Response
    {
        return $this->render('election/show.html.twig', [
            'election' => $election,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="election_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Election $election): Response
    {
        $form = $this->createForm(ElectionType::class, $election);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->persist($election);
            foreach ($election->getScrutins() as $scrutin) {
                $scrutin->setElection($election);
                $this->getDoctrine()->getManager()->persist($scrutin);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('election_index', [
                'id' => $election->getId(),
            ]);
        }

        return $this->render('election/new.html.twig', [
            'election' => $election,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="election_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Election $election): Response
    {
        if ($this->isCsrfTokenValid('delete'.$election->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($election);
            $entityManager->flush();
        }

        return $this->redirectToRoute('election_index');
    }
}
