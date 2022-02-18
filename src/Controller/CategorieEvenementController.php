<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\CategorieEvenement;
use App\Form\CatEvenementType;
use Symfony\Component\HttpFoundation\Request;

class CategorieEvenementController extends AbstractController
{
    /**
     * @Route("/categorie/evenement", name="categorie_evenement")
     */
    public function index(): Response
    {
        return $this->render('categorie_evenement/index.html.twig', [
            'controller_name' => 'CategorieEvenementController',
        ]);
    }

    /**
* @Route("/listCategorie", name="listCategorie")
*/
public function list(): Response
{
   $rep=$this->getDoctrine()->getRepository(CategorieEvenement::class);

   $categories =$rep-> findAll();

   return $this->render('categorie_evenement/listCE.html.twig', [
       'controller_name' => 'CategorieEvenementController',
       'categories' => $categories,
   ]);
}

/**
     * @Route("/addCatEvenement", name="addCatEvenement")
     */
    public function addCatEvenement(Request $request): Response
    {

        $categorie = new CategorieEvenement();
        $form = $this->createForm(CatEvenementType::class , $categorie);
        $form = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $categorie = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();
            return $this->redirectToRoute('listCategorie');
        }


        return $this->render('categorie_evenement/addCatEvenement.html.twig', [
            'formAddCatEvenement'=>$form->createView(),
        ]);
    }


    /**
     * @Route("/updateCatEvenement/{id}", name="updateCatEvenement")
     */
    public function updateCatEvenement(Request $request , $id): Response
    {
        $rep = $this->getDoctrine()->getRepository(CategorieEvenement::class);
        $categorie  = $rep->find($id);
        $form = $this->createForm(CatEvenementType::class , $categorie);
        $form = $form->handleRequest($request);
        if ($form->isSubmitted()){
          
             $em = $this->getDoctrine()->getManager();
             $em->flush();
             return $this->redirectToRoute('listCategorie');
         }
 
        return $this->render('categorie_evenement/updateCatEvenement.html.twig', [
            'formUpdateCatEvenement'=> $form->createView(),
     ]);
        
    }


    /**
     * @Route("/deleteCatEvenement/{id}", name="deleteCatEvenement")
     */
    public function deleteCatEvenement($id): Response
    {
        $rep = $this->getDoctrine()->getRepository(CategorieEvenement::class);
        $em = $this->getDoctrine()->getManager();
        $categorie = $rep->find($id);
        $em->remove($categorie);
        $em->flush();
        return $this->redirectToRoute('listCategorie');
    }

} 