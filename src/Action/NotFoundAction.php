<?php

namespace App\Action;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class NotFoundAction implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request = null): ResponseInterface
    {
        return new HtmlResponse('Page not found.', 404);
    }
}
