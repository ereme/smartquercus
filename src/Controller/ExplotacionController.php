<?php

namespace App\Controller;

use App\Entity\Explotacion;
use App\Entity\Participacion;
use App\Form\ExplotacionType;
use App\Repository\ExplotacionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/explotacion")
 */
class ExplotacionController extends AbstractController
{
    /**
     * @Route("/", name="explotacion_index", methods="GET")
     */
    public function index(ExplotacionRepository $explotacionRepository): Response
    {
        return $this->render('explotacion/index.html.twig', ['explotacions' => $explotacionRepository->findAll()]);
    }

    /**
     * @Route("/new", name="explotacion_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $explotacion = new Explotacion();

        $participacion = new Participacion();
        $participacion->setRol("TITULAR");
        $participacion->setExplotacion($explotacion);
        $participacion->setUser($this->getUser());

        //$explotacion->addUser($this->getUser());
        $form = $this->createForm(ExplotacionType::class, $explotacion);
        $form->handleRequest($request);

        dump ($explotacion);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($explotacion);
            $em->persist($participacion);
            $em->flush();

            return $this->redirectToRoute('explotacion_index');
        }

        return $this->render('explotacion/new.html.twig', [
            'explotacion' => $explotacion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="explotacion_show", methods="GET")
     */
    public function show(Explotacion $explotacion): Response
    {
        return $this->render('explotacion/show.html.twig', ['explotacion' => $explotacion]);
    }

    /**
     * @Route("/{id}/edit", name="explotacion_edit", methods="GET|POST")
     */
    public function edit(Request $request, Explotacion $explotacion): Response
    {
        $form = $this->createForm(ExplotacionType::class, $explotacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('explotacion_edit', ['id' => $explotacion->getId()]);
        }

        return $this->render('explotacion/edit.html.twig', [
            'explotacion' => $explotacion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="explotacion_delete", methods="DELETE")
     */
    public function delete(Request $request, Explotacion $explotacion): Response
    {
        if ($this->isCsrfTokenValid('delete'.$explotacion->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($explotacion);
            $em->flush();
        }

        return $this->redirectToRoute('explotacion_index');
    }
}
