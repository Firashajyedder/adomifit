<?php

namespace App\Controller;

use App\Entity\Regime;
use App\Form\AddRegimeType;
use Doctrine\ORM\Mapping\Id;
use App\Entity\CategorieRegime;
use App\Repository\RegimeRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class RegimeController extends AbstractController
{
    /**
     * @Route("/regime", name="regime")
     */
    public function index(Request $request,PaginatorInterface $paginator): Response
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
     * @Route("/listRegimes", name="listRegimes")
     */
    public function list(RegimeRepository $regimeRepository): Response
    {
        //va etre variable session
        $user_id=2;
       
        $regimes = $regimeRepository->findListRegimeByIdUser($user_id);
 
        return $this->render('regime/listRegimes.html.twig', [
          'regimes'=>$regimes,
     ]);
        
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
    public function addRegime(Request $request): Response
    {

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
            return $this->redirectToRoute('listRegimes');
        }


        return $this->render('regime/addRegime.html.twig', [
            'formAddRegime'=>$form->createView(),
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
        $posts = $regimeRepository->findEntitiesByString($requestString);

        if (!$posts){
            $result['posts']['error' ]= "Pas de régime !";
        }else{
            $result['posts']=$this->getRealEntities($posts);
        }
        return new Response(json_encode($result));

    }

    public function getRealEntities($posts){
        foreach($posts as $posts){
            $realEntities[$posts->getId()] = [$posts->getImage() , $posts->getType()];

        }
        return $realEntities;
    }




    


}
