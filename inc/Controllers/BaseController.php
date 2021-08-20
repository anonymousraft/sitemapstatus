<?php

/*
* @package Sitemap Status
*/

namespace Inc\Controllers;

class BaseController
{

    public $app_name;
    public $app_url;
    public $app_root;


    public function __construct()
    {
        $this->app_name = "Sitemap Status";
        $this->app_root = $_SERVER['DOCUMENT_ROOT'];
        $this->app_url = $this->appURL();
    }

    private function appURL()
    {
        $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ?
            "https" : "http") . "://" . $_SERVER['HTTP_HOST'];

        return $link;
    }

    public function routeFile()
    {
        require_once "$this->app_root/inc/Routes/Routes.php";
    }

    public function helperFile()
    {
        require_once "$this->app_root/inc/Routes/Helpers.php";
    }

    public function registerHeaderScripts()
    {
        // require_once "$this->app_root/inc/Routes/header.php";
    }

    public function bodyHTML()
    {
        // require_once "$this->app_root/assets/layouts/body.php";
    }

    public function  registerFooterScripts()
    {
        // require_once "$this->app_root/assets/layouts/footer.php";
    }

    public function pageTitles()
    {
        $this->page_titles = [
            'home' => 'Bulk Whois Checker 2.0 by Hitendra',
            'results' => 'Results...',
            'dnscheck' => 'Check DNS Records'
        ];
    }

    public function debug($var)
    {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
        exit;
    }
}
