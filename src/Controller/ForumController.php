<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForumController extends AbstractController
{
    /**
     * @Route("/forum", name="forum")
     */
    public function index(): Response
    {
        return $this->render('forum/index.html.twig', [
            'controller_name' => 'ForumController',
        ]);
    }
      /**
     * @Route("/listForum", name="listForum")
     */
    public function list(): Response
    {
        return $this->render('forum/list.html.twig', [
            'controller_name' => 'ForumController',
        ]);
    }
}
