<?php
/**
 * 针对于电影搜索的策略
*/
namespace Service\Strategy;

use Service\Pattern\IStrategy;

class movieStrategy extends Resource implements IStrategy
{
    public $type = 'movie';

    public function search($name)
    {
        $url    = sprintf(self::API, $this->type, $name);
        $result = self::get_url_contents($url);
        $data   = json_decode($result, JSON_OBJECT_AS_ARRAY);
        $data   = [
            'title'             => $data['subjects'][0]['title'],
            'original_title'    => $data['subjects'][0]['original_title'],
            'rating'            => $data['subjects'][0]['rating']['average'],
            'id'                => $data['subjects'][0]['id'],
            'year'              => $data['subjects'][0]['year'],
            'alt'               => $data['subjects'][0]['alt'],
        ];
        print_r($data);
    }
}