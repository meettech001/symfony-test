<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use App\Service\ImageDownloader;

class ProductFixtures extends Fixture
{
    private ImageDownloader $imageDownloader;

    public function __construct(#[Autowire(service: ImageDownloader::class)] ImageDownloader $imageDownloader)
    {
        $this->imageDownloader = $imageDownloader;
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $categories = ['Electronics', 'Clothing', 'Books', 'Home'];

        for ($i = 1; $i <= 100; $i++) {
            $imageUrl = 'https://picsum.photos/id/'.$i.'/800/600';
            $savedImage = $this->imageDownloader->download($imageUrl);

            
            $product = new Product();
            $product->setTitle($faker->sentence(3));
            $product->setShortDescription($faker->paragraph);
            $product->setPriceExclVat($faker->randomFloat(2, 10, 500));
            $product->setCategory($faker->randomElement($categories));
            if ($savedImage) {
                $product->setImage($savedImage);
             }
           
            $product->setIsTop(false);
            $product->setIsFeatured(false);
            if($i%10 == 0){
                $product->setIsTop(true);
            }
            if($i%15 == 0){
                $product->setIsFeatured(true);
            }
            $product->setCreatedAt(new \DateTime());
            $product->setUpdatedAt(new \DateTime());

            $manager->persist($product);
        }

        $manager->flush();
    }
}
