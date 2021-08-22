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
        $array = self::parse($file);
        self::statuscode($array);
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

        if (file_exists($base)) {
            $sitemap_object = simplexml_load_file($base);
        }

        foreach ($sitemap_object->url as $loc) {
            $array[] = $loc;
        }

        // echo "<pre>";
        // var_dump($array);
        // echo "</pre>";

        return $array;
    }

    private static function statuscode($array)
    {

        foreach ($array as $obj) {
            $urls[] = (string) $obj->loc;
        }

        $config =[ 
           'useragent' => 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'        
        ];

        $options = [
            CURLOPT_HEADER => true, 
            CURLOPT_NOBODY => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => $config['useragent']
        ];

        $mh = curl_multi_init();
        $chs = [];


        foreach ($urls as $url) {

            $ch = curl_init($url);
            curl_setopt_array($ch, $options);
            curl_multi_add_handle($mh, $ch);
            $chs[] = $ch;
        }

        $running = false;

        do {
            curl_multi_exec($mh, $running);
        } while ($running);

        foreach ($chs as $h) {

            curl_multi_remove_handle($mh, $h);
        }

        curl_multi_close($mh);

        foreach ($chs as $h) {

            if (!curl_errno($h)) {
                $info[] = curl_getinfo($h);
            }
        }

        // echo "<pre>";
        // print_r($info);
        // echo "</pre>";

        $count = 0;

        foreach($info as $in)
        {
            $result[$count]['loc'] = $in['url'];
            $result[$count]['status_code'] = $in['http_code'];
            $result[$count]['primary_ip'] = $in['primary_ip'];
            if($in['http_code'] === 301 || $in['http_code'] === 302)
            {
                $result[$count]['redirect_url'] = $in['redirect_url'];
            }
            $count++;
        }

        echo "<pre>";
        print_r($result);
        echo "</pre>";

        // foreach ($chs as $h) {

        //     echo "----------------------\n";
        //     echo curl_multi_getcontent($h);
        // }
    }
}
