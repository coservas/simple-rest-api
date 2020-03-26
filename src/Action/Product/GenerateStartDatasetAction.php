<?php

declare(strict_types=1);

namespace App\Action;

use App\Entity\Product;
use App\Service\ProductService;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class GenerateStartDatasetAction implements RequestHandlerInterface
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $products = $this->productService->generateStartDatasetAndGet();

        return new JsonResponse(array_map(fn (Product $product): array => [
            'id' => $product->getId(),
            'name' => $product->getName(),
            'price' => $product->getPrice(),
        ], $products));
    }
}
