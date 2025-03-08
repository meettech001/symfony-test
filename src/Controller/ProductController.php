<?php

namespace App\Controller;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController
{
    private ProductRepository $productRepository;
    private PaginatorInterface$paginator;

    public function __construct(ProductRepository $productRepository, PaginatorInterface $paginatorInterface )
    {
        $this->productRepository = $productRepository;
        $this->paginator = $paginatorInterface;
    }

    #[Route('/products', name: 'app_products')]
    public function products(Request $request): Response
    {
        $products = $this->productRepository->getProducts();

        $pagination = $this->paginator->paginate($products, $request->query->getInt('page', 1), 9);
        // Pass products to the template
        return $this->render('product/products.html.twig', [
            'pagination' => $pagination
        ]);
    }

    #[Route('/products/{id}', name: 'app_product_detail', methods: ['GET'])]
    public function productDetail(int $id): Response
    {
       
        $product = $this->productRepository->getProductById($id);
        
        return $this->render('product/detail.html.twig', [
            'product' => $product,
        ]);
        
    }

    #[Route('/products/category/{category}', name: 'app_category_products')]
    public function productsByCategory(string $category): Response
    {
        $products = $this->productRepository->getProductsByCategory($category);

        
        // Pass products to the template
        return $this->render('product/products.html.twig', [
            'products' => $products
        ]);
    }
}
