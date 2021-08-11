# Databases数据库支持

## 目录简介

```text
DatabaseServerPriovder.php---------数据库服务注册和启动
DB.php-----------------------------DB调用数据的静态封装
Driver
-----MysqlPoolManager.php----------mysql连接池的创建和管理  
-----MysqlDriverPool.php-----------基于连接池操作数据库的类 
-----MysqlDriverPdo.php------------基于mysql-pdo原生操作数据库的类  
```

## 为什么真实连接大于配置的数据库连接数量

在对数据库压测过程中，我们用 `SHOW PROCESSLIST;` 查看数据库的连接数量，会发现真实的连接远大于在配置文件中对于连接池的配置。  
因为在服务器中，darts 项目启动后，会根据服务器的核心数，启动对应数量的 [Worker](https://wiki.swoole.com/#/server/setting?id=worker_num) 进程，而每个 `Worker` 进程是相互独立的，如果服务器的核心数是 s，数据库进程池中配置的数量是 n，那么查询连接数是 s*n。服务器中查看 Worker 进程的命令是：`pstree -ap | grep darts`
