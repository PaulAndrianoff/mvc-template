<?php 

namespace App\Core;

use App\Core\Route;
use App\Core\RouterCollection;
use App\Helper\Redirection;

use function App\Helper\d;

class Router {

    private $url;
    private $routes = [];
    private $namedRoutes = [];

    public function __construct($url){
        $this->url = $url;
    }

    public function get($path, $callable, $name = null){
        return $this->add($path, $callable, $name, 'GET');
    }

    public function post($path, $callable, $name = null){
        return $this->add($path, $callable, $name, 'POST');
    }

    private function add($path, $callable, $name, $method){
        $route = new Route($path, $callable);
        $this->routes[$method][] = $route;
        if(is_string($callable) && $name === null){
            $name = $callable;
        }
        if($name){
            $this->namedRoutes[$name] = $route;
        }
        return $route;
    }

    public function run($routeCollection){
        if(!isset($this->routes[$_SERVER['REQUEST_METHOD']])){
            d('REQUEST_METHOD does not exist');
        }
        foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $route){
            if($route->match($this->url)){
                return $route->call(new RouterCollection ($routeCollection));
            }
        }
        d('No matching routes');
        Redirection::error404();
    }

    public function url($name, $params = []){
        if(!isset($this->namedRoutes[$name])){
            // throw new RouterException('No route matches this name');
            d('No route matches this name');
        }
        
        return $this->namedRoutes[$name]->getUrl($params);
    }

    public function getRoutes () {
        return $this->routes;
    }

    public function getNamedRoutes () {
        return $this->namedRoutes;
    }

}