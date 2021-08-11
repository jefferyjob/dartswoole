<?php
namespace Dartswoole\Database\Driver;

/**
 * 用进程池连接查询数据库
 *
 * --------------------------------------------------------------------------
 * 采用传统的 PDO 的方式连接数据库
 * 即每次查询数据库都创建新的连接
 * --------------------------------------------------------------------------
 */
class MysqlDriverPool
{
    /**
     * @var object 数据库连接池
     */
    protected $pool;

    public function __construct($pool)
    {
        $this->pool = $pool;
    }

    /**
     * 获取连接池中的某一个连接
     *
     * @return mixed
     */
    public function connection()
    {
        return $this->pool->get();
    }

    /**
     * 回收连接
     *
     * @param $pdo
     */
    public function put($pdo)
    {
        $this->pool->put($pdo);
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
            // 获取连接
            $pdo = $this->connection();

            // 执行查询
            $return = $pdo->query($sql)->fetchAll();// fetch 或 fetchAll()

            // 回收连接
            $this->put($pdo);

            return $return;
        } catch (PDOException  $e) {
            // 程序异常 连接池重置
            $this->put(null);
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