<?php

/**
 * Class Utils contains functions that are used often within the app
 * 
 * Author: Lukas Velek
 * Version: 2022/8/16
 */
class Utils {
    /**
     * Useless constructor
     */
    function __construct() {}

    /**
     * Creates a token (random set of numbers and letters) with given length and returns it
     */
    function create_token($length) {
        $cs = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    
        $r = "";
    
        for($i = 0; $i < $length; $i++) {
            $x = rand(0, strlen($cs) - 1);
    
            $r = $r . $cs[$x];
        }
    
        return $r;
    }

    /**
     * Returns value of $_GET with given name
     */
    function get($name) {
        return htmlspecialchars($_GET[$name]);
    }

    /**
     * Return vales of $_POST with given name
     */
    function post($name) {
        return htmlspecialchars($_POST[$name]);
    }
}

?>