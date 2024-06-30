<?php

namespace System\Core;

use App\Middleware;

// system/Core/Router.php
require_once 'RouteGroup.php';

class Router {
    protected $routes = [];

    public function addRouteGroup($prefix, callable $callback) {
        $group = new RouteGroup($prefix);
        $callback($group);

        // Merge group routes into main routes
        $this->routes = array_merge($this->routes, $group->getRoutes());
    }

    public function addRoute($method, $url, $controllerAction, $middleware = []) {
        $this->routes[] = [
            'method' => strtoupper($method),
            'url' => $url,
            'controllerAction' => $controllerAction,
            'middleware' => $middleware
        ];
    }

    public function run() {
        $url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';
        $method = $_SERVER['REQUEST_METHOD'];

        $url = filter_var($url, FILTER_SANITIZE_URL);

        foreach ($this->routes as $route) {
            if ($route['method'] == $method) {
                $pattern = preg_replace('/\{[^\}]+\}/', '([^/]+)', $route['url']);
                if (preg_match('#^' . $pattern . '$#', $url, $matches)) {
                    array_shift($matches); // Remove full match

                    // Check and execute middleware before proceeding to controller action
                    if (isset($route['middleware'])) {
                        foreach ($route['middleware'] as $middleware) {
                            $this->executeMiddleware($middleware);
                        }
                    }

                    $controllerAction = explode('@', $route['controllerAction']);
                    $controllerName = $controllerAction[0];
                    $methodName = $controllerAction[1];

                    $controllerFile = '../app/Controllers/' . $controllerName . '.php';

                    if (file_exists($controllerFile)) {
                        require_once $controllerFile;
                        $controller = new $controllerName;
                        if (method_exists($controller, $methodName)) {
                            call_user_func_array([$controller, $methodName], $matches);
                            return;
                        } else {
                            $this->handle404("Method $methodName not found in $controllerName");
                        }
                    } else {
                        $this->handle404("File $controllerFile not found");
                    }
                }
            }
        }

        // If no match found, redirect to 404 page
        $this->handle404();
    }

    protected function executeMiddleware($middleware) {
        $middlewareClass = '../app/Middleware/' . $middleware . '.php';

        if (file_exists($middlewareClass)) {
            require_once $middlewareClass;
            $middlewareInstance = new $middleware();
            $middlewareInstance->handle();
        } else {
            throw new Exception("Middleware $middleware not found");
        }
    }

    protected function handle404($message = 'Page not found') {
        http_response_code(404);
        require_once '../app/Views/404.php';
        exit($message);
    }
}

