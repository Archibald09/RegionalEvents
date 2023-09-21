<?php

namespace App\Controller;

use App\Entity\Events;
use App\Repository\EventsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Form\DateFilterType;

class SubscribeController extends AbstractController
{
    #[Route('/subscribe', name: 'app_subscribe')]
    public function eventsShow(EventsRepository $eventsRepository, ManagerRegistry $doctrine, Request $request) : Response
    {
        $events = new Events();
        
        $dateDebut = $events->getDateDebut();
        
        $dateFin = $events->getDateFin();

        $em = $doctrine->getManager();

        $colonnes = $em->getClassMetadata(Events::class)->getFieldNames();
        $colonnesSansId = array_diff($colonnes, ['id']);

        $events = $eventsRepository->findAll(['date_debut' => 'ASC']);
       
        $form = $this->createForm(DateFilterType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $date_debut = $data['date_debut'];
            $date_fin = $data['date_fin'];

            $events = $eventsRepository->findEventsInDateRange($date_debut, $date_fin);
        } else {
            $events = $eventsRepository->findAll();
        }

        return $this->render('subscribe/index.html.twig', [
           'colonnesSansId' => $colonnesSansId,
           'events' => $events,   
           'date_debut' => $dateDebut,
           'date_fin' => $dateFin,
           'form' => $form->createView(),
        ]);
    }
}
