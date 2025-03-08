<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProductRepository;

class HomeController extends AbstractController
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $products = $this->productRepository->getFeaturedProducts();

        // Fixed category list
        $categories = [
            ['name' => 'Books', 'slug' => 'books'],
            ['name' => 'Home', 'slug' => 'home'],
            ['name' => 'Electronics', 'slug' => 'electronics'],
            ['name' => 'Clothing', 'slug' => 'clothing'],
        ];
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'categories' => $categories,
            'products' => $products
        ]);
    }

}
