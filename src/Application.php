<?php

declare(strict_types=1);

namespace App;

use Aura\Router\Generator;
use Aura\Router\Map;
use Aura\Router\Route;
use Aura\Router\RouterContainer;
use Exception;
use Laminas\Stratigility\MiddlewarePipe;
use Laminas\Stratigility\MiddlewarePipeInterface;
use League\Container\Container;
use League\Container\ReflectionContainer;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class Application implements MiddlewarePipeInterface
{
    private ContainerInterface $container;
    private MiddlewarePipeInterface $pipeline;
    private RouterContainer $router;

    public function __construct()
    {
        $this->setRouter();
        $this->setContainer();
        $this->setMiddleware();

        $this->addParams();
        $this->addConfigs();
        $this->addServices();
        $this->addMiddlewares();
        $this->addRoutes();
    }

    private function setRouter(): void
    {
        $this->router = new RouterContainer();
    }

    private function setContainer(): void
    {
        $this->container = new Container();
        $this->container->delegate(
            new ReflectionContainer()
        );

        $this->container->add(ContainerInterface::class, $this->container);
        $this->container->add(RouterContainer::class, $this->router);
        $this->container->add(Generator::class, $this->router->getGenerator());
        $this->container->add(Map::class, $this->router->getMap());
    }

    private function setMiddleware(): void
    {
        $this->pipeline = new MiddlewarePipe();
    }

    private function addParams(): void
    {
        $parameters = require 'config/parameters.php';
        $this->container->add('parameters', $parameters);
    }

    private function addConfigs(): void
    {
        $configs = require 'config/config.php';
        $this->container->add('config', $configs);
    }

    private function addServices(): void
    {
        $services = require 'config/services.php';

        foreach ($services as $id => $concrete) {
            if (is_string($concrete) || is_object($concrete)) {
                $this->container->add($id, $concrete);
                continue;
            }

            throw new Exception('Non valid service.');
        }
    }

    private function addMiddlewares(): void
    {
        $middlewares = require 'config/middlewares.php';

        foreach ($middlewares as $middleware) {
            if (is_string($middleware)) {
                $this->pipe($this->container->get($middleware));
                continue;
            }

            if (is_object($middleware) && ($middleware instanceof MiddlewareInterface)) {
                $this->pipe($middleware);
                continue;
            }

            throw new Exception('Non valid middleware.');
        }
    }

    private function addRoutes(): void
    {
        $routes = require 'config/routes.php';
        $map = $this->router->getMap();

        foreach ($routes as $route) {
            if (isset($route['routes'])) {
                $namePref = $route['name_prefix'] ?? '';
                $pathPref = $route['path_prefix'] ?? '';

                $map->attach($namePref, $pathPref, function (Map $map) use ($route) {
                    foreach ($route['routes'] as $r) {
                        $map = $this->addRoute($map, $r);
                    }
                });

                continue;
            }

            $map = $this->addRoute($map, $route);
        }
    }

    private function addRoute(Map $map, array $route): Map
    {
        $methods = $route['methods'];

        if (!is_array($methods)) {
            throw new Exception('Methods must be an array');
        }

        foreach ($methods as $method) {
            $this->checkMethod($method);

            /* @var Route $auraRoute */
            $auraRoute = $map->$method($route['name'], $route['path'], $route['handler']);

            if (isset($route['tokens'])) {
                $auraRoute->tokens($route['tokens']);
            }

            if (isset($route['defaults'])) {
                $auraRoute->tokens($route['defaults']);
            }
        }

        return $map;
    }

    private function checkMethod(string $method): void
    {
        if (false === array_search($method, ['get', 'post'])) {
            throw new Exception('Method not found');
        }
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler = null): ResponseInterface
    {
        return $this->pipeline->process($request, $handler ?? $this->container->get(NotFoundAction::class));
    }

    public function pipe(MiddlewareInterface $middleware): void
    {
        $this->pipeline->pipe($middleware);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->pipeline->handle($request);
    }

    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }
}
