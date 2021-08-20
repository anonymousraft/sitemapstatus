<?php

/**
 * @package Project
 */

namespace Inc;

use Inc\Controllers\BaseController;
use Pecee\SimpleRouter\SimpleRouter;

final class Init{
    public static $routes;
    public static function start(){

        self::errorShow();

        self::$routes = new BaseController();
        self::$routes->routeFile();
        SimpleRouter::start();
    }

    public static function errorShow()
    {
        /**
         * Errors
         */
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}