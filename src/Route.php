<?php

namespace App;

use Closure;

/**
 * Class Route
 * @package App
 */
class Route
{
    private string $method;
    private string $path;
    private Closure $callback;

    public function __construct(string $method, string $path, array $callback)
    {
        $this->method   = $method;
        $this->path     = $path;
        $this->callback = $this->prepareCallback($callback);
    }

    private function prepareCallback(array $callback): Closure
    {
        return function (...$params) use ($callback) {
            list($class, $method) = $callback;
//            var_dump($class); exit;
            return (new $class)->$method(...$params);
        };
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function match(string $uri, string $method): bool
    {
        return preg_match('/^' . str_replace(['*', '/'], ['\w+', '\/'], $this->getPath()) . '$/', $uri) && ($this->method === $method);
    }

    public function run(string $uri)
    {
        preg_match('/^' . str_replace(['*', '/'], ['(\w+)', '\/'], $this->getPath()) . '$/ius', $uri, $matches);
        array_shift($matches);

        if ($matches) {
            return call_user_func_array($this->callback, $matches);
        } else {
            return call_user_func_array($this->callback, []);

        }
    }
}
