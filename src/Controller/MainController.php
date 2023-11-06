<?php

namespace App\Controller;

use PHPUnit\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'HomePage', methods: 'get')]
    public function index(): Response
    {
            return $this->render('main/index.html.twig', [
                'controller_name' => 'MainController',
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
