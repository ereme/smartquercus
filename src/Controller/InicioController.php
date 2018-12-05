<?php

namespace App\Controller;

use App\Entity\Localidad;
use App\Form\LocalidadType;
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
    public function index(): Response
    {
        return $this->render('inicio/index.html.twig', [
        ]);
    }
}
