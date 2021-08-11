<?php
namespace Dartswoole\Database\Driver;

use PDO;

/**
 * 传统pdo查询数据库
 *
 * --------------------------------------------------------------------------
 * 采用传统的 PDO 的方式连接数据库
 * 即每次查询数据库都创建新的连接
 * --------------------------------------------------------------------------
 */
class MysqlDriverPdo {

    /**
     * 连接数据库驱动
     *
     * @var object PDO
     */
    private $pdo;

    public function __construct()
    {
        $config = app("config")->get("database.mysql");

        try {
            // 初始化执行数据库类
            $this->pdo = new PDO("mysql:host={$config['host']};dbname={$config['database']}", $config['username'], $config['password']);
            $this->pdo->query('SET NAMES UTF8');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException  $e) {
            // throw new \Exception($e->getMessage(), 500);
            return $e->getMessage();
        }
    }

    /**
     * 读操作
     *
     * @param $sql string sql语句
     * @return string|array
     */
    public function query($sql)
    {
        try {
            $result = $this->pdo->query($sql);
            $data = [];
            foreach($result as $key => $value){
                $data[] = $value;
            }
            return $data;
        } catch (PDOException  $e) {
            return $e->getMessage();
        }
    }

    public function call($sql, $select_param = null)
    {
        $stmt = $this->pdo->prepare($sql);
        if ($stmt->execute()) {
            if (isset($select_param)) {
                return $this->pdo->query($select_param)->fetchAll();
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * 写操作
     *
     * @param $sql string sql语句
     * @return string
     */
    public function execute($sql)
    {
        try {
            return $this->pdo->exec($sql);
        } catch (PDOException  $e) {
            return $e->getMessage();
        }
    }
}