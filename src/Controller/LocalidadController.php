<?php

namespace App\Controller;

use App\Entity\Localidad;
use App\Form\LocalidadType;
use App\Repository\LocalidadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/localidad")
 */
class LocalidadController extends AbstractController
{
    /**
     * @Route("/", name="localidad_index", methods="GET")
     */
    public function index(LocalidadRepository $localidadRepository): Response
    {
        return $this->render('localidad/index.html.twig', ['localidads' => $localidadRepository->findAll()]);
    }

    /**
     * @Route("/new", name="localidad_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $localidad = new Localidad();
        $form = $this->createForm(LocalidadType::class, $localidad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($localidad);
            $em->flush();

            return $this->redirectToRoute('localidad_index');
        }

        return $this->render('localidad/new.html.twig', [
            'localidad' => $localidad,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="localidad_show", methods="GET")
     */
    public function show(Localidad $localidad): Response
    {
        return $this->render('localidad/show.html.twig', ['localidad' => $localidad]);
    }

    /**
     * @Route("/{id}/edit", name="localidad_edit", methods="GET|POST")
     */
    public function edit(Request $request, Localidad $localidad): Response
    {
        $form = $this->createForm(LocalidadType::class, $localidad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('localidad_edit', ['id' => $localidad->getId()]);
        }

        return $this->render('localidad/edit.html.twig', [
            'localidad' => $localidad,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="localidad_delete", methods="DELETE")
     */
    public function delete(Request $request, Localidad $localidad): Response
    {
        if ($this->isCsrfTokenValid('delete'.$localidad->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($localidad);
            $em->flush();
        }

        return $this->redirectToRoute('localidad_index');
    }
}
