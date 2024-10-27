<?php

// src/Controller/ClientController.php

namespace App\Controller;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    private ClientRepository $clientRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(ClientRepository $clientRepository, EntityManagerInterface $entityManager)
    {
        $this->clientRepository = $clientRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/clients', name: 'client_index')]
    public function index(Request $request): Response
    {
        $query = $this->clientRepository->createQueryBuilder('c');

        if ($request->query->get('surname')) {
            $query->andWhere('c.Surname LIKE :surname')
                ->setParameter('surname', '%' . $request->query->get('surname') . '%');
        }

        if ($request->query->get('telephone')) {
            $query->andWhere('c.Telephone LIKE :telephone')
                ->setParameter('telephone', '%' . $request->query->get('telephone') . '%');
        }

        $clients = $query->getQuery()->getResult();

        return $this->render('client/index.html.twig', [
            'clients' => $clients,
        ]);
    }

    #[Route('/clients/create', name: 'client_create')]
    public function create(Request $request): Response
    {
        $client = new Client();

        if ($request->isMethod('POST')) {
            $client->setNom($request->request->get('nom'));
            $client->setPrenom($request->request->get('prenom'));
            $client->setSurname($request->request->get('surname'));
            $client->setTelephone($request->request->get('telephone'));
            $client->setAdress($request->request->get('adress'));

            $this->entityManager->persist($client);
            $this->entityManager->flush();

            return $this->redirectToRoute('client_index');
        }

        return $this->render('client/create.html.twig', [
            'client' => $client,
        ]);
    }

    #[Route('/clients/{id}', name: 'client_show')]
    public function show(Client $client): Response
    {
        return $this->render('client/show.html.twig', [
            'client' => $client,
        ]);
    }

    public function delete(Client $client): Response
    {
        // Logique pour supprimer le client
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($client);
        $entityManager->flush();

        // Redirection vers la liste des clients
        return $this->redirectToRoute('client_index');
    }
}

