<?php
// DB接続
try {

    $db_name = '';
    $db_host = '';
    $db_id = '';
    $db_pw = '';

    $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
} catch (PDOException $e) {
    exit('DB Connection Error:' . $e->getMessage());
}
