<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Evenement;
use App\Form\EvenementType;
use Symfony\Component\HttpFoundation\Request;

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
        $rep=$this->getDoctrine()->getRepository(Evenement::class);

        $evenements =$rep-> findAll();

        return $this->render('evenement/list.html.twig', [
            'controller_name' => 'EvenementController',
            'evenements' => $evenements,
        ]);
    }

    /**
     * @Route("/addEvenement", name="addEvenement")
     */
    public function addEvenement(Request $request): Response
    {

        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class , $evenement);
        $form = $form->handleRequest($request);

        if ($form->isSubmitted()){
            $evenement = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($evenement);
            $em->flush();
            return $this->redirectToRoute('listEvenement');
        }


        return $this->render('evenement/addEvenement.html.twig', [
            'formAddEvenement'=>$form->createView(),
        ]);
    }


    /**
     * @Route("/updateEvenement/{id}", name="updateEvenement")
     */
    public function updateEvenement(Request $request , $id): Response
    {
        $rep = $this->getDoctrine()->getRepository(Evenement::class);
        $evenement  = $rep->find($id);
        $form = $this->createForm(EvenementType::class , $evenement);
        $form = $form->handleRequest($request);
        if ($form->isSubmitted()){
          
             $em = $this->getDoctrine()->getManager();
             $em->flush();
             return $this->redirectToRoute('listEvenement');
         }
 
        return $this->render('evenement/updateEvenement.html.twig', [
            'formUpdateEvenement'=> $form->createView(),
     ]);
        
    }

    /**
     * @Route("/deleteEvenement/{id}", name="deleteEvenement")
     */
    public function deleteEvenement($id): Response
    {
        $rep = $this->getDoctrine()->getRepository(Evenement::class);
        $em = $this->getDoctrine()->getManager();
        $evenement = $rep->find($id);
        $em->remove($evenement);
        $em->flush();
        return $this->redirectToRoute('listEvenement');
    }

    


    
}
