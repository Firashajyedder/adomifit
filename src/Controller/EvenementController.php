<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EvenementController extends AbstractController
{
    /**
     * @Route("/evenement", name="evenement")
     */
    public function index(): Response
    {
        return $this->render('evenement/index.html.twig', [
            'controller_name' => 'EvenementController',
        ]);
    }


      /**
     * @Route("/listEvenement", name="listEvenement")
     */
    public function list(): Response
    {
        return $this->render('evenement/list.html.twig', [
            'controller_name' => 'EvenementController',
        ]);
    }
}
