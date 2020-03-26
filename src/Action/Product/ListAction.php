<?php

declare(strict_types=1);

namespace App\Action\Product;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ListAction implements RequestHandlerInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $products = $this->em->getRepository(Product::class)->findAll();

        return new JsonResponse(array_map(fn (Product $product): array => [
            'id' => $product->getId(),
            'name' => $product->getName(),
            'price' => $product->getPrice(),
        ], $products));
    }
}
