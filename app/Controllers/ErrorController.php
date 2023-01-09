<?php 

namespace App\Controllers;

class ErrorController
{
	public function indexAction():void
	{
		require_once APP_ROOT . '/views/pages/error404.php';
	}
}