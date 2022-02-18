<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\NutritionnisteRepository;
use App\Form\NutritionnisteType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class NutritionnisteController extends AbstractController
{
    /**
     * @Route("/nutritionniste", name="nutritionniste")
     */
    public function index(): Response
    {
        return $this->render('nutritionniste/index.html.twig', [
            'controller_name' => 'NutritionnisteController',
        ]);
    }
     /**
     * @Route("/listNutritionniste", name="listNutritionniste")
     */
    public function list(): Response
    {
        $rep=$this->getDoctrine()->getRepository(User::class);

        $nutritionnistes =$rep-> findAll();

        return $this->render('nutritionniste/list.html.twig', [
            'nutritionnistes' => $nutritionnistes,
        ]);
    }
     /**
     * @Route("/deleteNutritionniste/{id}", name="deleteNutritionniste")
     */
    public function delete($id)
    { $rep=$this->getDoctrine()->getRepository(User::class);
      $em=$this->getDoctrine()->getManager();
      $nutritionniste=$rep->find($id);
      $em->remove($nutritionniste);
      $em->flush();
        return $this->redirectToRoute('listNutritionniste');
       
    }
    
  
     /**
     * @Route("/ajouterNutritionniste", name="addNutritionniste")
     */
    public function ajouter(Request $request)
    {
        $nutritionniste = new User();
        $form=$this->createForm(NutritionnisteType::class,$nutritionniste);
        $form->handleRequest($request);
        
       
        if($form->isSubmitted()){
            $file = $form->get("attestation")->getData();
            $files = $form->get("temoignage")->getData();

            if ($file != null) {
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('attestation'), $fileName);
                $nutritionniste->setAtestation($fileName);
            }
            if ($files != null) {
                $fileName = md5(uniqid()) . '.' . $files->guessExtension();
                $files->move($this->getParameter('temoignage'), $fileName);
                $nutritionniste->setTemoignage($fileName);
            }
            $nutritionniste-> setRole("nutritionniste");
            $nutritionniste = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($nutritionniste);
            $em->flush();
            return $this->redirectToRoute('listNutritionniste');

        }
        return $this->render('nutritionniste/add.html.twig', [
            'formA' => $form->createView()
        ]);
}
   

    /**
     * @Route("/modifierNutritionniste{id}", name="modifierNutritionniste")
     */
    public function modifier(Request $request, $id)
    {
        $rep=$this->getDoctrine()->getRepository(User::class);
        $nutritionniste = $rep->find($id);
        $form=$this->createForm(NutritionnisteType::class,$nutritionniste);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('listNutritionniste');

        }

        return $this->render('nutritionniste/update.html.twig', [
            'formA' => $form->createView()
        ]);
    }
    
    /**
     * @Route("/showNutritionniste{id}", name="showNutritionniste", methods={"GET"})
     */
    public function show(User $nutritionniste): Response
    {
        return $this->render('nutritionniste/show.html.twig', [
            'nutritionniste' => $nutritionniste,
        ]);
    }
}
