<?php

declare(strict_types=1);

namespace App\Action\Order;

use App\Entity\Order;
use App\Exception\BadRequestException;
use App\Exception\OrderNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PayAction implements RequestHandlerInterface
{
    protected EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $orderId = $request->getAttribute('id');
            if (!$orderId) {
                throw new BadRequestException('Param "id" not found');
            }

            $body = $request->getBody()->getContents();
            if (!$body) {
                throw new BadRequestException('Empty request');
            }

            $params = json_decode($body, true);
            if (null === $params || !isset($params['total'])) {
                throw new BadRequestException('Param "total" not found');
            }

            /** @var Order|null $order */
            $order = $this->em->getRepository(Order::class)->find($orderId);
            if (null === $order) {
                throw new OrderNotFoundException(sprintf('Order with id=%d not found', $orderId));
            }

            if ($order->getStatus() === Order::STATUS_NEW && (int) $params['total'] === $order->getTotal()) {
                $response = (new Client([
                    'base_uri' => 'http://ya.ru',
                    'timeout' => '2.0',
                ]))->get('/');

                if (200 !== $response->getStatusCode()) {
                    throw new BadRequestException('Bad request to ya.ru');
                }

                $order->setStatus(Order::STATUS_PAID);
                $this->em->flush();

                return new JsonResponse([
                    'status' => 'success'
                ]);
            }

            throw new BadRequestException('Bad status or total price');
        } catch (BadRequestException | OrderNotFoundException $e) {
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
