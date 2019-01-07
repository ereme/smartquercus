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
        $eventos= $eventoRepo->findRecientes(1);
        $saludables= $saludRepo->findRecientes();
        $recientes = array_merge($eventos, $saludables);
        foreach ($recientes as $key => $reciente) {
            $recientes[$key]['fechahora'] = $reciente['fechahora']->format('d-m-Y');
            $recientes[$key]['imagen'] = 'https://'
                .$request->server->get('HTTP_HOST')
                .'/images/'
                .$reciente['imagen'];
        }
        
        $respuesta = new Response(json_encode($recientes));

        $respuesta->headers->set('Content-Type', 'application/json');
        $respuesta->headers->set('Access-Control-Allow-Origin', '*');    
        return $respuesta;
    }
}
