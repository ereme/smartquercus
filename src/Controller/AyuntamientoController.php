<?php

namespace App\Controller;

use App\Entity\Ayuntamiento;
use App\Entity\Imagen;
use App\Form\AyuntamientoType;
use App\Repository\AyuntamientoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/ayuntamiento")
 */
class AyuntamientoController extends AbstractController
{
    /**
     * @Route("/", name="ayuntamiento_index", methods="GET")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function index(AyuntamientoRepository $ayuntamientoRepository): Response
    {
        return $this->render('ayuntamiento/index.html.twig', ['ayuntamientos' => $ayuntamientoRepository->findAll()]);
    }

    /**
     * @Route("/new", name="ayuntamiento_new", methods="GET|POST")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function new(Request $request): Response
    {
        $ayuntamiento = new Ayuntamiento();
        $form = $this->createForm(AyuntamientoType::class, $ayuntamiento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        // Cargar imagen

            $em = $this->getDoctrine()->getManager();
            $em->persist($ayuntamiento);
            $em->flush();

            return $this->redirectToRoute('ayuntamiento_index');
        }

        return $this->render('ayuntamiento/new.html.twig', [
            'ayuntamiento' => $ayuntamiento,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ayuntamiento_show", methods="GET")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function show(Ayuntamiento $ayuntamiento): Response
    {
        return $this->render('ayuntamiento/show.html.twig', ['ayuntamiento' => $ayuntamiento]);
    }

    /**
     * @Route("/{id}/edit", name="ayuntamiento_edit", methods="GET|POST")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function edit(Request $request, Ayuntamiento $ayuntamiento): Response
    {
        $form = $this->createForm(AyuntamientoType::class, $ayuntamiento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fichero = $request->files->get('ayuntamiento')['imagen'];
            $fileName = md5(uniqid());

            $imagen = new Imagen();
            $imagen->setNombre($fileName);
            $imagen->setOriginal($fichero->getClientOriginalName());
            $ayuntamiento->setImagen($imagen);

            try {
                $fichero->move(
                    $this->getParameter('carpeta_imagenes'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ayuntamiento_edit', ['id' => $ayuntamiento->getId()]);
        }

        return $this->render('ayuntamiento/edit.html.twig', [
            'ayuntamiento' => $ayuntamiento,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ayuntamiento_delete", methods="DELETE")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function delete(Request $request, Ayuntamiento $ayuntamiento): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ayuntamiento->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ayuntamiento);
            $em->flush();
        }

        return $this->redirectToRoute('ayuntamiento_index');
    }
}
