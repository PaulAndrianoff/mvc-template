<?php 

namespace App\Controllers;

use Symfony\Component\Routing\RouteCollection;

class ErrorController
{
    /**
	 * @param RouteCollection $routes
	 */
	public function indexAction(RouteCollection $routes):void
	{
		require_once APP_ROOT . '/views/pages/error404.php';
	}
}