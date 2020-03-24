<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="products")
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    private int $id;

    /**
     * @ORM\Column(type="integer")
     */
    private int $price = 0;

    /**
     * @ORM\Column(length=255)
     */
    private string $name;

    public function getId(): int
    {
        return $this->id;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): Product
    {
        $this->price = $price;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Product
    {
        $this->name = $name;

        return $this;
    }
}
