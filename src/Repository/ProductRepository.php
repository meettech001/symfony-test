<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function getProducts(): Query {
        return $this->createQueryBuilder('p')
                ->orderBy('p.id','DESC')
                ->getQuery();
                //->getResult();
    }

    public function getFeaturedProducts(): mixed {
        return $this->createQueryBuilder('p')
                ->andWhere('p.isFeatured = :isFeatured')
                ->setParameter('isFeatured', true)
                ->orderBy('p.id','DESC')
                ->setMaxResults(4)
                ->getQuery()
                ->getResult();
    }
    

    public function getProductById(int $id): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getProductsByCategory(string $category): mixed{
        return $this->createQueryBuilder('p')
                    ->andWhere('p.category = :category')
                    ->setParameter('category', $category)
                    ->getQuery()
                    ->getResult();
    }
}
