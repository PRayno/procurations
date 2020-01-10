<?php

namespace App\Controller;

use App\Entity\Procuration;
use App\Entity\Scrutin;
use App\Form\ProcurationType;
use App\Repository\ProcurationRepository;
use App\Repository\ScrutinRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/procuration")
 */
class ProcurationController extends AbstractController
{
    /**
     * @Route("/", name="procuration_index", methods={"GET"})
     */
    public function index(ProcurationRepository $procurationRepository): Response
    {
        return $this->render('procuration/index.html.twig', [
            'procurations' => $procurationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/list", name="procuration_list", methods={"GET"})
     */
    public function list(Scrutin $scrutin, ProcurationRepository $procurationRepository)
    {
        return $this->render('procuration/list.html.twig', [
            'procurations'  => $procurationRepository->findByScrutin($scrutin),
            'scrutin'       => $scrutin
        ]);
    }

    /**
     * @Route("/export/{id}", name="procuration_export", methods={"GET"})
     */
    public function export($id = null, ProcurationRepository $procurationRepository, ScrutinRepository $scrutinRepository, Request $request)
    {
        $procurations = (isset($id)) ?
            $procurationRepository->findByScrutin($scrutinRepository->find($request->get('id'))) : $procurationRepository->findBy([], ['scrutin' => 'ASC']);

        $response = $this->render('procuration/export.html.twig', ['procurations'=>$procurations, 'scrutin'=>isset($id)]);

        $response->setStatusCode(200);
        $response->headers->set('Content-Encoding', 'ISO-8859-1');
        $response->headers->set('Content-Type', 'text/csv;');
        $response->headers->set('Content-Disposition', 'attachment; filename="procurations.csv"');

        return $response;

    }

    /**
     * @Route("/new", name="procuration_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $procuration = new Procuration();
        $form = $this->createForm(ProcurationType::class, $procuration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($procuration);
            $entityManager->flush();

            return $this->redirectToRoute('procuration_index');
        }

        return $this->render('procuration/new.html.twig', [
            'procuration' => $procuration,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="procuration_show", methods={"GET"})
     */
    public function show(Procuration $procuration): Response
    {
        return $this->render('procuration/show.html.twig', [
            'procuration' => $procuration,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="procuration_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Procuration $procuration): Response
    {
        $form = $this->createForm(ProcurationType::class, $procuration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('procuration_index', [
                'id' => $procuration->getId(),
            ]);
        }

        return $this->render('procuration/edit.html.twig', [
            'procuration' => $procuration,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="procuration_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Procuration $procuration): Response
    {
        if ($this->isCsrfTokenValid('delete'.$procuration->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($procuration);
            $entityManager->flush();
        }

        return $this->redirectToRoute('procuration_index');
    }
}
