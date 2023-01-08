<?php

namespace App\Helper;

/**
 * Dump given variable and die
 * 
 * @return void
 */
function dd ():void
{
    if ('dev' !== ENV) {
        return;
    }
    echo '<pre class="xdebug-var-dump">';
    array_map(function ($x) {
        var_dump($x);
    }, func_get_args());
    echo '</pre>';
    die;
}

/**
 * Dump given variable
 * 
 * @return void
 */
function d ():void
{
    if ('dev' !== ENV) {
        return;
    }
    echo '<pre class="xdebug-var-dump">';
    array_map(function ($x) {
        var_dump($x);
    }, func_get_args());
    echo '</pre>';
}