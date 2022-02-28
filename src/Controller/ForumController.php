<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Forum;
use App\Form\ForumType;

class ForumController extends AbstractController
{
    /**
     * @Route("/forum", name="forum")
     */
    public function index(Request $request): Response
    {
        ///ajout de forum!!
        $forum = new Forum();
        $form=$this->createForm(ForumType::class,$forum);
        $form->handleRequest($request);
        
        
        if($form->isSubmitted()&& $form->isValid()){
            $forum = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($forum);
            $em->flush();
            return $this->redirectToRoute('forum');

    }
       //////////liste forum !!!
        $repository=$this->getDoctrine()->getRepository(Forum::class);
        $forum=$repository-> findAll();
        
        
        return $this->render('forum/index-admin.html.twig', [
            'formA' => $form->createView(),  'forums' => $forum,
        ]);
    }

      /**
     * @Route("/listForum", name="listForum")
     */
    public function list(): Response
    {
        $repository=$this->getDoctrine()->getRepository(Forum::class);
        $forum=$repository-> findAll();
        return $this->render('forum/list.html.twig', [
            'forums' => $forum,
        ]);
    }
    
    
     /**
     * @Route("/ajouter_forum", name="AjouterForum")
     */
    public function Ajouter_Forum(Request $request): Response
    
    {
        $forum = new Forum();
        $form=$this->createForm(ForumType::class,$forum);
        $form->handleRequest($request);
        
        
        if($form->isSubmitted()&& $form->isValid()){
            $forum = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($forum);
            $em->flush();
            return $this->redirectToRoute('listForum');

    }
        
        
        return $this->render('forum/index.html.twig', [
            'formA' => $form->createView()
        ]);
    }

      /**
     * @Route("/delete_forum/{id}", name="deleteForum")
     */
    public function delete($id): Response
    { 
        $rep=$this->getDoctrine()->getRepository(Forum::class);
      $em=$this->getDoctrine()->getManager();
      $forum=$rep->find($id);
      $em->remove($forum);
      $em->flush();

        return $this->redirectToRoute('forum');
       
    }

    /**
     * @Route("/modifierForum/{id}", name="modifierForum")
     */
    public function modifier(Request $request, $id): Response
    {
        $rep=$this->getDoctrine()->getRepository(Forum::class);
        $Forum = $rep->find($id);
        $form=$this->createForm(ForumType::class,$Forum);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('forum');

        }

        return $this->render('forum/update.html.twig', [
            'formA' => $form->createView()
        ]);
    }

    
}
