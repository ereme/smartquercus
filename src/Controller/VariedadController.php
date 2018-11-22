<?php

namespace App\Controller;

use App\Entity\Variedad;
use App\Form\VariedadType;
use App\Repository\VariedadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/variedad")
 */
class VariedadController extends AbstractController
{
    /**
     * @Route("/", name="variedad_index", methods="GET")
     */
    public function index(VariedadRepository $variedadRepository): Response
    {
        return $this->render('variedad/index.html.twig', ['variedads' => $variedadRepository->findAll()]);
    }

    /**
     * @Route("/new", name="variedad_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $variedad = new Variedad();
        $form = $this->createForm(VariedadType::class, $variedad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($variedad);
            $em->flush();

            return $this->redirectToRoute('variedad_index');
        }

        return $this->render('variedad/new.html.twig', [
            'variedad' => $variedad,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="variedad_show", methods="GET")
     */
    public function show(Variedad $variedad): Response
    {
        return $this->render('variedad/show.html.twig', ['variedad' => $variedad]);
    }

    /**
     * @Route("/{id}/edit", name="variedad_edit", methods="GET|POST")
     */
    public function edit(Request $request, Variedad $variedad): Response
    {
        $form = $this->createForm(VariedadType::class, $variedad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('variedad_edit', ['id' => $variedad->getId()]);
        }

        return $this->render('variedad/edit.html.twig', [
            'variedad' => $variedad,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="variedad_delete", methods="DELETE")
     */
    public function delete(Request $request, Variedad $variedad): Response
    {
        if ($this->isCsrfTokenValid('delete'.$variedad->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($variedad);
            $em->flush();
        }

        return $this->redirectToRoute('variedad_index');
    }
}
