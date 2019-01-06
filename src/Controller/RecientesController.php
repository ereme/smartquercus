<?php

namespace App\Controller;

use App\Repository\EventoRepository;
use App\Repository\SaludRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Evento;
use App\Entity\Salud;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;



/**
* @Route("/recientes", name="recientes")
*/
class RecientesController extends AbstractController
{
    /**
     * @Route("/json/{ayto}", name="json_inicio")
     */
    public function jsonRecientes($ayto, Request $request, EventoRepository $eventoRepo, SaludRepository $saludRepo)
    {
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $callback = function ($dateTime) {
            return $dateTime instanceof \DateTime
                ? $dateTime->format('d-m-Y')
                : '';
        };

        $callbackUrl = function ($nombre) use ($request) {
            return 'https://'
                . $request->server->get('HTTP_HOST')
                . '/images/'
                . $nombre;
        };

        $normalizer->setCallbacks(array(
            'fechahora' => $callback,
            'nombre' => $callbackUrl
        ));

        $normalizer->SetCircularReferenceHandler(function ($object){
            return $object->getId();
        });

        $normalizer->setCircularReferenceLimit(0);
        $serializer = new Serializer(array($normalizer), array($encoder));

        $eventos= $eventoRepo->findRecientes(1);
        $saludables= $saludRepo->findRecientes();
        $recientes = array_merge($eventos, $saludables);
        foreach ($recientes as $key => $reciente) {
            $recientes[$key]['fechahora'] = $reciente['fechahora']->format('d-m-Y');
            $recientes[$key]['nombre'] = 'https://'
                .$request->server->get('HTTP_HOST')
                .'/images/'
                .$reciente['nombre'];
        }

        //$jsonMensaje = $serializer->serialize($recientes, 'json');

        
        $respuesta = new Response(json_encode($recientes));

        $respuesta->headers->set('Content-Type', 'application/json');
        $respuesta->headers->set('Access-Control-Allow-Origin', '*');    
        return $respuesta;
    }
}
