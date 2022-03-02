<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Evenement;
use App\Form\EvenementType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class EvenementController extends AbstractController
{
    /**
     * @Route("/evenement/{id}", name="evenement")
     */
    public function index($id): Response
    {
        $rep=$this->getDoctrine()->getRepository(Evenement::class);

   $evenements =$rep-> findByIdCategorie($id);
        return $this->render('evenement/index.html.twig',  [
       
            'evenements' => $evenements,
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
     * @Route("/listEvenementD", name="listEvenement")
     */
    public function listD(): Response
    {
        $rep=$this->getDoctrine()->getRepository(Evenement::class);

        $evenements =$rep-> findAll();

        return $this->render('evenement/index1.html.twig', [
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

        if ($form->isSubmitted() && $form->isValid()){
            $evenement = $form->getData();
            $file = $form->get('image')->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            try{
                $file->move(
                $this->getParameter('images_directory'),
                $fileName
            );
            }catch(FileException $e){

            }
            $em = $this->getDoctrine()->getManager();
            $evenement->setImage($fileName);
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
        if ($form->isSubmitted() ){
            $file = $form->get('image')->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            try{
                $file->move(
                $this->getParameter('images_directory'),
                $fileName
            );
            }catch(FileException $e){

            }
          
             $em = $this->getDoctrine()->getManager();
             $evenement->setImage($fileName);
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

    

/**
* @Route("/listEvenementC/{id}", name="listEvenementC")
*/
public function listEvenementC(Request $request , $id): Response
{
   $rep=$this->getDoctrine()->getRepository(Evenement::class);

   $evenements =$rep-> findByIdCategorie($id);

   return $this->render('evenement/index.html.twig', [
       
       'evenements' => $evenements,
   ]);
}

/**
* @Route("/listEvenementD/{id}", name="listEvenementD")
*/
public function listEvenementD(Request $request , $id): Response
{
   $rep=$this->getDoctrine()->getRepository(Evenement::class);

   $evenements =$rep-> findByIddetail($id);

   return $this->render('evenement/index1.html.twig', [
       
       'evenements' => $evenements,
   ]);
}
    
}
