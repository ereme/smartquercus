<?php

namespace App\Controller;

use App\Entity\Localidad;
use App\Entity\Vecino;
use App\Entity\Ayuntamiento;
use App\Entity\Admin;
use App\Entity\Evento;
use App\Form\LocalidadType;
use App\Repository\AyuntamientoRepository;
use App\Repository\OpinaRepository;
use App\Repository\EventoRepository;
use App\Repository\VecinoRepository;
use App\Repository\AdminRepository;
use App\Repository\SaludRepository;
use App\Repository\IncidenciaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;



class InicioController extends AbstractController
{
    /**
     * @Route("/", name="inicio", methods="GET")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    
        public function index(AyuntamientoRepository $aytoRepo,VecinoRepository $vecinoRepo, OpinaRepository $opinaRepo,  SaludRepository $saludRepo ,IncidenciaRepository $incidenciaRepo, EventoRepository $eventoRepo): Response
        {
            if ($this->isGranted(Admin::ROLE_ADMIN)) {
                return $this->render('inicio/inicio_admin.html.twig', [
                    'ayuntamientos' => $aytoRepo->findAll(),
                    'vecinos' => $vecinoRepo->findAll(),
                    'opinas' => $opinaRepo->findAll(),
                    'eventos'=> $eventoRepo->findAll(),
                    'saluds' => $saludRepo->findAll(),
                    'incidencias' =>$incidenciaRepo->findAll()
                ]);
            } elseif ($this->isGranted(Vecino::ROLE_VECINO)) {
                return $this->render('inicio/inicio_vecino.html.twig', [
                    'opinas' => $this->getUser()->getAyuntamiento()->getEncuestas(),
                ]);            
            } elseif ($this->isGranted(Ayuntamiento::ROLE_AYTO)) {
                return $this->render('inicio/inicio_ayto.html.twig', [
                  'opinas'=> $this->getUser()->getEncuestas(),
                  'incidencias'=> $this->getUser()->getIncidencias(),
                  'eventos'=>$this->getUser()->getEventos(),
                  'vecinos'=> $this->getUser()->getVecinos(),
                ]);
            }
             else {
                return $this->redirectToRoute('login');
            }
        }

}
