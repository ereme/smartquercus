<?php

namespace App\Controller;

use App\Entity\Plaga;
use App\Form\PlagaType;
use App\Repository\PlagaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/plaga")
 */
class PlagaController extends AbstractController
{
    /**
     * @Route("/", name="plaga_index", methods="GET")
     */
    public function index(PlagaRepository $plagaRepository): Response
    {
        return $this->render('plaga/index.html.twig', ['plagas' => $plagaRepository->findAll()]);
    }

    /**
     * @Route("/new", name="plaga_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $plaga = new Plaga();
        $form = $this->createForm(PlagaType::class, $plaga);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($plaga);
            $em->flush();

            return $this->redirectToRoute('plaga_index');
        }

        return $this->render('plaga/new.html.twig', [
            'plaga' => $plaga,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="plaga_show", methods="GET")
     */
    public function show(Plaga $plaga): Response
    {
        return $this->render('plaga/show.html.twig', ['plaga' => $plaga]);
    }

    /**
     * @Route("/{id}/edit", name="plaga_edit", methods="GET|POST")
     */
    public function edit(Request $request, Plaga $plaga): Response
    {
        $form = $this->createForm(PlagaType::class, $plaga);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('plaga_edit', ['id' => $plaga->getId()]);
        }

        return $this->render('plaga/edit.html.twig', [
            'plaga' => $plaga,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="plaga_delete", methods="DELETE")
     */
    public function delete(Request $request, Plaga $plaga): Response
    {
        if ($this->isCsrfTokenValid('delete'.$plaga->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($plaga);
            $em->flush();
        }

        return $this->redirectToRoute('plaga_index');
    }
}
