<?php

namespace App\Controller;

use App\Entity\Telefono;
use App\Form\TelefonoType;
use App\Repository\TelefonoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

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

        if ($this->isGranted('ROLE_ADMIN')) {
            $telefonos = $telefonoRepository->findAll();
            $localidad = 'de todas las localidades';
        } elseif ($this->isGranted('ROLE_AYTO')) { 
            $telefonos = $this->getUser()->getTelefonos();
            $localidad = $this->getUser()->getLocalidad();
        } elseif ($this->isGranted('ROLE_VECINO')) { 
            $telefonos = $this->getUser()->getAyuntamiento()->getTelefonos();
            $localidad = $this->getUser()->getAyuntamiento()->getLocalidad();
        }

        return $this->render('telefono/index.html.twig', ['telefonos' => $telefonos,
        'localidad' => $localidad]);
    }

    /**
     * @Route("/new", name="telefono_new", methods="GET|POST")
     * @Security("has_role('ROLE_AYTO')")
     */
    public function new(Request $request): Response
    {
        $ayto = $this->getUser();

        $telefono = new Telefono();
        $telefono->setAyto($ayto);
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

    /**
     * @Route("/telefono/json", name="json_telefono")
     */
    public function telefonoJson()
    {
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $normalizer->setCircularReferenceLimit(0);
        $serializer = new Serializer(array($normalizer), array($encoder));

        $em = $this->getDoctrine()->getManager();
        $repo = $this->getDoctrine()->getRepository(Telefono::class);
        $opina = $repo->findAll();

        $jsonMensaje = $serializer->serialize($opina, 'json');      
        $respuesta = new Response($jsonMensaje);       
        return $respuesta;
    }
}
