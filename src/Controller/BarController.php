<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BarController extends AbstractController
{
    private HttpClientInterface $_client;

    public function __construct(HttpClientInterface $client) {
        $this->_client = $client;
    }

    #[Route('/', name: 'root')]
    public function root(): Response
    {
        return $this->redirectToRoute("bar");
    }

    #[Route('/bar', name: 'bar')]
    public function index(): Response
    {
        return $this->render('bar/index.html.twig', [
            'controller_name' => 'BarController',
        ]);
    }

    #[Route('/contact', name: 'contact')]
    public function contact(): Response
    {
        return $this->render('bar/contact.html.twig', [
            'title' => 'My Contact Page',
        ]);
    }

    #[Route('/mention', name: 'mention')]
    public function mention(): Response{
        return $this->render('bar/mention.html.twig');
    }

    #[Route('/beers', name: 'beers')]
    public function beers(): Response{
        $response = $this->_client->request(
            'GET',
            'https://raw.githubusercontent.com/Antoine07/hetic_symfony/main/Introduction/Data/beers.json'
        );
        return $this->render('bar/beers.html.twig', ["beers" => $response->toArray()["beers"]]);
    }
}