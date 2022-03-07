<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\AchatBilletType;
use App\Entity\Billet;
use App\Entity\User;
use App\Entity\AchatBillet;




class AchatBilletController extends AbstractController
{
    /**
     * @Route("/achat/billet", name="achat_billet")
     */
    public function index(): Response
    {
        return $this->render('achat_billet/index.html.twig', [
            'controller_name' => 'AchatBilletController',
        ]);
    }
    /**
     * @Route("/AchatBillet/{id}", name="achatBillet" , methods={"GET","POST"})
     */
    public function addAchatBillet(Request $request , $id): Response
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find(2);
        $billet = $this->getDoctrine()->getRepository(Billet::class)->find($id);

        $achatBillet = new AchatBillet();
        $form = $this->createForm(AchatBilletType::class , $achatBillet);
        $form = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $achatBillet = $form->getData();
            $achatBillet->setUser($user);
            $achatBillet->setBillet($billet);
            $achatBillet->setDateAchat(new \DateTIme('now'));
             $billet->setQuantite(($billet->getQuantite()- $achatBillet->getQuantite()));
            $em = $this->getDoctrine()->getManager();
            $em->persist($achatBillet);
            $em->flush();
            return $this->redirectToRoute('listCategorieF');
           
        }


        return $this->render('Achat_billet/index.html.twig', [
            'formA'=>$form->createView(),
        ]);
    }
}
