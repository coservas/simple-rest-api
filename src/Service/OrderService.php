<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Order;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class OrderService
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function createOrderAndGet(array $productIds): Order
    {
        $total = 0;
        foreach ($productIds as $productId) {
            /** @var Product $product */
            $product = $this->em->getRepository(Product::class)->find($productId);
            if (!$product) {
                throw new \Exception(sprintf('Product with id=%d not found', $productId));
            }

            $total += $product->getPrice();
        }

        $order = (new Order())->setTotal($total);

        $this->em->persist($order);
        $this->em->flush();

        return $order;
    }
}
