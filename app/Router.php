<?php 

namespace App;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use App\SessionHandler;

class Router
{

    /**
     * @param RouteCollection $routes
     * @param object $matcher
     * @param string $route
     */
    public function findController (RouteCollection $routes, object $matcher, string $route):void
    {
        $matcher = $matcher->match($route);

        // Cast params to int if numeric
        array_walk($matcher, function(&$param)
        {
            if(is_numeric($param)) 
            {
                $param = (int) $param;
            }
        });
        
        $className = '\\App\\Controllers\\' . $matcher['controller'];
        $classInstance = new $className();
        
        $params = array_merge(array_slice($matcher, 2, -1), array('routes' => $routes));

        call_user_func_array(array($classInstance, $matcher['method']), $params);
    }

    /**
     * @param RouteCollection $routes
     */
    public function __invoke(RouteCollection $routes):void
    {
        $context = new RequestContext();
        $request = Request::createFromGlobals();
        $context->fromRequest($request);
        
        $matcher = new UrlMatcher($routes, $context);
        SessionHandler::setRoute($_SERVER['REQUEST_URI']);
        
        try {
            $arrayUri = explode('?', $_SERVER['REQUEST_URI']);
            $this->findController($routes, $matcher, $arrayUri[0]);
        } catch (\Throwable $e) {
            if (DEBUG) {
                echo '<pre>';
                print_r($e);
            } else {
                require_once APP_ROOT . '/views/pages/error404.php';
            }
        }
    }
}

// Invoke
$router = new Router();
$router($routes);