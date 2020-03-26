<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="orders")
 * @ORM\Entity()
 */
class Order
{
    public const STATUS_NEW = 'new';
    public const STATUS_PAID = 'paid';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    private int $id;

    /**
     * @ORM\Column(length=255)
     */
    private string $status = self::STATUS_NEW;

    /**
     * @ORM\Column(type="integer")
     */
    private int $total = 0;

    /**
     * @var array<int>
     * @ORM\Column(type="array")
     */
    private array $products = [];

    public function getId(): int
    {
        return $this->id;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): Order
    {
        $this->status = $status;

        return $this;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function setTotal(int $total): Order
    {
        $this->total = $total;

        return $this;
    }

    /**
     * @return array<int>
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * @param array<int> $products
     *
     * @return Order
     */
    public function setProducts(array $products): Order
    {
        $this->products = $products;

        return $this;
    }
}
