<?php
namespace Dartswoole\Help;

class Debug {

    /**
     * 输出调试信息
     *
     * @return mixed
     */
    static public function dd($param = null) {
        self::info("=====================================================");
        if(is_array($param)) {
            print_r($param);
        } else if(is_string($param)) {
            echo $param;
        } else {
            var_dump($param);
        }
        self::info("=====================================================");
    }

    /**
     * 彩色调试信息
     *
     * @param $string
     */
    public static function info($string) {
        echo PHP_EOL.ColorString::getColoredString($string, 'green').PHP_EOL;
    }
    public static function warn($string) {
        echo PHP_EOL.ColorString::getColoredString($string, 'black', 'yellow').PHP_EOL;
    }
    public static function error($string) {
        echo PHP_EOL.ColorString::getColoredString($string, 'white', 'red').PHP_EOL;
        die;
    }

}