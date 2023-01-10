<?php

namespace App\Core;

class Route {

    /**
     * @var string
     */
    private $path;

    /**
     * @var mixed
     */
    private $callable;

    /**
     * @var array
     */
    private $matches = [];

    /**
     * @var array
     */
    private $params = [];

    public function __construct($path, $callable) {
        $this->path = trim($path, '/');
        $this->callable = $callable;
    }

    /**
    * Permettra de capturer l'url avec les paramètre 
    * get('/posts/:slug-:id') par exemple
    *
    * @param string $url
    *
    * @return bool
    **/
    public function match(string $url) {
        $url = trim($url, '/');
        $path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->path);
        $regex = "#^$path$#i";
        
        if(!preg_match($regex, $url, $matches)) {
            return false;
        }
        
        array_shift($matches);
        $this->matches = $matches;

        return true;
    }
    
    /**
     * Match model url with given params
     * 
     * @param string $match
     * 
     * @return string
     */
    private function paramMatch($match) {
        if(isset($this->params[$match[1]])) {
            return '(' . $this->params[$match[1]] . ')';
        }
        return '([^/]+)';
    }

    /**
     * Dispatch given controller
     * 
     * @param array $params
     * 
     * @return mixed
     */
    private function dispatchController (array $params) {
        $controller = "App\\Controllers\\" . $params[0] . "Controller";
        $controller = new $controller();
        
        SessionHandler::setRoute('/' . BASE_URL . '/' . $this->setPath($this->matches));

        return call_user_func_array([$controller, $params[1]], $this->matches);
    }

    /**
     * Call valid controller
     * 
     * @param RouterCollection $services
     * 
     * @return mixed
     */
    public function call(RouterCollection $services) {
        array_push($this->matches, $services);

        try {
            if(is_string($this->callable)) {
                $params = explode('#', $this->callable);
                return $this->dispatchController($params);
            } else {
                return call_user_func_array($this->callable, $this->matches);
            }
        } catch (\Throwable $th) {
            return $this->dispatchController(['Error', 'indexAction']);
        }
    }

    /**
     * Path Getter
     * 
     * @return string
     */
    public function getPath () {
        return $this->path;
    }

    /**
     * Set valid path by replacing all :var by given value
     * 
     * @param array $params
     * 
     * @return string
     */
    public function setPath (array $params = []) {
        $newPath = $this->getPath();
        
        preg_match_all('/:[a-z0-9]+/i', $this->getPath(), $matches);
        
		for ($i = 0; $i < count($matches[0]); $i++) {
            $newPath = str_replace($matches[0][$i], $params[$i] ?? $matches[0][$i], $newPath);
        }
        
        return $newPath;
    }

}