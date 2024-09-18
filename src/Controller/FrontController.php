<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\PostRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FrontController extends AbstractController
{
    #[Route('/', name: 'app_front')]
    public function index(ProductRepository $ProductRepository): Response
    {
        $products = $ProductRepository->findLastProducts();

        // dd(vars: $products);

        return $this->render('front/index.html.twig', [
            // 'controller_name' => 'FrontController',
            'products' => $products,
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
    public function catalogue(ProductRepository $ProductRepository): Response
    {
        return $this->render('front/catalogue.html.twig', [
            // 'controller_name' => 'FrontController',
            'products' => $ProductRepository->findAll(),
        ]);
    }

    #[Route('/catalogue/{id}', name: 'app_front_catalogue_detail')]
    public function catalogueDetail(Product $product): Response
    {
        // dd($product);

        return $this->render('front/catalogue_detail.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/actualites', name: 'app_front_actualites')]
    public function actualites(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findAll();

        // dd($posts);

        return $this->render('front/actualites.html.twig', [
            // 'controller_name' => 'FrontController',
            'posts' => $posts,
        ]);
    }

    #[Route('/actualites/{id}', name: 'app_front_actualites_detail')]
    public function actualites_show(PostRepository $postRepository, $id): Response
    {
        $post = $postRepository->findOneBy(['id' => $id]);

        // dd($post);

        return $this->render('front/actualites_detail.html.twig', [
            // 'controller_name' => 'FrontController',
            'post' => $post,
        ]);
    }
}
