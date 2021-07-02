<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Entity\Beer;

class BarController extends AbstractController
{
    private HttpClientInterface $_client;

    public function __construct(HttpClientInterface $client) {
        $this->_client = $client;
    }

    #[Route('/', name: 'home')]
    public function root(): Response
    {
        /** @var BeerRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Beer::class);

        return $this->render('bar/index.html.twig', [
            'beers' => $repository->getThreeLastElement()
        ]);
    }

    #[Route('/bar', name: 'bar')]
    public function index(): Response
    {
        return $this->render('bar/bar.html.twig', [
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


    //récupération de l'id beer

    #[Route('/beer/{id}', name: 'showbeer')]
    public function show($id): Response{
        $repository = $this->getDoctrine()->getRepository(Beer::class);

        return $this->render('bar/showbeer.html.twig', [
            'beer' => $repository->find($id)
        ]);
    }

    
    #[Route('/beers', name: 'beers')]
    public function beers(): Response{
        $repository = $this->getDoctrine()->getRepository(Beer::class);

        return $this->render('bar/beers.html.twig', [
            'beers' => $repository->findAll()
        ]);
    }

    #[Route('/newbeer', name:'create_beer')]
    public function createBeer(){
        $entityManager = $this->getDoctrine()->getManager();

        $beer = new Beer();
        $beer->setname('Super Beer');
        $beer->setPublishedAt(new \DateTime());
        $beer->setDescription('Ergonomic and stylish!');
        $beer->setRating(rand(0, 10));
        $beer->setStatus(rand(0, 1) ? 'available' : 'unavailable');

        $degrees = [0, 5, 4.5, 8, 9.5];
        $rand_keys = array_rand($degrees, 1);

        $beer->setDegree($degrees[$rand_keys]);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($beer);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new beer with id '.$beer->getId());
    }
}