<?php

namespace App\Controller;

use App\Form\CatRegimeType;
use App\Entity\CategorieRegime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieRegimeController extends AbstractController
{
    /**
     * @Route("/categorie/regime", name="categorie_regime")
     */
    public function index(): Response
    {
        return $this->render('categorie_regime/index.html.twig', [
            'controller_name' => 'CategorieRegimeController',
        ]);
    }

      /**
     * @Route("/listCatRegime", name="listCatRegime")
     */
    public function listCatRegime(): Response
    {
        $rep = $this->getDoctrine()->getRepository(CategorieRegime::class);
        $Catregimes = $rep->findAll();
 
        return $this->render('categorie_regime/listCatRegime.html.twig', [
          'Catregimes'=>$Catregimes,
     ]);
        
    }


     /**
     * @Route("/addCatRegime", name="addCatRegime")
     */
    public function addRegime(Request $request): Response
    {

        $regime = new CategorieRegime();
        $form = $this->createForm(CatRegimeType::class , $regime);
        $form = $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid()){
            $Catregime = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($Catregime);
            $em->flush();
            return $this->redirectToRoute('listCatRegime');
        }


        return $this->render('categorie_regime/addCatRegime.html.twig', [
            'formAddCatRegime'=>$form->createView(),
        ]);
    }

       /**
     * @Route("/updateCatRegime/{id}", name="updateCatRegime")
     */
    public function updateCatRegime(Request $request , $id): Response
    {
        $rep = $this->getDoctrine()->getRepository(CategorieRegime::class);
        $catRegime  = $rep->find($id);
        $form = $this->createForm(CatRegimeType::class , $catRegime);
        $form = $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()){
          
             $em = $this->getDoctrine()->getManager();
             $em->flush();
             return $this->redirectToRoute('listCatRegime');
         }
 
        return $this->render('categorie_regime/updateCatRegime.html.twig', [
            'formUpdateCatRegime'=> $form->createView(),
     ]);
        
    }


    /**
     * @Route("/deleteCatRegime/{id}", name="deleteCatRegime")
     */
    public function deleteRegime($id): Response
    {
        $rep = $this->getDoctrine()->getRepository(CategorieRegime::class);
        $em = $this->getDoctrine()->getManager();
        $catRegime = $rep->find($id);
        $em->remove($catRegime);
        $em->flush();
        return $this->redirectToRoute('listCatRegime');
    }










}
