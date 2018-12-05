<?php

namespace App\Controller;

use App\Entity\Evento;
use App\Entity\Imagen;
use App\Form\EventoType;
use App\Repository\EventoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * @Route("/evento")
 */
class EventoController extends AbstractController
{
    /**
     * @Route("/", name="evento_index", methods="GET")
     */
    public function index(EventoRepository $eventoRepository): Response
    {
        return $this->render('evento/index.html.twig', ['evento' => $eventoRepository->findAll()]);
    }

   
  /**
     * @Route("/new", name="evento_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $evento = new Evento();
        $form = $this->createForm(EventoType::class, $evento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $fichero = $request->files->get('evento')['fichero'];
            $fileName = md5(uniqid());

            $imagen = new Imagen();
            $imagen->setNombre($fileName);
            $imagen->setOriginal($fichero->getClientOriginalName());
            $evento->setImagen($imagen);
            /*dump ($imagen);
            dump ($fichero);
            dump ($salud);*/

            // Move the file to the directory where brochures are stored
            try {
                $fichero->move(
                    $this->getParameter('carpeta_imagenes'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }


            $em = $this->getDoctrine()->getManager();
            //$em->persist($imagen);  //si no está el cascadepersist en Salud entity
            $em->persist($evento);
            $em->flush();

            return $this->redirectToRoute('evento_index');
        }

        dump ($form);
        dump ($request->files);
        return $this->render('evento/new.html.twig', [
            'evento' => $evento,
            'form' => $form->createView(),
        ]);
    }




    /**
     * @Route("/{id}", name="evento_show", methods="GET")
     */
    public function show(Evento $evento): Response
    {
        return $this->render('evento/show.html.twig', ['evento' => $evento]);
    }

    /**
     * @Route("/{id}/edit", name="evento_edit", methods="GET|POST")
     */
    public function edit(Request $request, Evento $evento): Response
    {
        $form = $this->createForm(EventoType::class, $evento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump('entra');


           // Si viene imagen nueva ---> borrar la antigua de bd y disco y subir la nueva
           // Si viene imagen nueva: if (nombre antiguo es distinta a nombre nuevo || tamaño antiguo distinto a tamaño nuevo)
            dump($request->files);
            $nombre_antiguo = $evento->getFichero()->OriginalName;
            $nombre_nuevo = $fichero->getClientOriginalName();
            $tamano_antiguo = 0;
            $tamano_nuevo = 0;

            if (($nombre_nuevo != $nombre_antiguo) || ($tamano_nuevo != $tamano_antiguo)) {
 $tamano_antiguo = 0;
            } 

            //borrar la imagen
            $em->remove($evento->getImagen());
            $em->flush();
            $this->getDoctrine()->getManager()->flush();

        return $this->render('evento/edit.html.twig', [
            'evento' => $evento,
            'form' => $form->createView(),
        ]);
            return $this->redirectToRoute('evento_edit', ['id' => $evento->getId()]);
        }

        return $this->render('evento/edit.html.twig', [
            'evento' => $evento,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="evento_delete", methods="DELETE")
     */
    public function delete(Request $request, Evento $evento): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evento->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($evento);
            $em->flush();
        }

        return $this->redirectToRoute('evento_index');
    }
}
