<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Regime;
use App\Data\FiltreData;
use App\Form\FiltreForm;
use App\Form\AddRegimeType;
use Doctrine\ORM\Mapping\Id;
use App\Entity\CategorieRegime;
use App\Repository\RegimeRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;



class RegimeController extends AbstractController
{
    /**
     * @Route("/regime", name="regime")
     */
    public function index(Request $request,PaginatorInterface $paginator ): Response
    {
        $rep = $this->getDoctrine()->getRepository(Regime::class);
        $allregimes = $rep->findAll();
        $rep = $this->getDoctrine()->getRepository(CategorieRegime::class);
        $Catregimes = $rep->findAll();
        
        $regimes = $paginator->paginate(
            // Doctrine Query, not results
            $allregimes,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            3
        );
       
        
        return $this->render('regime/index.html.twig', [
            'regimes'=>$regimes,
            'Catregimes'=>$Catregimes
        ]);
      
    }


   




    

     /**
     * @Route("/regimes", name="regimes")
     */
    public function regimes(Request $request,PaginatorInterface $paginator , RegimeRepository $regimeRepository ): Response
    {


        $data = new FiltreData();
        $data->page = $request->get('page', 1);
        $form = $this->createForm(FiltreForm::class, $data);
        $form->handleRequest($request);
        [$min,$max]= $regimeRepository->MinMax($data);
        
        $allregimes = $regimeRepository->findSearch($data);
       
      
        
        $regimes = $paginator->paginate(
            // Doctrine Query, not results
            $allregimes,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            3
        );
       
        
        return $this->render('regime/allRegime.html.twig', [
            'regimes'=>$regimes,
            'form' => $form->createView(),
            'min'=> $min,
            'max'=> $max
        ]);
      
    }

   









     /**
     * @Route("/listRegimes", name="listRegimes" )
     */
    public function list(RegimeRepository $regimeRepository , SerializerInterface $serializerInterface,PaginatorInterface $paginator ,Request $request): Response
    {
        //va etre variable session
        $user_id=2;
        $allregimes = $regimeRepository->findListRegimeByIdUser($user_id);
        $json = $serializerInterface->serialize($allregimes , 'json' , ['groups'=>'regime']);
        $regimes = $paginator->paginate(
            // Doctrine Query, not results
            $allregimes,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            3
        );
        return $this->render('regime/listRegimes.html.twig', [
          'regimes'=>$regimes,
     ]);
     //return new JsonResponse($json);

        
    }

    /**
     * @Route("/detailRegime/{id}", name="detailRegime")
     */
    public function detailRegime($id): Response
    {
        $rep = $this->getDoctrine()->getRepository(Regime::class);
        $regime = $rep->find($id);
 
        return $this->render('regime/detailRegime.html.twig', [
          'regime'=>$regime,
     ]);
        
    }
   
    


     /**
     * @Route("/addRegime", name="addRegime")
     */
    public function addRegime(Request $request, \Swift_Mailer $mailer): Response
    {
 //va etre variable session
    $user_id=2;
    $rep = $this->getDoctrine()->getRepository(User::class);
    $user = $rep->find($user_id);
        $regime = new Regime();
        $form = $this->createForm(AddRegimeType::class , $regime);
        $form = $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid()){
            $regime = $form->getData();
            
            $file = $regime->getImage();
         
            
            $fileName = md5(uniqid()).'.'.$file->guessExtension() ;
            try{
                $file->move(
                $this->getParameter('images_directory'),
                $fileName
            );
            }catch(FileException $e){

            }
            
            $em = $this->getDoctrine()->getManager();
            $regime->setImage($fileName);
            $em->persist($regime);
            $em->flush();
            //envoie email success d'ajout regime
            $userEmail = $user->getEmail();
            $message = (new \Swift_Message('New'))

            ->setFrom('houssem.kouki@esprit.tn')

            ->setTo($userEmail )

            ->setSubject('Votre régime a été enregistrée !')
            ->setBody( $this->renderView(
                'regime/addRegimeEmail.html.twig'),
               
                'text/html'
            );
            $mailer->send($message); 
            return $this->redirectToRoute('listRegimes');
        }


        return $this->render('regime/addRegime.html.twig', [
            'formAddRegime'=>$form->createView(),
        ]);
    }





    //template regime email
     /**
     * @Route("/TemplateRegime", name="TemplateRegime")
     */
    public function TemplateRegime(Request $request,PaginatorInterface $paginator): Response
    {
        
        return $this->render('regime/addRegimeEmail.html.twig', [
        ]);
    }


























     /**
     * @Route("/updateRegime/{id}", name="updateRegime")
     */
    public function updateRegime(Request $request , $id): Response
    {
       
        $rep = $this->getDoctrine()->getRepository(Regime::class);
        $regime  = $rep->find($id);
        $form = $this->createForm(AddRegimeType::class , $regime);
        $form = $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()){
            $regime = $form->getData();
            $file = $regime->getImage();
            $fileName = md5(uniqid()).'.'.$file->guessExtension() ;
            try{
                $file->move(
                $this->getParameter('images_directory'),
                $fileName
            );
            }catch(FileException $e){

            }
             $em = $this->getDoctrine()->getManager();
             $regime->setImage($fileName);
             $em->flush();
             return $this->redirectToRoute('listRegimes');
         }
 
        return $this->render('regime/updateRegime.html.twig', [
            'formUpdateRegime'=> $form->createView(),
            'regime'=>$regime
     ]);
        
    }
  /**
     * @Route("/deleteRegime/{id}", name="deleteRegime")
     */
    public function deleteRegime($id): Response
    {
        $rep = $this->getDoctrine()->getRepository(Regime::class);
        $em = $this->getDoctrine()->getManager();
        $regime = $rep->find($id);
        $em->remove($regime);
        $em->flush();
        return $this->redirectToRoute('listRegimes');
    }


    


     /**
     * @Route("/searchRegime", name="searchRegime")
     */
    public function searchRegime(Request $request , RegimeRepository $regimeRepository){
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $posts =  $regimeRepository->findEntitiesByString($requestString);
        if(!$posts) {
            $result['posts']['error'] = "Pas de régime ! :( ";
        } else {
            $result['posts'] = $this->getRealEntities($posts);
        }
        return new Response(json_encode($result));
    }
    public function getRealEntities($posts){
        foreach ($posts as $posts){
            $realEntities[$posts->getId()] = [$posts->getImage(),$posts->getType()];

        }
        return $realEntities;
    }






   


  // Les fonctions Api

    /**
     * @Route("/AllRgimes", name="AllRgimes")
     */
    public function AllRgimes(NormalizerInterface $normalizer){
      
        $rep = $this->getDoctrine()->getRepository(Regime::class);
        $regimes = $rep->findAll();
        
       
      
        $json = $normalizer->normalize($regimes , 'json' , ['groups'=>['cat','regime']]);
        return new Response(json_encode($json));
    }


     /******************Ajouter Regime*****************************************/
     /**
      * @Route("/ajoutRegime", name="ajoutRegime")
      * 
      */

      public function ajoutRegime(Request $request,NormalizerInterface $normalizer , \Swift_Mailer $mailer )
      {
          $regime = new Regime();
          $type = $request->query->get("type");
          $description = $request->query->get("description");
          $dificulte = $request->query->get("dificulte");  
          $prix = $request->query->get("prix");
          $image = $request->query->get("image"); 
          $categorie_regime_id = $request->query->get("categorie_regime_id");
          $idUser= $request->query->get("user");
    
          $em = $this->getDoctrine()->getManager();
            
 
          $regime->setType($type);
          $regime->setDescription($description);
          $regime->setDificulte($dificulte);
          $regime->setPrix($prix);
          $regime->setImage($image);

          $rep = $this->getDoctrine()->getRepository(User::class);
          $user  = $rep->find($idUser);
          $regime->setUser($user);

            //envoie email success d'ajout regime
            $userEmail = $user->getEmail();
            $message = (new \Swift_Message('New'))

            ->setFrom('houssem.kouki@esprit.tn')

            ->setTo($userEmail )

            ->setSubject('Votre régime a été enregistrée !')
            ->setBody( $this->renderView(
                'regime/addRegimeEmail.html.twig'),
               
                'text/html'
            );
            $mailer->send($message); 
        /**
         * 
         * 
         */
        /*
         $file = $regime->getImage();
         dd($file);
            
            $fileName = md5(uniqid()).'.'.$file->guessExtension() ;
            try{
                $file->move(
                $this->getParameter('images_directory'),
                $fileName
            );
            }catch(FileException $e){

            }
            */
         

         
        
          $regime->setCategorieRegimeId($categorie_regime_id);
          $rep = $this->getDoctrine()->getRepository(CategorieRegime::class);
            $regime->setCategorieRegime($rep->find($categorie_regime_id));
         
          $em->persist($regime);
          $em->flush();
         // $serializer = new Serializer([new ObjectNormalizer()]);
          $formatted = $normalizer->normalize($regime , 'json' , ['groups'=>['cat','regime']]);
          //$formatted = $serializer->normalize($regime, 'json' , ['groups'=>['cat','regime']]);
         
          return new JsonResponse($formatted);
 
      }


       /******************Supprimer Regime*****************************************/

     /**
      * @Route("/suppRegime", name="suppRegime")
      * 
      */

      public function suppRegime(Request $request) {
        $id = $request->get("id");
        $em = $this->getDoctrine()->getManager();
        $reg = $em->getRepository(Regime::class)->find($id);
        if($reg!=null ) {
            $em->remove($reg);
            $em->flush();

            $serialize = new Serializer([new ObjectNormalizer()]);
            $formatted = $serialize->normalize(" Regime a ete supprimee avec success.");
            return new JsonResponse($formatted);

        }
        return new JsonResponse("id regime invalide.");


        


    }  




    
      /******************Modifier Regime*****************************************/
    /**
     * @Route("/modifRegime", name="modifRegime")
     * 
     */
    public function modifRegime(Request $request,NormalizerInterface $normalizer) {
        $em = $this->getDoctrine()->getManager();
        $regime = $this->getDoctrine()->getManager()
                        ->getRepository(Regime::class)
                        ->find($request->get("id"));

    

        $regime->setType($request->get("type"));
        $regime->setDescription($request->get("description"));
        $regime->setDificulte($request->get("dificulte"));
        $regime->setPrix($request->get("prix"));
        $regime->setImage($request->get("image"));

        $categorie_regime_id = $request->query->get("categorie_regime_id");
        $regime->setCategorieRegimeId($categorie_regime_id);
        $rep = $this->getDoctrine()->getRepository(CategorieRegime::class);
          $regime->setCategorieRegime($rep->find($categorie_regime_id));

        $em->persist($regime);
        $em->flush();
        $formatted = $normalizer->normalize($regime , 'json' , ['groups'=>['cat','regime']]);
          //$formatted = $serializer->normalize($regime, 'json' , ['groups'=>['cat','regime']]);
         
          return new JsonResponse($formatted);
        return new JsonResponse("Regime a ete modifiee avec success.");

    }


}
