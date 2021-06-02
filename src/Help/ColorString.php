<?php
namespace Dartswoole\Help;

class ColorString
{

    private static $foregroundColors = array(
        'black' => '0;30',
        'dark_gray' => '1;30',
        'blue' => '0;34',
        'light_blue' => '1;34',
        'green' => '0;32',
        'light_green' => '1;32',
        'cyan' => '0;36',
        'light_cyan' => '1;36',
        'red' => '0;31',
        'light_red' => '1;31',
        'purple' => '0;35',
        'light_purple' => '1;35',
        'brown' => '0;33',
        'yellow' => '1;33',
        'light_gray' => '0;37',
        'white' => '1;37',
    );
    private static $backgroundColors = array(
        'black' => '40',
        'red' => '41',
        'green' => '42',
        'yellow' => '43',
        'blue' => '44',
        'magenta' => '45',
        'cyan' => '46',
        'light_gray' => '47',
    );

    public static function getColoredString($string, $foregroundColor = null, $backgroundColor = null)
    {
        $coloredString = "";

        if (isset(static::$foregroundColors[$foregroundColor])) {
            $coloredString .= "\033[" . static::$foregroundColors[$foregroundColor] . "m";
        }
        if (isset(static::$backgroundColors[$backgroundColor])) {
            $coloredString .= "\033[" . static::$backgroundColors[$backgroundColor] . "m";
        }

        $coloredString .= $string . "\033[0m";

        return $coloredString;
    }

    public static function getForegroundColors()
    {
        return array_keys(static::coregroundColors);
    }

    public static function getBackgroundColors()
    {
        return array_keys(static::backgroundColors);
    }

}