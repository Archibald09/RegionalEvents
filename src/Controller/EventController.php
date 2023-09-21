<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Events;
use DateTime;


class EventController extends AbstractController
{
    #[Route('/event/{id}', name: 'app_show')]
    public function show(ManagerRegistry $doctrine, $id)
    {

        // Récupérer l'événement depuis la base de données
        $event = $doctrine->getRepository(Events::class)->find($id);

        if (!$event) {
            throw $this->createNotFoundException('L\'événement n\'existe pas.');
        }

        $date = new DateTime();
        $formattedDate = $date->format('d-m-Y H:i');

        return $this->render('event/show.html.twig', [
            'event' => $event,
            'formattedDate' => $formattedDate,
        ]);
    }
}