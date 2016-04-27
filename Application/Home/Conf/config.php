<?php
return [
        'DB_TYPE'               =>  'mysqli',     // 数据库类型
        'DB_HOST'               =>  'localhost', // 服务器地址
        'DB_NAME'               =>  'memory',          // 数据库名
        'DB_USER'               =>  'root',      // 用户名
        'DB_PWD'                =>  '279714573',          // 密码
        'DB_PORT'               =>  '3306',        // 端口
        'DB_PREFIX'             =>  '',    // 数据库表前缀
        'DB_PARAMS'=> array(PDO::ATTR_CASE => \PDO::CASE_NATURAL), //不需要自动转换大小写
    ];