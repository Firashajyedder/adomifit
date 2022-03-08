<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
       /**
     * @Route("/accueil", name="accueil")
     */
    public function index(): Response
    {
        return $this->render('default/accueil.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(): Response
    {
        return $this->render('default/contact.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }

    
}
