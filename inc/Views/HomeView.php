<?php

/**
 * @package sitemapstatus
 * Homepage Controller
 */

namespace Inc\Views;

use Inc\Controllers\BaseController;

class HomeView
{
    private $base;

    public function __construct()
    {
        $this->base = new BaseController();
        $this->base->headerHTML();
        $this->base->registerCSS();
        $this->base->bodyHTML();
        $this->layout();
        $this->base->registerJS();
        $this->base->footerHTML();
    }

    private function layout()
    {
        $root = (string) $this->base->app_root;
        require_once "$root/inc/Layout/home.php";
    }
}
