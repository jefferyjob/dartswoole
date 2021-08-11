# Darts Library

## 概述

Library 类库

## Framework

https://github.com/jefferyjob/darts

## 提供支持

- 路由的解析与处理
- event事件的绑定与处理
- Swoole的http服务的实现
- 基于consule实现独立的RPC服务
- 基于Swoole实现RPC客户端和服务端

## 目录简介

```text
src
-----App-----------------核心服务  
-----Container-----------容器服务  
-----Priovder------------服务提供者抽象类定义
-----Config--------------配置解析处理
-----Help----------------类库的调试帮助函数
-----Event---------------事件绑定的解析与处理
-----Database------------数据库支持
-----Routes--------------路由解析与处理
-----Consul--------------consul实现RPC服务
-----Rpc-----------------RPC服务实现
-----SwooleServer--------swoole实现http等服务
test  
-----xxxxxx--------------测试文件 
```

## License

遵循 MIT 许可证，有关详细，请参阅 LICENSE。
