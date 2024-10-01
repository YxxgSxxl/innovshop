<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ApiController extends AbstractController
{
    #[Route('/api', name: 'app_api')]
    public function index(): Response
    {
        return $this->json([
            'message' => "test",
        ]);
    }

    #[Route('/api/products', name: 'app_api_products')]
    public function products(ProductRepository $products, SerializerInterface $serializer): Response
    {
        $listProducts = $products->findAllProducts();

        $jsonProductsList = $serializer->serialize($listProducts, 'json');
        return new JsonResponse($jsonProductsList, Response::HTTP_OK, [], true);
    }

    #[Route('/api/productdetails/{id}', name: 'app_api_productdetails')]
    public function productDetails(int $id, ProductRepository $products, SerializerInterface $serializer): Response
    {
        $product = $products->findByID($id);

        $jsonProductDetails = $serializer->serialize($product, 'json');
        return new JsonResponse($jsonProductDetails, Response::HTTP_OK, [], true);
    }
}