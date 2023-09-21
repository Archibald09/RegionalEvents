<?php

namespace App\Controller;

use App\Entity\Events;
use App\Form\EventsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;


class EventsController extends AbstractController
{
    #[Route('/events/create', name: 'app_events_create')]
    public function eventsCreate(Request $request, ManagerRegistry $doctrine, UserInterface $user): Response
    {
        $event = new Events();
        $form = $this->createForm(EventsType::class, $event);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event->setUser($user);
            $entityManager = $doctrine->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            $this->addFlash('success', 'L\'événement a été créé avec succès.');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('events/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/events/edit/{id}', name: 'app_events_edit')]

   public function eventsEdit(Request $request, ManagerRegistry $doctrine, $id) : Response
   {   

        $entityManager = $doctrine->getManager();
        $events = $entityManager->getRepository(Events::class)->find($id);

        if (!$events) {
            throw $this->createNotFoundException('Événement non trouvé');
        }

        $form = $this->createForm(EventsType::class, $events);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_home'); 
        }

        return $this->render('events/edit.html.twig', [
            'events' => $events,
            'form' => $form->createView(),
        ]);
}

    #[Route('/events/delete/{id}', name: 'app_events_delete')]

    public function eventsDelete(Events $events, EntityManagerInterface $manager) : Response
    {      

        $manager->remove($events);
        $manager->flush();

        $this->addFlash('danger', "Le produit: " . $events->getTitre() . " a bien été supprimé ");

        return $this->redirectToRoute('app_home');
    }




}
