<?php

use ContainerInteropDoctrine\EntityManagerFactory;
use Doctrine\ORM\EntityManagerInterface;

return [
    EntityManagerInterface::class => fn (): EntityManagerInterface
        => $this->container->get(EntityManagerFactory::class)($this->container),
];
