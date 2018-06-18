<?php
/**
 * Created by PhpStorm.
 * User: web
 * Date: 10.05.2018
 * Time: 15:25
 */

class DB
{
    private static $instance;

    private function __constructor(){}

    public static function getInstance()
    {
        if(self::$instance) {
            return self::$instance;
        }

        return self::$instance = new mysqli('ip', 'user' ,'passw', 'dbname');
    }
}