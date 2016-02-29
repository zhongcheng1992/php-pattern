<?php
/**
 * 针对于图书搜索的策略
*/
namespace Service\Strategy;

use Service\Pattern\IStrategy;

class bookStrategy extends Resource implements IStrategy
{
    public $type = 'book';

    public function search($name)
    {
        $url    = sprintf(self::API, $this->type, $name);
        $result = self::get_url_contents($url);
        $data   = json_decode($result, JSON_OBJECT_AS_ARRAY);

        $data   = [
            'title'     => $data['books'][0]['title'],
            'subtitle'  => $data['books'][0]['subtitle'],
            'publisher' => $data['books'][0]['publisher'],
            'isbn'      => $data['books'][0]['isbn13'],
            'alt'       => $data['books'][0]['alt'],
        ];
        print_r($data);
    }

}