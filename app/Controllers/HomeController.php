<?php 

namespace App\Controllers;

use App\Core\SessionHandler;
use App\Core\RouterCollection;

use function App\Helper\dd;

/**
 * HomeController
 */
class HomeController
{
    /**
	 * @param RouterCollection $routes
	 */
	public function indexAction(RouterCollection $routes):void
	{
		SessionHandler::resetRoute();
		// $routeToProduct = str_replace(':id', 1, $routes->get('Product#showAction')->getPath());
		// $routeToProduct = str_replace(':name', 'test', $routeToProduct);

		$routeToProduct = $routes->get('Product#showAction')->setPath([1]);

        require_once APP_ROOT . '/views/pages/home.php';
	}
}