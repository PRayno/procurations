<?php

namespace App\Controller;

use App\Entity\Procuration;
use App\Entity\Scrutin;
use App\Form\ProcurationType;
use App\Logic\LDAP;
use App\Logic\PDF;
use App\Repository\ElectionRepository;
use App\Repository\ProcurationRepository;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublicController extends AbstractController
{
    /**
     * @Route("/", name="public_index")
     */
    public function index(ElectionRepository $electionRepository, ProcurationRepository $procurationRepository)
    {
        $procurations=[];
        foreach ($procurationRepository->findBy(["username"=>$this->getUser()->getUsername()]) as $procu)
        {
            if (!isset($procurations[$procu->getScrutin()->getId()]))
                $procurations[$procu->getScrutin()->getId()] = [];

            $procurations[$procu->getScrutin()->getId()][] = $procu;
        }

        return $this->render('public/index.html.twig', [
            'elections' => $electionRepository->findCurrent(),
            'procurations' => $procurations
        ]);
    }

    /**
     * @Route("/create/{scrutin}", name="public_create")
     */
    public function create(Scrutin $scrutin,  ProcurationRepository $procurationRepository, Request $request, LDAP $LDAP)
    {
        if ($procurationRepository->findOneBy(["username"=>$this->getUser()->getUsername(), "scrutin"=>$scrutin]))
            return new Response("Vous avez déjà une procuration pour ce scrutin",403);

        $user = current($LDAP->searchUser($this->getUser()->getUsername()));

        $procuration = new Procuration();
        $procuration->setScrutin($scrutin);
        $procuration->setUsername($this->getUser()->getUsername());
        $procuration->setNom($user->lastname);
        $procuration->setPrenom($user->firstname);
        $procuration->setMail($user->mail);

        $procuration->setDate(new \DateTime());
        $form = $this->createForm(ProcurationType::class, $procuration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($procuration);
            $entityManager->flush();

            return $this->redirectToRoute('public_index');
        }

        return $this->render('public/create.html.twig', [
            'scrutin' => $scrutin,
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    /**
     * @Route("/print/{procuration}", name="public_print")
     */
    public function print(Procuration $procuration, PDF $pdf)
    {
        if (!$this->isGranted("ROLE_ADMIN") && $procuration->getUsername() != $this->getUser()->getUsername())
            return new Response("Vous avez ne pouvez pas accéder à cette procuration",403);

        try {
            $content = $pdf->buildTemplate($procuration);
            $binaryData = $pdf->generatePdf($content);
        }
        catch (\Exception $exception)
        {
            return new Response("Erreur lors de la création du PDF",500);
        }

        $procuration->setPrinted(true);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($procuration);
        $entityManager->flush();


        return new Response($binaryData,200,[
            'Content-type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="procuration.pdf"'
        ]);
    }

    /**
     * @Route("/cancel/{procuration}", name="public_cancel")
     */
    public function cancel(Procuration $procuration)
    {
        if ($procuration->getPrinted() === true)
            return new Response("Vous avez déjà imprimé la procuration pour ce scrutin",403);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($procuration);
        $entityManager->flush();

        return $this->redirectToRoute('public_index');
    }
}
