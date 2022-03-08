<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\SuiviProgramme;
use Symfony\Component\HttpFoundation\Request;
use App\Form\SuiviProgType;

class SuiviProgrammeController extends AbstractController
{
    /**
     * @Route("/suivi/programme", name="suivi_programme")
     */
    public function index(): Response
    {
        return $this->render('suivi_programme/index.html.twig', [
            'controller_name' => 'SuiviProgrammeController',
        ]);
    }

      /**
     * @Route("/listSuivisProgrammes", name="listSuivisProgrammes")
     */
    public function listSuivisProgrammes(): Response
    {
        $rep = $this->getDoctrine()->getRepository(SuiviProgramme::class);
        $suivisProgrammes = $rep->findAll();
 
        return $this->render('suivi_programme/listSuivisProgrammes.html.twig', [
          'suivisProgrammes'=>$suivisProgrammes,
     ]);
        
    }

    /**
     * @Route("/addSuiviProgramme/{id}", name="addSuiviProgramme")
     */
    public function addRegime(Request $request): Response
    {
        $user_id=1;
        $suiviProgramme = new SuiviProgramme();
        $form = $this->createForm(SuiviProgType::class , $suiviProgramme);
        $form = $form->handleRequest($request);

        if ($form->isSubmitted()){
            $suiviProgramme = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($suiviProgramme);
            $em->flush();
            return $this->render('suivi_programme/success.html.twig');
        }


        return $this->render('suivi_programme/addSuiviProgramme.html.twig', [
            'formAddSuiviProgramme'=>$form->createView(),
        ]);
    }

     /**
     * @Route("/updateSuiviProgramme/{id}", name="updateSuiviProgramme")
     */
    public function updateSuiviProgramme(Request $request , $id): Response
    {
        $rep = $this->getDoctrine()->getRepository(SuiviProgramme::class);
        $suiviProgramme  = $rep->find($id);
        $form = $this->createForm(SuiviProgType::class , $suiviProgramme);
        $form = $form->handleRequest($request);
        if ($form->isSubmitted()){
          
             $em = $this->getDoctrine()->getManager();
             $em->flush();
             return $this->redirectToRoute('listSuivisProgrammes');
         }
 
        return $this->render('suivi_programme/updateSuiviProg.html.twig', [
            'formUpdateSuiviProg'=> $form->createView(),
     ]);
        
    }

    /**
     * @Route("/deleteSuiviProg/{id}", name="deleteSuiviProg")
     */
    public function deleteSuiviProg($id): Response
    {
        $rep = $this->getDoctrine()->getRepository(SuiviProgramme::class);
        $em = $this->getDoctrine()->getManager();
        $suiviProgramme = $rep->find($id);
        $em->remove($suiviProgramme);
        $em->flush();
        return $this->redirectToRoute('listSuivisProgrammes');
    }





}
