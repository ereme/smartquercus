<?php

namespace App\Controller;

use App\Entity\Vecino;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\VecinoRepository;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\Response;


/**
 * @Route("/vecino")
 */
class VecinoController extends AbstractController
{
    /**
     * @Route("/", name="vecino_listado")
     */
    public function index(VecinoRepository $vecinoRepository)
    { 
        $id_ayto = $this->getUser()->getId();
        $localidad = $this->getUser()->getLocalidad();
        $vecinos = $vecinoRepository->findByAyto($id_ayto);

        return $this->render('vecino/index.html.twig', [
            'vecinos' => $vecinos,
            'localidad' => $localidad
        ]);
    }

    /**
     * @Route("/json/{ayto_id}", name="json_vecino")
     */
    public function vecinoJson($ayto_id, VecinoRepository $vecinoRepository)
    {
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $callback = function ($dateTime) {
            return $dateTime instanceof \DateTime
                ? $dateTime->format('d-m-Y H:i')
                : '';
        };

        $normalizer->setCallbacks(array(
            'createdAt' => $callback,
            'fechahoralimite' => $callback,
            'fecha' => $callback
        ));

        $normalizer->SetCircularReferenceHandler(function ($object){
            return $object->getId();
        });

        $normalizer->setCircularReferenceLimit(0);

        $serializer = new Serializer(array($normalizer), array($encoder));

        $vecinos = $vecinoRepository->findByAyuntamiento($ayto_id); 

        $jsonMensaje = $serializer->serialize($vecinos, 'json');   
        $respuesta = new Response($jsonMensaje);    
        return $respuesta;
    }
}
