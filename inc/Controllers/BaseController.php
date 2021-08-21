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
    public $resources;


    public function __construct()
    {
        $this->app_name = "Sitemap Status";
        $this->app_root = $_SERVER['DOCUMENT_ROOT'];
        $this->app_url = $this->appURL();
        $this->resources = $this->assets();
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

    public function registerCSS()
    {
        $css = $this->resources['css'];
        $css_html = "<link rel='stylesheet' href='$this->app_url/$css'>";
        printf("\n%s\n",$css_html);
    }

    public function registerJS()
    {
        $js = $this->resources['js'];
        $js_html = "<script src='$this->app_url/$js'></script>";
        printf("\n%s\n", $js_html);
    }

    public function headerHTML()
    {
        require_once "$this->app_root/inc/Layout/header.php";
    }

    public function bodyHTML()
    {
        require_once "$this->app_root/inc/Layout/body.php";
    }

    public function  footerHTML()
    {
        require_once "$this->app_root/inc/Layout/footer.php";
    }

    private function assets()
    {
        $resources = [
            'css' => 'assets/css/bundle.css',
            'js' => 'assets/js/bundle.js'
        ];

        return $resources;
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
