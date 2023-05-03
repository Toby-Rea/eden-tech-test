<?php

class Router
{
    private array $routes = [];
    private array $server;

    public function __construct(array $server)
    {
        $this->server = $server;
    }

    private function addRoute(string $method, string $route, string $file): void
    {
        $this->routes[$method][$route] = $file;
    }

    public function get(string $route, string $file): void
    {
        $this->addRoute('GET', $route, $file);
    }

    public function post(string $route, string $file): void
    {
        $this->addRoute('POST', $route, $file);
    }

    public function put(string $route, string $file): void
    {
        $this->addRoute('PUT', $route, $file);
    }

    public function delete(string $route, string $file): void
    {
        $this->addRoute('DELETE', $route, $file);
    }

    private function getRequestUri(): string
    {
        $uri = $this->server['REQUEST_URI'] ?? null;
        $uri = filter_var($uri, FILTER_SANITIZE_URL);
        return parse_url($uri, PHP_URL_PATH);
    }

    public function handle(): void
    {
        $route = $this->getRequestUri();
        $method = $this->server['REQUEST_METHOD'] ?? null;
        $file = $this->routes[$method][$route] ?? "/views/404.php";
        if (!file_exists(__DIR__ . '/../' . $file)) {
            throw new RuntimeException("File not found: " . $file);
        }

        require __DIR__ . '/../' . $file;
    }
}