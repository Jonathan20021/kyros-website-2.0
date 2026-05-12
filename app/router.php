<?php
declare(strict_types=1);

/**
 * Dirt-simple router. Maps METHOD + PATH -> closure or [Controller, method].
 */
class Router
{
    /** @var array<string, array<string, callable|array>> */
    private array $routes = ['GET' => [], 'POST' => []];

    public function get(string $path, callable|array $handler): void
    {
        $this->routes['GET'][$this->normalize($path)] = $handler;
    }

    public function post(string $path, callable|array $handler): void
    {
        $this->routes['POST'][$this->normalize($path)] = $handler;
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $path   = $this->normalize(current_path());

        $handler = $this->routes[$method][$path] ?? null;

        if (!$handler) {
            // Try parameter routes (e.g., /services/{slug})
            foreach ($this->routes[$method] as $route => $h) {
                if (!str_contains($route, '{')) continue;
                $pattern = '#^' . preg_replace('#\{[^/]+\}#', '([^/]+)', $route) . '$#';
                if (preg_match($pattern, $path, $matches)) {
                    array_shift($matches);
                    $handler = $h;
                    $params = $matches;
                    break;
                }
            }
        }

        if (!$handler) {
            abort(404, 'Página no encontrada');
        }

        if (is_array($handler)) {
            [$class, $methodName] = $handler;
            (new $class())->{$methodName}(...($params ?? []));
            return;
        }

        $handler(...($params ?? []));
    }

    private function normalize(string $path): string
    {
        $p = '/' . trim($path, '/');
        return $p === '/' ? '/' : rtrim($p, '/');
    }
}
