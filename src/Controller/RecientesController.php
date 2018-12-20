<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Evento;
use App\Entity\Salud;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\Response;


/**
* @Route("/recientes", name="recientes")
*/
class RecientesController extends AbstractController
{
    /**
     * @Route("/json", name="json_inicio")
     */
    public function jsonRecientes()
    {
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $callback = function ($dateTime) {
            return $dateTime instanceof \DateTime
                ? $dateTime->format('d-m-Y')
                : '';
        };

        $normalizer->setCallbacks(array('fechahora' => $callback,
            'createdAt' => $callback
        ));

        $normalizer->setCircularReferenceLimit(0);
        $serializer = new Serializer(array($normalizer), array($encoder));

        $em = $this->getDoctrine()->getManager();
        $repoeventos = $this->getDoctrine()->getRepository(Evento::class);
        $recientes []= $repoeventos->findBy([],['fechahora' => 'ASC'],10,0);
        $reposalud = $this->getDoctrine()->getRepository(Salud::class);
        $recientes []= $reposalud->findBy([],['fechahora' => 'DESC'],10,0);
        
        $jsonMensaje = $serializer->serialize($recientes, 'json');      
        $respuesta = new Response($jsonMensaje);   
        
        $respuesta->headers->set('Content-Type', 'application/json');
        $respuesta->headers->set('Access-Control-Allow-Origin', '*');    
        return $respuesta;
    }
}
