<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Client;

class ClientController extends AbstractController
{
    #[Route('/clients', name: 'clients')]
    public function clients(): Response{
        $repository = $this->getDoctrine()->getRepository(Client::class);

        return $this->render('client/clients.html.twig', [
            'clients' => $repository->findAll()
        ]);
    }
}
