<?php
namespace Dartswoole\Help;

class Debug {

    /**
     * 输出调试信息
     *
     * @return mixed
     */
    static public function dd($param = null) {
        self::info(PHP_EOL."===Debug-start===================");
        if(is_array($param)) {
            print_r($param);
        } else if(is_string($param)) {
            echo $param;
        } else {
            var_dump($param);
        }
        self::info(PHP_EOL."===Debug-end=====================");
    }

    /**
     * 彩色调试信息
     *
     * @param $string
     */
    public static function info($string) {
        echo ColorString::getColoredString($string, 'green').PHP_EOL;
    }
    public static function warn($string) {
        echo ColorString::getColoredString($string, 'black', 'yellow').PHP_EOL;
    }
    public static function error($string) {
        echo ColorString::getColoredString($string, 'white', 'red').PHP_EOL;
        die;
    }

}