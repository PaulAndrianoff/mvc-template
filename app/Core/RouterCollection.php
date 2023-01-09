<?php

namespace App\Core;

class RouterCollection {
    private $collection = [];

    public function __construct($collection){
        $this->collection = $collection;
    }

    public function get ($route) {
        return $this->collection[$route] ?? null;
    }
}