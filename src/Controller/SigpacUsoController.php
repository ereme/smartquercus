<?php

namespace App\Controller;

use App\Entity\SigpacUso;
use App\Form\SigpacUsoType;
use App\Repository\SigpacUsoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sigpacuso")
 */
class SigpacUsoController extends AbstractController
{
    /**
     * @Route("/", name="sigpac_uso_index", methods="GET")
     */
    public function index(SigpacUsoRepository $sigpacUsoRepository): Response
    {
        return $this->render('sigpac_uso/index.html.twig', ['sigpac_usos' => $sigpacUsoRepository->findAll()]);
    }

    /**
     * @Route("/new", name="sigpac_uso_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $sigpacUso = new SigpacUso();
        $form = $this->createForm(SigpacUsoType::class, $sigpacUso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($sigpacUso);
            $em->flush();

            return $this->redirectToRoute('sigpac_uso_index');
        }

        return $this->render('sigpac_uso/new.html.twig', [
            'sigpac_uso' => $sigpacUso,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sigpac_uso_show", methods="GET")
     */
    public function show(SigpacUso $sigpacUso): Response
    {
        return $this->render('sigpac_uso/show.html.twig', ['sigpac_uso' => $sigpacUso]);
    }

    /**
     * @Route("/{id}/edit", name="sigpac_uso_edit", methods="GET|POST")
     */
    public function edit(Request $request, SigpacUso $sigpacUso): Response
    {
        $form = $this->createForm(SigpacUsoType::class, $sigpacUso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sigpac_uso_edit', ['id' => $sigpacUso->getId()]);
        }

        return $this->render('sigpac_uso/edit.html.twig', [
            'sigpac_uso' => $sigpacUso,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sigpac_uso_delete", methods="DELETE")
     */
    public function delete(Request $request, SigpacUso $sigpacUso): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sigpacUso->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($sigpacUso);
            $em->flush();
        }

        return $this->redirectToRoute('sigpac_uso_index');
    }
}
