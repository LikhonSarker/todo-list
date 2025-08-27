<?php

require_once __DIR__.'../../Exceptions/RouteNotFoundException.php';

class Router
{
    private array $routes;

    public function register(string $route, callable $action): self
    {
        $this->routes[$route] = $action;

        return $this;
    }

    public function resolve(string $requestUrl)
    {
        $route = explode('?', $requestUrl)[0];
        $action = $this-> routes[$route] ?? null;

        if (!$action) {
            throw new RouteNotFoundException();
        }

        if (is_callable($action)) {
            $action();
            return;
        }

        throw new RouteNotFoundException();
    }
}
