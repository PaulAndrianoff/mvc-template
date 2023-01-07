<?php 

namespace App\Controllers;

use Symfony\Component\Routing\RouteCollection;
use App\SessionHandler;

/**
 * @param RouteCollection $routes
 */
class HomeController
{
    /**
	 * @param RouteCollection $routes
	 */
	public function indexAction(RouteCollection $routes):void
	{
		SessionHandler::resetRoute();
		$routeToProduct = str_replace('{id}', 1, $routes->get('product')->getPath());
		
        require_once APP_ROOT . '/views/pages/home.php';
	}
}