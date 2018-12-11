<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class VecinoController extends AbstractController
{
    /**
     * @Route("/vecino", name="vecino_listado")
     */
    public function index()
    {
        return $this->render('vecino/index.html.twig', [
            'controller_name' => 'VecinoController',
        ]);
    }
}
