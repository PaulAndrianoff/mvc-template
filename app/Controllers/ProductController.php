<?php 

namespace App\Controllers;

use App\Models\Product;
use App\Core\RouterCollection;
use App\Helper\Redirection;
use App\SessionHandler;

class ProductController
{
    /**
     * @param int $id
     * @param RouterCollection $routes
     * @param string $name
     * 
     */
	public function showAction(int $id, RouterCollection $routes):void
	{
        $product = new Product();
        $product->read($id);

        if (null === $product->getId()) {
            Redirection::error404();
        }

        require_once APP_ROOT . '/views/pages/product.php';
	}
}   