<?php 

namespace App\Core;

use App\Core\Route;
use App\Core\RouterCollection;
use App\Helper\Redirection;

use function App\Helper\d;

class Router {

    /**
     * @var string
     */
    private $url;

    /**
     * @var array
     */
    private $routes = [];

    /**
     * @var array
     */
    private $namedRoutes = [];

    public function __construct($url) {
        $this->url = $url;
    }

    /**
     * @param string $path
     * @param string $callable
     * @param string $name
     * 
     * @return Route
     */
    public function get($path, $callable, $name = null) {
        return $this->add($path, $callable, $name, 'GET');
    }

    /**
     * @param string $path
     * @param string $callable
     * @param string $name
     * 
     * @return Route
     */
    public function post($path, $callable, $name = null) {
        return $this->add($path, $callable, $name, 'POST');
    }

    /**
     * @param string $path
     * @param string $callable
     * @param string $name
     * @param string $method
     * 
     * @return Route
     */
    private function add($path, $callable, $name, $method) {
        $route = new Route($path, $callable);
        $this->routes[$method][] = $route;
        if(is_string($callable) && $name === null) {
            $name = $callable;
        }
        if($name) {
            $this->namedRoutes[$name] = $route;
        }
        return $route;
    }

    /**
     * @param Router
     * 
     * @return mixed
     */
    public function run($routeCollection) {
        if(!isset($this->routes[$_SERVER['REQUEST_METHOD']])) {
            d('REQUEST_METHOD does not exist');
        }
        foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
            if($route->match($this->url)) {
                return $route->call(new RouterCollection ($routeCollection));
            }
        }
        d('No matching routes');
        Redirection::error404();
    }

    /**
     * @param string $name
     * @param array $params
     * 
     * @return string
     */
    public function url($name, $params = []) {
        if(!isset($this->namedRoutes[$name])) {
            d('No route matches this name');
        }
        
        return $this->namedRoutes[$name]->getUrl($params);
    }

    /**
     * @return array
     */
    public function getRoutes () {
        return $this->routes;
    }

    /**
     * @return array
     */
    public function getNamedRoutes () {
        return $this->namedRoutes;
    }

}