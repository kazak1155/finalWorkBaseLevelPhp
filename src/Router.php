<?php

namespace App;

use App\Exception\NotFoundException;

/**
 * Class Router
 * @package App
 */
class Router
{
    private array $routes = [];

    public function get(string $path, array $callback)
    {
        $this->addRoute('get', $path, $callback);
    }

    public function post(string $path, array $callback)
    {
        $this->addRoute('post', $path, $callback);
    }

    public function delete(string $path, array $callback)
    {
        $this->addRoute('delete', $path, $callback);
    }

    public function put(string $path, array $callback)
    {
        $this->addRoute('put', $path, $callback);
    }

    private function addRoute(string $method, string $path, array $callback)
    {

        $this->routes[] = new Route($method, $path, $callback);
    }

    public function dispatch(string $uri, string $method)
    {
        $method = mb_strtolower($method);
        $uri = trim($uri, '/');

        $uri = preg_replace('/\?.*/', '', $uri);

        foreach ($this->routes as $route) {
            if ($route->match($uri, $method)) {
                return $route->run($uri);
            }
        }
        throw new NotFoundException();
    }
}
    