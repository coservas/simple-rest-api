<?php

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Symfony\Component\Console\Helper\HelperSet;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

App\Env::load();

/* @var EntityManagerInterface $em */
$em = (new App\Application())->getContainer()->get(EntityManagerInterface::class);

return new HelperSet([
    'em' => new EntityManagerHelper($em),
    'db' => new ConnectionHelper($em->getConnection())
]);
