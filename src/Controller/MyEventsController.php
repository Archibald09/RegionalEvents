<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Events;
use App\Repository\EventsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Form\DateFilterType;


class MyEventsController extends AbstractController
{
    #[Route('/myevents/user/{user_id}', name: 'app_my_events')]
    public function eventsShow(EventsRepository $eventsRepository, ManagerRegistry $doctrine, Request $request, $user_id) : Response
    {
        $events = new Events();
        
        $dateDebut = $events->getDateDebut();
        
        $dateFin = $events->getDateFin();

        $em = $doctrine->getManager();

        $colonnes = $em->getClassMetadata(Events::class)->getFieldNames();
        $colonnesSansId = array_diff($colonnes, ['id']);
       
        $form = $this->createForm(DateFilterType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $date_debut = $data['date_debut'];
            $date_fin = $data['date_fin'];

            $events = $eventsRepository->findEventsInDateRange($date_debut, $date_fin);
        } else {
            $events = $doctrine->getRepository(Events::class)->findBy(['user' => $user_id]);
        }

        return $this->render('my_events/show.html.twig', [
            'colonnesSansId' => $colonnesSansId,
           'events' => $events,   
           'date_debut' => $dateDebut,
           'date_fin' => $dateFin,
           'form' => $form->createView(),
        ]);
    }
}
