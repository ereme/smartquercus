<?php

namespace App\Controller;

use App\Entity\Opina;
use App\Form\OpinaType;
use App\Repository\OpinaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * @Route("/opina")
 */
class OpinaController extends AbstractController
{
    /**
     * @Route("/", name="opina_index", methods="GET")
     */
    public function index(OpinaRepository $opinaRepository): Response
    {
        return $this->render('opina/index.html.twig', [
            'opinas' => $opinaRepository->findAll()]);
    }

    /**
     * @Route("/new", name="opina_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $opina = new Opina();
        $form = $this->createForm(OpinaType::class, $opina);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($opina);
            $em->flush();

            return $this->redirectToRoute('opina_index');
        }

        return $this->render('opina/new.html.twig', [
            'opina' => $opina,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="opina_show", methods="GET")
     */
    public function show(Opina $opina): Response
    {
        return $this->render('opina/show.html.twig', ['opina' => $opina]);
    }

    /**
     * @Route("/{id}/edit", name="opina_edit", methods="GET|POST")
     */
    public function edit(Request $request, Opina $opina): Response
    {
        $form = $this->createForm(OpinaType::class, $opina);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('opina_edit', ['id' => $opina->getId()]);
        }

        return $this->render('opina/edit.html.twig', [
            'opina' => $opina,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="opina_delete", methods="DELETE")
     */
    public function delete(Request $request, Opina $opina): Response
    {
        if ($this->isCsrfTokenValid('delete'.$opina->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($opina);
            $em->flush();
        }

        return $this->redirectToRoute('opina_index');
    }

    /**
     * @Route("/{idopina}/{valor}/json", name="opina_json", requirements={"idopina"="\d+" })
     */
    public function jsonOpina($idopina, $valor, Request $request)
    {

        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();


        $callback = function ($dateTime) {
            return $dateTime instanceof \DateTime
                ? $dateTime->format('d-m-Y H:i')
                : '';
        };

        $normalizer->setCallbacks(array('fechahoralimite' => $callback));

        $normalizer->setCircularReferenceHandler(
            function ($object) {
                return $object->getId();
            }
        );
        $normalizer->setCircularReferenceLimit(0);
        $serializer = new Serializer(array($normalizer), array($encoder));


        $em = $this->getDoctrine()->getManager();
        $repo = $this->getDoctrine()->getRepository(Opina::class);
        $opina = $repo->find($idopina);

        dump ($opina);

        if ($valor == 'C') {
            $opina->subirVotosContra();
        } elseif ($valor == 'F') {
            $opina->subirVotosFavor();
        }
        $em->persist($opina);
        $em->flush();

        $jsonMensaje = $serializer->serialize($opina, 'json');      
        $respuesta = new Response($jsonMensaje);       
        return $respuesta;
    }

    /**
     * @Route("/opina/json", name="json_opina")
     */
    public function opinaJson()
    {
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $callback = function ($dateTime) {
            return $dateTime instanceof \DateTime
                ? $dateTime->format('d-m-Y H:i')
                : '';
        };

        $normalizer->setCallbacks(array('fechahoralimite' => $callback));

        $normalizer->setCircularReferenceLimit(0);
        $serializer = new Serializer(array($normalizer), array($encoder));

        $em = $this->getDoctrine()->getManager();
        $repo = $this->getDoctrine()->getRepository(Opina::class);
        
        $opina = $repo->findAll();
    
        $jsonMensaje = $serializer->serialize($opina, 'json');      
        $respuesta = new Response($jsonMensaje);       
        return $respuesta;
    }
    
}
