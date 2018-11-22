<?php

namespace App\Controller;

use App\Entity\Cultivo;
use App\Form\CultivoType;
use App\Repository\CultivoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cultivo")
 */
class CultivoController extends AbstractController
{
    /**
     * @Route("/", name="cultivo_index", methods="GET")
     */
    public function index(CultivoRepository $cultivoRepository): Response
    {
        return $this->render('cultivo/index.html.twig', ['cultivos' => $cultivoRepository->findAll()]);
    }

    /**
     * @Route("/new", name="cultivo_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $cultivo = new Cultivo();
        $form = $this->createForm(CultivoType::class, $cultivo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cultivo);
            $em->flush();

            return $this->redirectToRoute('cultivo_index');
        }

        return $this->render('cultivo/new.html.twig', [
            'cultivo' => $cultivo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cultivo_show", methods="GET")
     */
    public function show(Cultivo $cultivo): Response
    {
        return $this->render('cultivo/show.html.twig', ['cultivo' => $cultivo]);
    }

    /**
     * @Route("/{id}/edit", name="cultivo_edit", methods="GET|POST")
     */
    public function edit(Request $request, Cultivo $cultivo): Response
    {
        $form = $this->createForm(CultivoType::class, $cultivo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cultivo_edit', ['id' => $cultivo->getId()]);
        }

        return $this->render('cultivo/edit.html.twig', [
            'cultivo' => $cultivo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cultivo_delete", methods="DELETE")
     */
    public function delete(Request $request, Cultivo $cultivo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cultivo->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cultivo);
            $em->flush();
        }

        return $this->redirectToRoute('cultivo_index');
    }
}
