<?php
namespace Dartswoole\SwooleServer;
/**
 * 数据返回处理类
 *
 * Class Reponse
 * @package Dartswoole\SwooleServer
 */
class Reponse
{
    static public function send($data)
    {
        if(is_array($data)) {
            return json_encode($data);
        } else if(is_string($data)) {
            return $data;
        } else {
            return $data;
        }
    }
}