<?php

namespace App\Core;

use App\Helper\Redirection;

use function App\Helper\d;
use function App\Helper\dd;

class Route {

    private $path;
    private $callable;
    private $matches = [];
    private $params = [];

    public function __construct($path, $callable){
        $this->path = trim($path, '/');  // On retire les / inutils
        $this->callable = $callable;
    }

    /**
    * Permettra de capturer l'url avec les paramètre 
    * get('/posts/:slug-:id') par exemple
    **/
    public function match($url){
        $url = trim($url, '/');
        $path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->path);
        $regex = "#^$path$#i";
        
        if(!preg_match($regex, $url, $matches)){
            return false;
        }
        
        array_shift($matches);
        $this->matches = $matches;
        return true;
    }
    
    private function paramMatch($match){
        if(isset($this->params[$match[1]])){
            return '(' . $this->params[$match[1]] . ')';
        }
        return '([^/]+)';
    }

    public function call($services){
        try {
            if(is_string($this->callable)){
                $params = explode('#', $this->callable);
                $controller = "App\\Controllers\\" . $params[0] . "Controller";
                $controller = new $controller();
    
                array_push($this->matches, $services);
                return call_user_func_array([$controller, $params[1]], $this->matches);
            } else {
                return call_user_func_array($this->callable, $this->matches);
            }
        } catch (\Throwable $th) {
            dd($th);
            // Redirection::error404();
        }
    }

    public function getUrl($params){
        $path = $this->path;
        foreach($params as $k => $v){
            $path = str_replace(":$k", $v, $path);
        }
        return $path;
    }

    public function getPath () {
        return $this->path;
    }

    public function setPath ($params = []) {
        $newPath = $this->getPath();
        
        preg_match_all('/:[a-z0-9]+/i', $this->getPath(), $matches);
        
		for ($i = 0; $i < count($matches[0]); $i++) {
            $newPath = str_replace($matches[0][$i], $params[$i] ?? $matches[0][$i], $newPath);
        }
        
        return $newPath;
    }

}