<?php

define('DB_DSN', 'mysql:dbname=inventory;host=localhost02;port=3306'); //資料庫連線字串
define('DB_USER', 'root'); //資料庫使用者
define('DB_PASSWORD',''); //資料庫使用者密碼
//資料庫連接
$options = [
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
];

try {
    $pdo = new PDO(DB_DSN, DB_USER, DB_PASSWORD, $options);
    '資料庫連線成功。';
} catch (PDOException $e) {
    echo '資料庫連線失敗。';
}

?>
