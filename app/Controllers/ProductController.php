<?php 

namespace App\Controllers;

use App\Models\Product;
use Symfony\Component\Routing\RouteCollection;
use App\Helper\Redirection;
use App\SessionHandler;

use function App\Helper\dd;

class ProductController
{
    /**
     * @param int $id
     * @param RouteCollection $routes
     */
	public function showAction(int $id, RouteCollection $routes):void
	{
        $product = new Product();
        $product->read($id);
        dd($product);

        if (null === $product->getId()) {
            Redirection::error404();
        }

        require_once APP_ROOT . '/views/pages/product.php';
	}
}   