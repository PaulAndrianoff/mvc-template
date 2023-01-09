<?php

/**
 * Use to get Style absolute path
 * 
 * @param string $style
 * 
 * @return string
 */
function getStyle (string $style):string {
    return ASSETS_URL . '/assets/' . STYLE_FOLDER . $style . '.css';
}

/**
 * Use to get Script absolute path
 * 
 * @param string $style
 * 
 * @return string
 */
function getScript (string $script):string {
    return ASSETS_URL . '/assets/' . SCRIPT_FOLDER . $script . '.js';
}

/**
 * Use to get Image absolute path
 * 
 * @param string $style
 * 
 * @return string
 */
function getImage (string $script):string {
    return ASSETS_URL . '/assets/' . IMAGE_FOLDER . $script;
}