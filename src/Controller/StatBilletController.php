<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Billet;
use App\Entity\User;
use App\Entity\AchatBillet;

class StatBilletController extends AbstractController
{
    /**
     * @Route("/stat/billet", name="stat_billet")
     */
    public function index(): Response
    {
        return $this->render('stat_billet/index.html.twig', [
            'controller_name' => 'StatBilletController',
        ]);
    }
    
   /**
     * @Route("/statistiqueBillet", name="statsBillet")
     */
    public function statistiques(){
        // statistique 
        $billets =$this->getDoctrine()->getRepository(Billet::class)->findAll();
        $achatBillets =$this->getDoctrine()->getRepository(AchatBillet::class)->findAll();
        
        return $this->render('stat_billet/statistiqueBillet.html.twig',[
          'billets' => $billets,
          'achatBillets' => $achatBillets
        ]);
    }
  
}

