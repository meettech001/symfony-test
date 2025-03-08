<?php

namespace App\Tests\Controller;

use App\Controller\ApiProductController;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ApiProductControllerTest extends WebTestCase
{
    private MockObject $paginator;
    private MockObject $serializer;
    private KernelBrowser $client;

    protected function setUp(): void
    {
        
        $this->client = static::createClient();
        self::bootKernel();
        $container = static::getContainer();

        $this->paginator = $this->createMock(PaginatorInterface::class);
        $this->serializer = $this->createMock(SerializerInterface::class);

    }

    public function testList(): void
    {
        

        // Create a mock product entity
        $mockProduct = new Product();
        $mockProduct->setShortDescription('Test Product');

        // Create a mock PaginationInterface object
        $paginationMock = $this->createMock(PaginationInterface::class);
        $paginationMock->method('getItems')->willReturn([$mockProduct]);
        $paginationMock->method('getCurrentPageNumber')->willReturn(1);
        $paginationMock->method('getTotalItemCount')->willReturn(10);

        // Mock paginator behavior
        $this->paginator->method('paginate')->willReturn($paginationMock);

        // Make request
        $this->client->request('GET', '/api/products?page=1&limit=10');

        // Verify response
        $this->assertResponseIsSuccessful();
        $responseData = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertIsArray($responseData);
        $this->assertArrayHasKey('data', $responseData);
        $this->assertArrayHasKey('pagination', $responseData);
        $this->assertArrayHasKey('current_page', $responseData['pagination']);
        $this->assertArrayHasKey('total_products', $responseData['pagination']);
        $this->assertEquals(1, $responseData['pagination']['current_page']);
        $this->assertEquals(10, $responseData['pagination']['total_products']);
    }

    public function testDetail(): void
    {
        $mockProduct = new Product();
        $mockProduct->setShortDescription('Sample Product');

        $this->serializer->method('serialize')->willReturn(json_encode($mockProduct));

        $this->client->request('GET', '/api/products/402');

        // Verify response
        $this->assertResponseIsSuccessful();
        $response = json_decode($this->client->getResponse()->getContent(), true);

        //$this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        
        $decodedResponse = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('short_description', $decodedResponse);
        $this->assertEquals('Sample Product', $decodedResponse['title']);
    }
}
