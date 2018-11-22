<?php

namespace App\Controller;

use App\Entity\Parcela;
use App\Form\ParcelaType;
use App\Repository\ParcelaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/parcela")
 * @Security("has_role('ROLE_USER')") 
 */
class ParcelaController extends AbstractController
{
    /**
     * @Route("/", name="parcela_index", methods="GET")
     */
    public function index(): Response
    {
        return $this->render('parcela/index.html.twig', [
            'participaciones' => $this->getUser()->getParticipaciones(),
        ]);
    }

    /**
     * @Route("/new", name="parcela_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $parcela = new Parcela();
        $form = $this->createForm(ParcelaType::class, $parcela);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($parcela);
            $em->flush();

            return $this->redirectToRoute('parcela_index');
        }

        return $this->render('parcela/new.html.twig', [
            'parcela' => $parcela,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="parcela_show", methods="GET")
     */
    public function show(Parcela $parcela): Response
    {
        return $this->render('parcela/show.html.twig', ['parcela' => $parcela]);
    }

    /**
     * @Route("/{id}/edit", name="parcela_edit", methods="GET|POST")
     */
    public function edit(Request $request, Parcela $parcela): Response
    {
        $form = $this->createForm(ParcelaType::class, $parcela);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('parcela_edit', ['id' => $parcela->getId()]);
        }

        return $this->render('parcela/edit.html.twig', [
            'parcela' => $parcela,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="parcela_delete", methods="DELETE")
     */
    public function delete(Request $request, Parcela $parcela): Response
    {
        if ($this->isCsrfTokenValid('delete'.$parcela->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($parcela);
            $em->flush();
        }

        return $this->redirectToRoute('parcela_index');
    }
}
