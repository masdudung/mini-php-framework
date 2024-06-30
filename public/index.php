<?php
require_once '../vendor/autoload.php';

use System\Core\Router;

$router = new Router();

// Define routes
$router->addRoute('GET', '', 'HomeController@index');  // Handle root URL
$router->addRoute('GET', 'home', 'HomeController@index');
$router->addRoute('GET', 'login', 'LoginController@showLoginForm');
$router->addRoute('POST', 'login', 'LoginController@login');

$router->addRouteGroup('admin', function ($group) {
    // $group->middleware('AuthMiddleware');
    $group->addRoute('GET', 'login/{id}', 'LoginController@showUser');
    $group->addRoute('GET', 'login/{id}/{catId}/{ini}', 'LoginController@showUserCategory');
});

// Run the router
$router->run();
