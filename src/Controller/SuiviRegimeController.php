<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Entity\Regime;
use App\Entity\SuiviRegime;
use App\Form\SuiviRegimeType;
use App\Repository\CalendarRepository;
use App\Repository\SuiviRegimeRepository;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\VarDumper\Cloner\Data;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SuiviRegimeController extends AbstractController
{
    /**
     * @Route("/suiviRegime", name="suivi_regime")
     */
    public function index(): Response
    {
        return $this->render('suivi_regime/index.html.twig', [
            'controller_name' => 'SuiviRegimeController',
        ]);
    }
     

     /**
     * @Route("/listsuiviRegimes", name="listsuiviRegimes")
     */
    public function listsuiviRegimes(): Response
    {
        $rep = $this->getDoctrine()->getRepository(SuiviRegime::class);
        $suiviRegimes = $rep->findAll();
 
        return $this->render('suivi_regime/listsuiviRegimes.html.twig', [
          'suiviRegimes'=>$suiviRegimes,
     ]);
        
    }


     /**
     * @Route("/addsuiviRegime", name="addsuiviRegime")
     */
    public function addsuiviRegime(Request $request): Response
    {
       

        $suiviRegime = new SuiviRegime();
        
        $form = $this->createForm(SuiviRegimeType::class , $suiviRegime);
        $form = $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid()){
            $suiviRegime = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($suiviRegime);
            $em->flush();
            return $this->redirectToRoute('listsuiviRegimes');
        }


        return $this->render('suivi_regime/addsuiviRegime.html.twig', [
            'formAddsuivisRegime'=>$form->createView(),
        ]);
    }


    /**
     * @Route("/updatesuiviRegime/{id}", name="updatesuiviRegime")
     */
    public function updatesuiviRegime(Request $request , $id): Response
    {
        $rep = $this->getDoctrine()->getRepository(SuiviRegime::class);
        $suiviRegime  = $rep->find($id);
        $form = $this->createForm(SuiviRegimeType::class , $suiviRegime);
        $form = $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()){
          
             $em = $this->getDoctrine()->getManager();
             $em->flush();
             return $this->redirectToRoute('listsuiviRegimes');
         }
 
        return $this->render('suivi_regime/updatesuiviRegime.html.twig', [
            'formUpsuiviRegime'=> $form->createView(),
     ]);
        
    }

    /**
     * @Route("/deletesuiviRegime/{id}", name="deletesuiviRegime")
     */
    public function deletesuiviRegime($id): Response
    {
        $rep = $this->getDoctrine()->getRepository(SuiviRegime::class);
        $em = $this->getDoctrine()->getManager();
        $suiviRegime = $rep->find($id);
        $em->remove($suiviRegime);
        $em->flush();
        return $this->redirectToRoute('listsuiviRegimes');
    }





    /**
     * @Route("/addsuiviRegimeDirect/{id}", name="addsuiviRegimeDirect")
     */
    public function addsuiviRegimeDirect($id,Request $request,SuiviRegimeRepository $suiviRegimeRepository): Response
    {
        //va etre variable session
        $user_id=1;
        $rep = $this->getDoctrine()->getRepository(User::class);
        $user = $rep->find($user_id);
        $userRegime= $suiviRegimeRepository->findSuiviByIdUser($user_id);
        //verifier si user courant a déja un suivi régime ou non 
        
        if($userRegime == null){
             //recuperation de regime par id 
        $rep = $this->getDoctrine()->getRepository(Regime::class);
        $regime = $rep->find($id);

        

        //creation de suivi
        $suiviRegime = new SuiviRegime();
        $suiviRegime->setRegime($regime);
        $suiviRegime->setUser($user);
        $em = $this->getDoctrine()->getManager();
        $em->persist($suiviRegime);
        $em->flush();
            return $this->redirectToRoute('showsuiviRegime');
        }    
        
        return $this->render('suivi_regime/suiviRegimeExist.html.twig', [
            'user'=> $user,
     ]);
   
    }

     



      /**
     * @Route("/showsuiviRegime", name="showsuiviRegime")
     */
    public function showsuiviRegime(SuiviRegimeRepository $suiviRegimeRepository,CalendarRepository $calendarRep): Response
    {
      
        //va etre variable session
        $user_id=1;
      
        $suiviRegime = $suiviRegimeRepository->findSuiviByIdUser($user_id);
     
        $events = $calendarRep->findCalendarSuivi($suiviRegime);
        $rdvs = [];
        foreach($events as $event){
            $rdvs[]=[
                'id' => $event->getId(),
                'start' => $event->getStart()->format('Y-m-d H:i:s'),
                'end' => $event->getEnd()->format('Y-m-d H:i:s'),
                'title' => $event->getTitle(),
                'description' => $event->getDescription(),
                'backgroundColor' => $event->getBackgroundColor(),
                'borderColor' => $event->getBorderColor(),
                'textColor' => $event->getTextColor(),
                'allDay' => $event->getAllday(),
            ];
        }
        $data = json_encode($rdvs);
     
       
        //pour laffichage du modal
        $repas = $calendarRep->findCalendarSuivi($suiviRegime );
      

      
        return $this->render('suivi_regime/showsuiviRegimes.html.twig', [
          'suiviRegime'=>$suiviRegime,'data'=>$data ,'repas'=>$repas
     ]);


        
    }

    

 /**
     * @Route("/listsuiviParRegime/{id}", name="listsuiviParRegime")
     */
    public function listsuiviParRegime($id,SuiviRegimeRepository $suiviRegimeRepository): Response
    {
        $suiviRegimes = $suiviRegimeRepository->findListSuivisByIdRegime($id);
 
        return $this->render('suivi_regime/listsuiviParRegime.html.twig', [
          'suiviRegimes'=>$suiviRegimes,
     ]);
        
    }


















     //**********************************Les fonctions Api *******************************************************************************


 /**
     * @Route("/ajoutSuiviRegimeDirect", name="addsuiviRegimeDirect")
     */
    public function ajoutSuiviRegimeDirect(Request $request,SuiviRegimeRepository $suiviRegimeRepository,NormalizerInterface $normalizer,\Swift_Mailer $mailer ): Response
    {
    
        $titre = $request->query->get("titre");
        $remarque = $request->query->get("remarque");
        $note = $request->query->get("idUser");


        $idRegime = $request->query->get("idRegime");

        $idUser = $request->query->get("idUser");  
        $rep = $this->getDoctrine()->getRepository(User::class);
        $user = $rep->find($idUser);
        $userRegime= $suiviRegimeRepository->findSuiviByIdUser($idUser);
        //verifier si user courant a déja un suivi régime ou non 
        $suiviRegime = new SuiviRegime();
        if($userRegime == null){
             //recuperation de regime par id 
        $rep = $this->getDoctrine()->getRepository(Regime::class);
        $regime = $rep->find($idRegime);

        

        //creation de suivi
       
        $suiviRegime->setRegime($regime);
        $suiviRegime->setUser($user);
        $suiviRegime->setNote(0);
        $suiviRegime->setTitre("Nouveau Suivi");
        $suiviRegime->setRemarque("Pas encore de remarque");
        $em = $this->getDoctrine()->getManager();
        $em->persist($suiviRegime);
        $em->flush();
         //envoie email success d'ajout regime
         $userEmail = $user->getEmail();
         $message = (new \Swift_Message('New'))

         ->setFrom('houssem.kouki@esprit.tn')

         ->setTo($userEmail )

         ->setSubject('Félicitation vous avez achter un régime  !')
         ->setBody( $this->renderView(
             'regime/addRegimeEmail.html.twig'),
            
             'text/html'
         );
         $mailer->send($message); 
        $formatted = $normalizer->normalize($regime , 'json' , ['groups'=>['cat','regime','user','suivi']]);
        return new JsonResponse($formatted);
        }    
        return new JsonResponse("suivi Regime déja Exist");
      
   
    }


     /**
     * @Route("/AllSuivis", name="AllSuivis")
     */
    public function AllSuivis(NormalizerInterface $normalizer){
      
        $rep = $this->getDoctrine()->getRepository(SuiviRegime::class);
        $suivis = $rep->findAll();
        $json = $normalizer->normalize($suivis , 'json' , ['groups'=>['regime']]);

        return new Response(json_encode($json));
    }


      
     /******************Detail Suiivi*****************************************/

     /**
      * @Route("/detailSuivi", name="detailSuivi")
      * 
      */

      public function detailSuivi(Request $request,NormalizerInterface $normalizer)
      {
          $id = $request->get("id");
          $suivis = $this->getDoctrine()->getManager()->getRepository(SuiviRegime::class)->find($id);
          $json = $normalizer->normalize($suivis , 'json' , ['groups'=>['cat','regime','suivi']]);
          
         
          return new Response(json_encode($json));
 
 
 
      }


          /******************Detail Suiivi d'un user *****************************************/

     /**
      * @Route("/detailSuiviUser", name="detailSuiviUser")
      * 
      */

      public function detailSuiviUser(Request $request,NormalizerInterface $normalizer,SuiviRegimeRepository $suiviRegimeRepository)
      {
          $idUser = $request->get("idUser");
          $suivis= $suiviRegimeRepository->findOneBy(['user_id' => $idUser]);
         // $suivis= $suiviRegimeRepository->findSuiviByIdUser($idUser);
          $json = $normalizer->normalize($suivis , 'json' , ['groups'=>['cat','regime','suivi']]);
           
          return new Response(json_encode($json));
 
      }





      /**
     * @Route("/ListeSuivs", name="ListeSuivs")
     */
    public function ListeSuivs(Request $request,SuiviRegimeRepository $suiviRegimeRepository,NormalizerInterface $normalizer): Response
    {

        $regime_id = $request->get("idRegime");
        
        $suiviRegimes = $suiviRegimeRepository->findListSuivisByIdRegime($regime_id);
       
        $json = $normalizer->normalize($suiviRegimes , 'json' , ['groups'=>['regime']]);

        return new Response(json_encode($json));
        
    }







}
