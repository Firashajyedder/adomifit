<?php

namespace App\Controller;

use App\Form\CatRegimeType;
use App\Entity\CategorieRegime;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



use Symfony\Component\Serializer\Encoder\JsonEncoder;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Validator\Constraints\Json;


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
    public function deleteCatRegime($id): Response
    {
        $rep = $this->getDoctrine()->getRepository(CategorieRegime::class);
        $em = $this->getDoctrine()->getManager();
        $catRegime = $rep->find($id);
        $em->remove($catRegime);
        $em->flush();
        return $this->redirectToRoute('listCatRegime');
    }















    



  // Les fonctions Api

    /**
     * @Route("/AllCatRgimes", name="AllCatRgimes")
     */
    public function AllCatRgimes(NormalizerInterface $normalizer){
      
        $rep = $this->getDoctrine()->getRepository(CategorieRegime::class);
        $catRegimes = $rep->findAll();
        $json = $normalizer->normalize($catRegimes , 'json' , ['groups'=>['cat','regime']]);

        return new Response(json_encode($json));
    }

      /**
     * @Route("/detailCat", name="detailCat")
     * 
     */
    public function detailCat(Request $request,NormalizerInterface $normalizer): Response
    {
        $rep = $this->getDoctrine()->getRepository(CategorieRegime::class);
        $id = $request->get("id");
        $catRegime = $rep->find($id);
        if($catRegime!=null ) {
            $json = $normalizer->normalize($catRegime , 'json' ,['groups'=>['cat','regime']]);

            return new Response(json_encode($json));

        }
        return new JsonResponse("id categorie invalide.");
        
    }





    /******************Ajouter CatRegime*****************************************/
     /**
      * @Route("/addCategorieR", name="addCategorieR")
      * @Method("POST")
      */

      public function addCategorieR(Request $request)
      {
          $catRegime = new CategorieRegime();
          $libelle = $request->query->get("libelle");
          $description = $request->query->get("description");
          $statcolor = $request->query->get("statcolor");
          $em = $this->getDoctrine()->getManager();
       
 
          $catRegime->setLibelle($libelle);
          $catRegime->setDescription($description);
          $catRegime->setStatcolor($statcolor);
         
 
          $em->persist($catRegime);
          $em->flush();
          $serializer = new Serializer([new ObjectNormalizer()]);
          $formatted = $serializer->normalize($catRegime);
          return new JsonResponse($formatted);
 
      }

     
 
 /******************Supprimer CatRegime*****************************************/

     /**
      * @Route("/deleteCatR", name="deleteCatR")
      * @Method("DELETE")
      */

      public function deleteCatR(Request $request) {
        $id = $request->get("id");
        $em = $this->getDoctrine()->getManager();
        $catRegime = $em->getRepository(CategorieRegime::class)->find($id);
        if($catRegime!=null ) {
            $em->remove($catRegime);
            $em->flush();

            $serialize = new Serializer([new ObjectNormalizer()]);
            $formatted = $serialize->normalize("Categorie Regime a ete supprimee avec success.");
            return new JsonResponse($formatted);

        }
        return new JsonResponse("id reclamation invalide.");


    }    


      /******************Modifier CategorieR*****************************************/
    /**
     * @Route("/updateCategorieR", name="updateCategorieR")
     * @Method("PUT")
     */
    public function updateCategorieR(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $Catregime = $this->getDoctrine()->getManager()
                        ->getRepository(CategorieRegime::class)
                        ->find($request->get("id"));

        $Catregime->setLibelle($request->get("libelle"));
        $Catregime->setDescription($request->get("description"));
        $Catregime->setStatcolor($request->get("statcolor"));

        $em->persist($Catregime);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Catregime);
        return new JsonResponse("Reclamation a ete modifiee avec success.");

    }

     /******************affichage CategorieR*****************************************/

     /**
      * @Route("/displayCategorieR", name="displayCategorieR")
      */
      public function displayCategorieR(NormalizerInterface $normalizer) 
      {
 
          $Catregime = $this->getDoctrine()->getManager()->getRepository(CategorieRegime::class)->findAll();
          $json = $normalizer->normalize($Catregime , 'json' , ['groups'=>['cat','regime']]);
         
 
          return new Response(json_encode($json));
 
      }


      
     /******************Detail CategorieR*****************************************/

     /**
      * @Route("/detailCategorie", name="detailCategorie")
      * 
      */

     public function detailCategorieR(Request $request,NormalizerInterface $normalizer)
     {
         $id = $request->get("id");
         $Catregime = $this->getDoctrine()->getManager()->getRepository(CategorieRegime::class)->find($id);
         $json = $normalizer->normalize($Catregime , 'json' , ['groups'=>['cat','regime']]);
         
        
         return new Response(json_encode($json));



     }




}
