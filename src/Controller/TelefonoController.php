<?php

namespace App\Controller;

use App\Entity\Telefono;
use App\Form\TelefonoType;
use App\Repository\TelefonoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/telefono")
 */
class TelefonoController extends AbstractController
{
    /**
     * @Route("/", name="telefono_index", methods="GET")
     */
    public function index(TelefonoRepository $telefonoRepository): Response
    {
        return $this->render('telefono/index.html.twig', ['telefonos' => $telefonoRepository->findAll()]);
    }

    /**
     * @Route("/new", name="telefono_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $telefono = new Telefono();
        $form = $this->createForm(TelefonoType::class, $telefono);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($telefono);
            $em->flush();

            return $this->redirectToRoute('telefono_index');
        }

        return $this->render('telefono/new.html.twig', [
            'telefono' => $telefono,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="telefono_show", methods="GET")
     */
    public function show(Telefono $telefono): Response
    {
        return $this->render('telefono/show.html.twig', ['telefono' => $telefono]);
    }

    /**
     * @Route("/{id}/edit", name="telefono_edit", methods="GET|POST")
     */
    public function edit(Request $request, Telefono $telefono): Response
    {
        $form = $this->createForm(TelefonoType::class, $telefono);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('telefono_edit', ['id' => $telefono->getId()]);
        }

        return $this->render('telefono/edit.html.twig', [
            'telefono' => $telefono,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="telefono_delete", methods="DELETE")
     */
    public function delete(Request $request, Telefono $telefono): Response
    {
        if ($this->isCsrfTokenValid('delete'.$telefono->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($telefono);
            $em->flush();
        }

        return $this->redirectToRoute('telefono_index');
    }
}
