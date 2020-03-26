<?php

declare(strict_types=1);

namespace App\Action\Order;

use App\Exception\BadRequestException;
use App\Service\OrderService;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CreateAction implements RequestHandlerInterface
{
    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $body = $request->getBody()->getContents();
            if (!$body) {
                throw new BadRequestException('Empty request');
            }

            $params = json_decode($body, true);
            if (null === $params || !isset($params['products'])) {
                throw new BadRequestException('Params "products" not found');
            }

            $order = $this->orderService->createOrderAndGet($params['products']);

            return new JsonResponse([
                'order_number' => $order->getId()
            ]);
        } catch (BadRequestException $e) {
            return new JsonResponse([
                'message' => $e->getMessage()
            ], 400);
        } catch (\Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
