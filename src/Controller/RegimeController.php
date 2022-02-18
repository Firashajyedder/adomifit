<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegimeController extends AbstractController
{
    /**
     * @Route("/regime", name="regime")
     */
    public function index(): Response
    {
        return $this->render('regime/index.html.twig', [
            'controller_name' => 'RegimeController',
        ]);
    }

     /**
     * @Route("/listRegime", name="listRegime")
     */
    public function list(): Response
    {
        return $this->render('regime/list.html.twig', [
            'controller_name' => 'RegimeController',
        ]);
    }
}
