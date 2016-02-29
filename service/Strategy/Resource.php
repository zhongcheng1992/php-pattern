<?php
/**
 * 资源处理类
 */
namespace Service\Strategy;

use Service\Pattern\Factory;

class Resource
{
    const API = 'https://api.douban.com/v2/%s/search?q=%s';

    public static function get_url_contents($url)
    {
        $cache = Factory::setCache('redis');

        if($content = $cache::get(md5($url))) {
            return $content;
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($curl, CURLOPT_URL,$url);
        $contents = curl_exec($curl);
        curl_close($curl);

        $cache::set(md5($url), $contents);
        if ($contents)
            return $contents;
        else
            return false;
    }
}