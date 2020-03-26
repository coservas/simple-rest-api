<?php

declare(strict_types=1);

namespace App\Action\Order;

use App\Entity\Order;
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
        $orders = $this->em->getRepository(Order::class)->findAll();

        return new JsonResponse(array_map(fn (Order $order): array => [
            'id' => $order->getId(),
            'total' => $order->getTotal(),
            'status' => $order->getStatus(),
            'products' => $order->getProducts(),
        ], $orders));
    }
}
