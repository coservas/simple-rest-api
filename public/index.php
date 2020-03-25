<?php

declare(strict_types=1);

use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

App\Env::load();

$request = ServerRequestFactory::fromGlobals();
$response = (new App\Application())->process($request);

$emitter = new SapiEmitter();
$emitter->emit($response);
