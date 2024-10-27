<?php

// src/Controller/DetteController.php

namespace App\Controller;

use App\Entity\Client;
use App\Repository\DetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DetteController extends AbstractController
{
    #[Route('/clients/{id}/dettes', name: 'dette_index')]
    public function index(Client $client, DetteRepository $detteRepository): Response
    {
        // Récupérer toutes les dettes du client
        $dettes = $detteRepository->findBy(['client' => $client]);

        // Calculer le total des montants des dettes
        $totalMontant = array_reduce($dettes, function($carry, $dette) {
            return $carry + $dette->getMontant(); // Assure-toi que getMontant() renvoie le montant de la dette
        }, 0);

        return $this->render('dette/index.html.twig', [
            'client' => $client,
            'dettes' => $dettes,
            'totalMontant' => $totalMontant, // Passer totalMontant au template
        ]);
    }
}

