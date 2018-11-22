<?php

namespace App\Controller;

use App\Entity\Agrupacion;
use App\Form\AgrupacionType;
use App\Repository\AgrupacionRepository;
use App\Repository\ExplotacionRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/agrupacion")
 */
class AgrupacionController extends AbstractController
{
    /**
     * @Route("/", name="agrupacion_index", methods="GET")
     */
    public function index(AgrupacionRepository $agrupacionRepository): Response
    {
        return $this->render('agrupacion/index.html.twig', ['agrupacions' => $agrupacionRepository->findAll()]);
    }

    /**
     * @Route("/new", name="agrupacion_new", methods="GET|POST")
     */
    public function new(Request $request, ExplotacionRepository $explotacionRepository): Response
    {
        $explotacion_id = $request->query->get('id_exp');
        $explotacion = $explotacionRepository->find($explotacion_id);

        //Si la explotación no existe o si esa explotación no pertenece al usuario actual ---> exception
        if (!$explotacion) {
            dump ($this->getUser());
            dump ($explotacion);
            dump ($explotacion->isOwner($this->getUser()));
            if (!$explotacion->isOwner($this->getUser())) {
                throw $this->createNotFoundException('Explotación inválida');
            }
        }

        $agrupacion = new Agrupacion();
        $agrupacion->setExplotacion($explotacion);
        $form = $this->createForm(AgrupacionType::class, $agrupacion);
        $form->handleRequest($request);

        dump ($agrupacion);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($agrupacion);
            $em->flush();

            return $this->redirectToRoute('agrupacion_index');
        }

        return $this->render('agrupacion/new.html.twig', [
            'agrupacion' => $agrupacion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="agrupacion_show", methods="GET")
     */
    public function show(Agrupacion $agrupacion): Response
    {
        return $this->render('agrupacion/show.html.twig', ['agrupacion' => $agrupacion]);
    }

    /**
     * @Route("/{id}/edit", name="agrupacion_edit", methods="GET|POST")
     */
    public function edit(Request $request, Agrupacion $agrupacion): Response
    {
        $form = $this->createForm(AgrupacionType::class, $agrupacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('agrupacion_edit', ['id' => $agrupacion->getId()]);
        }

        return $this->render('agrupacion/edit.html.twig', [
            'agrupacion' => $agrupacion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="agrupacion_delete", methods="DELETE")
     */
    public function delete(Request $request, Agrupacion $agrupacion): Response
    {
        if ($this->isCsrfTokenValid('delete'.$agrupacion->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($agrupacion);
            $em->flush();
        }

        return $this->redirectToRoute('agrupacion_index');
    }
}
