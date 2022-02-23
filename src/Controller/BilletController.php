<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Billet;
use App\Form\BilletType;
use Symfony\Component\HttpFoundation\Request;


class BilletController extends AbstractController
{
    /**
     * @Route("/billet", name="billet")
     */
    public function index(): Response
    {
        return $this->render('billet/index.html.twig', [
            'controller_name' => 'BilletController',
        ]);
    }

    /**
* @Route("/listBillet", name="listBillet")
*/
public function list(): Response
{
   $rep=$this->getDoctrine()->getRepository(Billet::class);

   $billets =$rep-> findAll();

   return $this->render('billet/listbillet.html.twig', [
       'controller_name' => 'BilletController',
       'billets' => $billets,
   ]);

   
}

/**
     * @Route("/addBillet", name="addBillet")
     */
    public function addBillet(Request $request): Response
    {

        $billet = new Billet();
        $form = $this->createForm(BilletType::class , $billet);
        $form = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $billet = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($billet);
            $em->flush();
            return $this->redirectToRoute('listBillet');
        }


        return $this->render('billet/addBillet.html.twig', [
            'formAddBillet'=>$form->createView(),
        ]);
    }



    /**
     * @Route("/updateBillet/{id}", name="updateBillet")
     */
    public function updateBillet(Request $request , $id): Response
    {
        $rep = $this->getDoctrine()->getRepository(Billet::class);
        $billet  = $rep->find($id);
        $form = $this->createForm(BilletType::class , $billet);
        $form = $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
          
             $em = $this->getDoctrine()->getManager();
             $em->flush();
             return $this->redirectToRoute('listBillet');
         }
 
        return $this->render('billet/updateBillet.html.twig', [
            'formUpdateBillet'=> $form->createView(),
     ]);
        
    }


    /**
     * @Route("/deleteBillet/{id}", name="deleteBillet")
     */
    public function deleteBillet($id): Response
    {
        $rep = $this->getDoctrine()->getRepository(Billet::class);
        $em = $this->getDoctrine()->getManager();
        $billet = $rep->find($id);
        $em->remove($billet);
        $em->flush();
        return $this->redirectToRoute('listBillet');
    }



/**
* @Route("/listBilletC/{id}", name="listBilletC")
*/
public function listBilletC(Request $request , $id): Response
{
   $rep=$this->getDoctrine()->getRepository(Billet::class);

   $billets =$rep-> findByIdEvenement($id);

   return $this->render('billet/index.html.twig', [
       
       'billets' => $billets,
   ]);
}


    


}
