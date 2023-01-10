<?php

namespace App\Core;

/**
 * Class use to handle session
 */
Class SessionHandler {

    /**
     * Function use to set variable in current session
     * 
     * @param string $sessionVariable
     * @param mixed $value
     */
    public static function set ($sessionVariable, $value) {
        $_SESSION[$sessionVariable] = $value;
    }

    /**
     * Function use to add current route to 'previous_url'
     * Do it if it's a valid and if it doesn't already exist
     * 
     * @param string $value
     */
    public static function setRoute ($value) {
        if (!self::exist('previous_url') || 'array' !== gettype($_SESSION['previous_url'])) {
            self::set('previous_url', []);
        }

        $regexRoute = '/\/' . BASE_URL . '\/[a-z0-9\/\-:]*$/i';
        $regexRoute404 = '/\/' . BASE_URL . '\/404$/i';
        if (
            preg_match($regexRoute, $value) &&
            !preg_match($regexRoute404, $value) &&
            !in_array($value, $_SESSION['previous_url'])
        ) {
            array_push($_SESSION['previous_url'], $value);
        }
    }

    /**
     * Function use to reset 'previous_url'
     * 
     * @param string $sessionVariable
     */
    public static function resetRoute () {
        self::set('previous_url', ['/' . BASE_URL . '/']);
    }

    /**
     * Function use to retrieve a variable in current session
     * 
     * @param string $sessionVariable
     * 
     * @return mixed
     */
    public static function get ($sessionVariable) {
        return self::exist($_SESSION[$sessionVariable]) ?? null;
    }

    /**
     * Function use to check if variable exist in current session
     * 
     * @param string $sessionVariable
     * 
     * @return bool
     */
    public static function exist ($sessionVariable) {
        return isset($_SESSION[$sessionVariable]);
    }
}