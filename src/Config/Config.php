<?php
namespace Dartswoole\Config;

use \Exception;

/**
 * 框架的配置文件处理，并进行加载
 */
class Config {

    protected $items = array();

    /**
     * 初始化把配置文件加载到 items
     *
     * @param $dir string 配置文件的文件夹路径
     */
    public function __construct($dir) {
        $this->itmes = $this->phpParser($dir);
    }

    /**
     * 读取路径下所有的php文件
     *
     * @param $dir string 配置文件的文件夹路径
     * @return array 文件信息
     */
    protected function phpParser($dir)
    {
        // 判断文件夹是否存在
        if(!is_dir($dir)) {
            throw new Exception("Not Found Dir Of Config Dic ({$dir})", 500);
        }
        // 读取文件夹下的文件
        $files = scandir($dir);

        $data = array();
        foreach ($files as $key => $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            // 获取文件名
            $filename = stristr($file, ".php", true);

            // 读取文件内容信息
            $data[$filename] = include $dir."/".$file;
        }

        return $data;
    }

    /**
     * 返回配置文件的定义值
     *
     * @param $keys string demo:key1.key2.key3
     * @return array|mixed 定义值
     */
    public function get($keys)
    {
        $data = $this->itmes;
        foreach (explode('.', $keys) as $key => $value) {
            $data = $data[$value];
        }
        return $data;
    }
}