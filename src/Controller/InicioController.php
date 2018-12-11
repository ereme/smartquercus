<?php

namespace App\Controller;

use App\Entity\Localidad;
use App\Entity\Vecino;
use App\Entity\Ayuntamiento;
use App\Entity\Admin;
use App\Form\LocalidadType;
use App\Repository\AyuntamientoRepository;
use App\Repository\VecinoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/inicio")
 */
class InicioController extends AbstractController
{
    /**
     * @Route("/", name="inicio", methods="GET")
     */
    public function index(AyuntamientoRepository $aytoRepo,VecinoRepository $vecinoRepo): Response
    {

        if ($this->isGranted(Vecino::ROLE_VECINO)) {
            return $this->render('inicio/inicio_vecino.html.twig', [
                'cartas' => $this->getUser()->getParticipaciones()
            ]);            
        } elseif ($this->isGranted(Ayuntamiento::ROLE_AYTO)) {




            return $this->render('inicio/inicio_ayto.html.twig', [
                'incidencias' => $this->getUser()->getParticipaciones()
            ]);
        } elseif ($this->isGranted(Admin::ROLE_ADMIN)) {


            return $this->render('inicio/inicio_admin.html.twig', [
                'ayuntamientos' => $aytoRepo->findAll(),
                'vecinos' => $vecinoRepo->findAll()

            ]);
        } else {

            //HACER UNA PARA USUARIOS NO REGISTRADOS (NO LOGUEADOS)
            return $this->render('inicio/inicio_admin.html.twig', [


                'participaciones' => $this->getUser()->getParticipaciones()
            ]);
        }

        return $this->render('inicio/inicio_vecino.html.twig', [
        ]);
    }
}
