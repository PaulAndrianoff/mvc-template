<?php

namespace App\Helper;

use App\Core\SessionHandler;

/**
 * Here you find all functions for debugging
 */

class Redirection {
    /**
     * @return void
     */
    public static function error404 ():void
    {
        SessionHandler::resetRoute();
        self::goto('/404');
    }

    /**
     * @return void
     */
    public static function goto ($route):void
    {
        header("Location: /" .  constant('BASE_URL') . $route);
        exit();
    }
}