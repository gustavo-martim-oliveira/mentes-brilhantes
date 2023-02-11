<?php

namespace Config;

class Router {
    protected $routes = [];

    public function addRoute($method, $uri, $handler) {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'handler' => $handler,
        ];
    }

    public function handleRequest() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach ($this->routes as $route) {
            if ($route['method'] === $method) {
                $pattern = "#^" . preg_replace('/{(\w+)}/', '(?<$1>[^/]+)', $route['uri']) . "$#";
                if (preg_match($pattern, $uri, $matches)) {
                    $handler = $route['handler'];
                    return $handler($matches);
                }
            }
        }

        header("HTTP/1.0 404 Not Found");
        echo "Route not found";
        exit;
    }
}