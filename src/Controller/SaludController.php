<?php

namespace App\Controller;

use App\Entity\Salud;
use App\Form\SaludType;
use App\Repository\SaludRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/salud")
 */
class SaludController extends AbstractController
{
    /**
     * @Route("/", name="salud_index", methods="GET")
     */
    public function index(SaludRepository $saludRepository): Response
    {
        return $this->render('salud/index.html.twig', [
            'saluds' => $saludRepository->findAll()]);
    }

    /**
     * @Route("/new", name="salud_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $salud = new Salud();
        $form = $this->createForm(SaludType::class, $salud);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($salud);
            $em->flush();

            return $this->redirectToRoute('salud_index');
        }

        return $this->render('salud/new.html.twig', [
            'salud' => $salud,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="salud_show", methods="GET")
     */
    public function show(Salud $salud): Response
    {
        return $this->render('salud/show.html.twig', ['salud' => $salud]);
    }

    /**
     * @Route("/{id}/edit", name="salud_edit", methods="GET|POST")
     */
    public function edit(Request $request, Salud $salud): Response
    {
        $form = $this->createForm(SaludType::class, $salud);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('salud_edit', ['id' => $salud->getId()]);
        }

        return $this->render('salud/edit.html.twig', [
            'salud' => $salud,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="salud_delete", methods="DELETE")
     */
    public function delete(Request $request, Salud $salud): Response
    {
        if ($this->isCsrfTokenValid('delete'.$salud->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($salud);
            $em->flush();
        }

        return $this->redirectToRoute('salud_index');
    }
}
