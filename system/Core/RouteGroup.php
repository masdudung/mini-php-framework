<?php

namespace System\Core;

// system/Core/RouteGroup.php
class RouteGroup {
    protected $prefix;
    protected $routes = [];
    protected $middleware = [];

    public function __construct($prefix) {
        $this->prefix = trim($prefix, '/');
    }

    public function addRoute($method, $url, $controllerAction, $middleware = []) {
        $this->routes[] = [
            'method' => strtoupper($method),
            'url' => $this->prefix . '/' . trim($url, '/'),
            'controllerAction' => $controllerAction,
            'middleware' => array_merge($this->middleware, $middleware) // Merge group and route middleware
        ];
    }

    public function middleware($middleware) {
        $this->middleware[] = $middleware;
    }

    public function getRoutes() {
        return $this->routes;
    }

    public function getMiddleware() {
        return $this->middleware;
    }
}

