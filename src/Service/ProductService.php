<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Product;
use Bezhanov\Faker\Provider\Commerce;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Faker\Generator;

class ProductService
{
    private const PRODUCT_COUNT = 20;
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @return Product[]
     */
    public function generateStartDatasetAndGet(): array
    {
        $products = $this->em->getRepository(Product::class)->findAll();
        if ($products) {
            return $products;
        }

        $faker = $this->getFaker();

        for ($i = 0; $i < self::PRODUCT_COUNT; $i++) {
            $product = (new Product())
                ->setName($faker->unique()->productName)
                ->setPrice($faker->unique()->randomNumber(3));

            $products[] = $product;
            $this->em->persist($product);
        }

        $this->em->flush();

        return $products;
    }

    private function getFaker(): Generator
    {
        $faker = Factory::create();
        $faker->addProvider(new Commerce($faker));

        return $faker;
    }
}
