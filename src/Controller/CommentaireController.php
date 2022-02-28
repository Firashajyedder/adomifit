<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
class CommentaireController extends AbstractController
{
    /**
     * @Route("/commentaire", name="commentaire")
     */
    public function index(Request $request): Response
    {
        
        
         //// ajouter cmnt

         $cmnt = new Commentaire();
         $form=$this->createForm(CommentaireType::class,$cmnt);
         $form->handleRequest($request);
         
         
         if($form->isSubmitted()&& $form->isValid()){
             $cmnt = $form->getData();
             $em = $this->getDoctrine()->getManager();
             $em->persist($cmnt);
             $em->flush();
             return $this->redirectToRoute('commentaire');
 
     }


     ///// lister cmnt

     
     $repository=$this->getDoctrine()->getRepository(Commentaire::class);
     $Commentaire=$repository-> findAll();

    

     
        

        
        return $this->render('commentaire/index.html.twig', [
            'controller_name' => 'CommentaireController', 'formA' => $form->createView(), 'cmnt' => $Commentaire,
        ]);


       
        
    }

       /**
     * @Route("/listCommentaire", name="listCommentaire")
     */
    public function list(): Response
    {
        $repository=$this->getDoctrine()->getRepository(Commentaire::class);
        $Commentaire=$repository-> findAll();
        return $this->render('commentaire/list.html.twig', [
            'cmnt' => $Commentaire,
        ]);
    }

     /**
     * @Route("/ajouter_commentaire", name="AjouterCommentaire")
     */
    public function Ajouter_Commentaire(Request $request): Response
    
    {
        $cmnt = new Commentaire();
        $form=$this->createForm(CommentaireType::class,$cmnt);
        $form->handleRequest($request);
        
        
        if($form->isSubmitted()&& $form->isValid()){
            $cmnt = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($cmnt);
            $em->flush();
            return $this->redirectToRoute('listCommentaire');

    }
        
        
        return $this->render('commentaire/add.html.twig', [
            'formA' => $form->createView()
        ]);
    }

      /**
     * @Route("/delete_commentaire/{id}", name="deleteCommentaire")
     */
    public function delete($id): Response
    { 
        $rep=$this->getDoctrine()->getRepository(Commentaire::class);
      $em=$this->getDoctrine()->getManager();
      $cmnt=$rep->find($id);
      $em->remove($cmnt);
      $em->flush();

        return $this->redirectToRoute('commentaire');
       
    }

    /**
     * @Route("/modifierCommentaire/{id}", name="modifierCommentaire")
     */
    public function modifier(Request $request, $id): Response
    {
        $rep=$this->getDoctrine()->getRepository(Commentaire::class);
        $Commentaire= $rep->find($id);
        $form=$this->createForm(CommentaireType::class,$Commentaire);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('commentaire');

        }

        return $this->render('commentaire/update.html.twig', [
            'formA' => $form->createView()
        ]);
    }

}
