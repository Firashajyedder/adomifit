<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProgrammeController extends AbstractController
{
    /**
     * @Route("/programme", name="programme")
     */
    public function index(): Response
    {
        return $this->render('programme/index.html.twig', [
            'controller_name' => 'ProgrammeController',
        ]);
    }
     /**
     * @Route("listProgramme", name="listProgramme")
     */
    public function list(): Response
    {
        return $this->render('programme/list.html.twig', [
            'controller_name' => 'ProgrammeController',
        ]);
    }
}
