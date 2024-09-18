<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FrontController extends AbstractController
{
    #[Route('/', name: 'app_front')]
    public function index(): Response
    {
        return $this->render('front/index.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }

    #[Route('/contact', name: 'app_front_contact')]
    public function contact(): Response
    {
        return $this->render('front/contact.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }

    #[Route('/about', name: 'app_front_about')]
    public function about(): Response
    {
        return $this->render('front/about.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }

    #[Route('/catalogue', name: 'app_front_catalogue')]
    public function catalogue(): Response
    {
        return $this->render('front/catalogue.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }

    #[Route('/actualites', name: 'app_front_actualites')]
    public function actualites(): Response
    {
        return $this->render('front/actualites.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }
}
