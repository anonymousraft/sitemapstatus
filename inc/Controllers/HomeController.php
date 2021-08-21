<?php

/**
 * @package sitemapstatus
 * Homepage Controller
 */

namespace Inc\Controllers;

use Inc\Views\HomeView;
use Inc\Controllers\BaseController;

class HomeController
{

    public static $home;
    public static $base;

    public static function start()
    {
        self::$home = new HomeView();
    }

    public static function form(string $url)
    {
        $file = self::download($url);
        self::parse($file);

    }

    private static function download(string $sitemap)
    {
        self::$base = new BaseController();
        $app_root = self::$base->app_root;

        $save = "$app_root/sitemap/sitemap.xml";

        $fp = fopen($save, 'w+');


        //Create a cURL handle.
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $sitemap);

        //Pass our file handle to cURL.
        curl_setopt($ch, CURLOPT_FILE, $fp);

        //Timeout if the file doesn't download after 20 seconds.
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);

        //Execute the request.
        curl_exec($ch);

        //If there was an error, throw an Exception
        if (curl_errno($ch)) {
            throw new \Exception(curl_error($ch));
        }

        //Get the HTTP status code.
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        //Close the cURL handler.
        curl_close($ch);

        //Close the file handler.
        fclose($fp);

        return $save;
    }

    public static function parse(string $base)
    {        
    
        if(file_exists($base))
        {            
            $sitemap_object = simplexml_load_file($base);
        }      

        foreach($sitemap_object->url as $loc)
        {
            $array[] = $loc; 
        }

        // echo "<pre>";
        // var_dump($array);
        // echo "</pre>";

        foreach($array as $obj)
        {
            echo $obj->loc;
        }
       
    }

}
