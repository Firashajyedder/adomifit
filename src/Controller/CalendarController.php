<?php

namespace App\Controller;

use App\Entity\Calendar;
use App\Form\CalendarType;
use App\Repository\CalendarRepository;
use App\Repository\SuiviRegimeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/calendar")
 */
class CalendarController extends AbstractController
{
    /**
     * @Route("/testCalendar", name="testCalendar", methods={"GET"})
     */
    
    public function testCalendar(CalendarRepository $calendar): Response
    {
        $events = $calendar->findAll();
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
        return $this->render('calendar/index.html.twig', ['data'=>$data,
        'calendars' => $calendar->findAll(),
         
        ]);
    }
    
    /**
     * @Route("/", name="calendar_index", methods={"GET"})
     */
    public function index(CalendarRepository $calendarRepository): Response
    {
       
        return $this->render('calendar/index.html.twig', [
            'calendars' => $calendarRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="calendar_new", methods={"GET", "POST"})
     */
    public function new(Request $request,  SuiviRegimeRepository $suiviRegimeRepository ,$id): Response
    {

        $suiviRegime =$suiviRegimeRepository->find($id) ;
        $calendar = new Calendar();

        $form = $this->createForm(CalendarType::class, $calendar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $calendar = $form->getData();
            $calendar->setSuiviRegime($suiviRegime);
            $em = $this->getDoctrine()->getManager();
            $em->persist($calendar);
            $em->flush();
            return $this->redirectToRoute('CalendarSuivi', ['id' => $suiviRegime->getId()]);
       
        }

        return $this->render('calendar/new.html.twig', [
            'calendar' => $calendar,
            'formAdd' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="calendar_show", methods={"GET"})
     */
    public function show(Calendar $calendar): Response
    {
        return $this->render('calendar/show.html.twig', [
            'calendar' => $calendar,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="calendar_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, $id): Response
    {
        $rep = $this->getDoctrine()->getRepository(Calendar::class);
        $calendar  = $rep->find($id);
        $suiviRegime = $calendar->getSuiviRegime();
        $form = $this->createForm(CalendarType::class, $calendar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('CalendarSuivi', ['id' => $suiviRegime->getId()]);
        }

        return $this->render('calendar/edit.html.twig', [
            'calendar' => $calendar,
            'formUpdate' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="calendar_delete", methods={"POST"})
     */
    public function delete($id): Response
    {
        $rep = $this->getDoctrine()->getRepository(Calendar::class);
        $em = $this->getDoctrine()->getManager();
        $calendar = $rep->find($id);
        $suiviRegime = $calendar->getSuiviRegime();
        $em->remove($calendar);
        $em->flush();

        return $this->redirectToRoute('CalendarSuivi', ['id' => $suiviRegime->getId()]);
    }





    


     /**
     * @Route("/CalendarSuivi/{id}", name="CalendarSuivi", methods={"GET"})
     */
    
    public function CalendarSuivi($id,CalendarRepository $calendar , SuiviRegimeRepository $suiviRegimeRepository): Response
    {
        $suiviRegime =$suiviRegimeRepository->find($id) ;
        $events = $calendar->findCalendarSuivi($id);
        
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
        return $this->render('calendar/affichCalendarSuivi.html.twig', ['data'=>$data,
        'calendars' => $events,'suiviRegime' => $suiviRegime,
         
        ]);
    }
}
