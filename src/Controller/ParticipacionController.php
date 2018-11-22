<?php

namespace App\Controller;

use App\Entity\Participacion;
use App\Form\ParticipacionType;
use App\Repository\ParticipacionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/participacion")
 */
class ParticipacionController extends AbstractController
{
    /**
     * @Route("/", name="participacion_index", methods="GET")
     */
    public function index(ParticipacionRepository $participacionRepository): Response
    {
        return $this->render('participacion/index.html.twig', ['participacions' => $participacionRepository->findAll()]);
    }

    /**
     * @Route("/new", name="participacion_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $participacion = new Participacion();
        $form = $this->createForm(ParticipacionType::class, $participacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($participacion);
            $em->flush();

            return $this->redirectToRoute('participacion_index');
        }

        return $this->render('participacion/new.html.twig', [
            'participacion' => $participacion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="participacion_show", methods="GET")
     */
    public function show(Participacion $participacion): Response
    {
        return $this->render('participacion/show.html.twig', ['participacion' => $participacion]);
    }

    /**
     * @Route("/{id}/edit", name="participacion_edit", methods="GET|POST")
     */
    public function edit(Request $request, Participacion $participacion): Response
    {
        $form = $this->createForm(ParticipacionType::class, $participacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('participacion_edit', ['id' => $participacion->getId()]);
        }

        return $this->render('participacion/edit.html.twig', [
            'participacion' => $participacion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="participacion_delete", methods="DELETE")
     */
    public function delete(Request $request, Participacion $participacion): Response
    {
        if ($this->isCsrfTokenValid('delete'.$participacion->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($participacion);
            $em->flush();
        }

        return $this->redirectToRoute('participacion_index');
    }
}
