<?php 

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

// Routes system
$routes = new RouteCollection();

$routes->add(
    'product', 
    new Route(
        constant('BASE_URL') . '/product/{id}', 
        array('controller' => 'ProductController',
        'method' => 'showAction'), 
        array('id' => '[0-9]+')
    )
);

$routes->add(
    'homepage', 
    new Route(
        constant('BASE_URL') . '/', 
        array('controller' => 'HomeController',
        'method' => 'indexAction'), 
        array()
    )
);

$routes->add(
    'error', 
    new Route(
        constant('BASE_URL') . '/404', 
        array('controller' => 'ErrorController',
        'method' => 'indexAction'), 
        array()
    )
);