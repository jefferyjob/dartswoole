<?php
namespace Src\Help;

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
    private static function info($string) {
        echo ColorString::getColoredString($string, 'black', 'green');
    }
    private static function warn($string) {
        echo ColorString::getColoredString($string, 'black', 'yellow');
    }
    private static function error($string) {
        echo ColorString::getColoredString($string, 'white', 'red');
    }

}