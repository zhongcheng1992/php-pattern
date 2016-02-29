<?php
/**
 * 文件缓存类
 */
namespace Service\Cache;

class File
{
    /**
     * FILEPATH 缓存路径
    */
    const FILEPATH = '../cache';


    /**
     * 读取缓存文件内容
     * @param $filename string 缓存文件名
     * @return bool|string 返回缓存内容或false
     */
    public static function get($filename)
    {
        $file = self::cachefile($filename);

        if(!file_exists($file)) {
            return false;
        }

        return file_get_contents($file);
    }

    /**
     * 生成缓存文件
     * @param $filename string 缓存文件名
     * @param $content string 缓存内容
     * @return bool
     */
    public static function set($filename, $content)
    {
        if(!is_dir(self::FILEPATH)) {
            mkdir(self::FILEPATH);
        }

        $file = self::cachefile($filename);

        $fp = fopen($file, 'w');
        fwrite($fp, $content);
        return fclose($fp);
    }


    /**
     * 生成缓存文件路径
     * @param $filename string 缓存文件名
     * @return string 完整的文件路径
     */
    private static function cachefile($filename)
    {
        return realpath(self::FILEPATH) . DIRECTORY_SEPARATOR . $filename . '.json';
    }

}
