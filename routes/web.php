<?php 

use App\Core\Router;

$router = new Router($_GET['route']); 
$router->get('/', 'Home#indexAction');
$router->get('/404', 'Error#indexAction');
$router->get('/posts/:id', 'Product#showAction');
$router->get('/posts/:id/:name', 'Product#showAction');
// dd($router->getNamedRoutes());
$router->run($router->getNamedRoutes());