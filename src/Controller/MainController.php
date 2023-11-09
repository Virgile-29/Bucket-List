<?php

namespace App\Controller;

use PHPUnit\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MainController extends AbstractController
{
    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route('/', name: 'HomePage', methods: 'get')]
    public function index(HttpClientInterface $httpClient): Response
    {
        $response = $httpClient->request('GET', 'https://api.chucknorris.io/jokes/random', [
            'headers' => [
                'Content-Type: application/json',
                'Accept: application/json'
            ]
        ]);

        $joke = '';
        if($response->getStatusCode() === Response::HTTP_OK) {
            $joke = json_decode($response->getContent(), true)['values'] ?? 'Pas de joke aujourd\'hui';
        }


        return $this->render('main/index.html.twig', [
            'joke' => $joke
        ]);
    }

    #[Route('/about-us', name: 'Aboutus', methods: 'get')]
    public function aboutUs(): Response
    {
        try {
            $team = json_decode(file_get_contents('../data/team.json'), true);
            return $this->render('main/about-us.html.twig', [
                'team' => $team,
                'controller_name' => 'MainController',
            ]);
        } catch(Exception $e) {
            dd($e->getMessage());
        }
    }
}
