<?php

namespace App\Controller;

use App\Entity\Tratamiento;
use App\Form\TratamientoType;
use App\Repository\TratamientoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tratamiento")
 */
class TratamientoController extends AbstractController
{
    /**
     * @Route("/", name="tratamiento_index", methods="GET")
     */
    public function index(TratamientoRepository $tratamientoRepository): Response
    {
        return $this->render('tratamiento/index.html.twig', [
            'tratamientos' => $tratamientoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tratamiento_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $tratamiento = new Tratamiento();
        $form = $this->createForm(TratamientoType::class, $tratamiento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tratamiento);
            $em->flush();

            return $this->redirectToRoute('tratamiento_index');
        }

        return $this->render('tratamiento/new.html.twig', [
            'tratamiento' => $tratamiento,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tratamiento_show", methods="GET")
     */
    public function show(Tratamiento $tratamiento): Response
    {
        return $this->render('tratamiento/show.html.twig', ['tratamiento' => $tratamiento]);
    }

    /**
     * @Route("/{id}/edit", name="tratamiento_edit", methods="GET|POST")
     */
    public function edit(Request $request, Tratamiento $tratamiento): Response
    {
        $form = $this->createForm(TratamientoType::class, $tratamiento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tratamiento_edit', ['id' => $tratamiento->getId()]);
        }

        return $this->render('tratamiento/edit.html.twig', [
            'tratamiento' => $tratamiento,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tratamiento_delete", methods="DELETE")
     */
    public function delete(Request $request, Tratamiento $tratamiento): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tratamiento->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tratamiento);
            $em->flush();
        }

        return $this->redirectToRoute('tratamiento_index');
    }
}
