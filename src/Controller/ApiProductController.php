<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

#[Route('/api/products', name: 'api_products_')]
class ApiProductController extends AbstractController
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(Request $request, EntityManagerInterface $em, PaginatorInterface $paginator, SerializerInterface $serializer): JsonResponse
    {
        $products = $this->productRepository->getProducts();
        // Get pagination params
        $page = max(1, $request->query->getInt('page', 1));  // Default page = 1
        $limit = max(1, $request->query->getInt('limit', 10)); // Default limit = 10

        // Paginate the results
        $pagination = $paginator->paginate(
            $products,
            $page,   // Current page number
            $limit   // Items per page
        );

        // Serialize the paginated items
        $serializedProducts = $serializer->serialize(
            $pagination->getItems(),
            'json');
       // dump(); die;
        // Create response with pagination info
        $responseData = [
            'data' => json_decode($serializedProducts, true),  // Paginated products
            'pagination' => [
                'current_page' => $pagination->getCurrentPageNumber(),
                'total_pages' => ceil($pagination->getTotalItemCount() / $limit),
                'total_products' => $pagination->getTotalItemCount(),
                'limit' => $limit,
            ],
        ];

        return new JsonResponse($serializer->serialize($responseData, 'json', ['groups' => 'product:read']), 200, [], true);
 
    }

    #[Route('/{id}', name: 'detail', methods: ['GET'])]
    public function detail(Product $product, SerializerInterface $serializer): JsonResponse
    {
        return new JsonResponse($serializer->serialize($product, 'json', ['groups' => 'product:read']), 200, [], true);
    }
}
