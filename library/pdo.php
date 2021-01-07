<?php

$mysqlConf = config('databases.mysql');
$dbms = 'mysql';     //数据库类型
$host = $mysqlConf['host']; //数据库主机名
$dbName = $mysqlConf['database'];    //使用的数据库
$user = $mysqlConf['username'];      //数据库连接用户名
$pass = $mysqlConf['password'];          //对应的密码
$dsn = "$dbms:host=$host;dbname=$dbName";

try {
    $dbh = new PDO($dsn, $user, $pass, [PDO::ATTR_PERSISTENT => true]); //初始化一个PDO对象
} catch (PDOException $e) {
    write_log("PDOError!: " . $e->getMessage());
    die ("PDOError!: " . $e->getMessage() . "<br/>");
}