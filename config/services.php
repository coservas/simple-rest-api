<?php

use ContainerInteropDoctrine\EntityManagerFactory;
use Doctrine\ORM\EntityManagerInterface;
use Laminas\Diactoros\ResponseFactory;
use Psr\Http\Message\ResponseFactoryInterface;

return [
    ResponseFactoryInterface::class => ResponseFactory::class,

    EntityManagerInterface::class => fn (): EntityManagerInterface
        => $this->container->get(EntityManagerFactory::class)($this->container),
];
