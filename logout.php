<?php
session_start();
$_SESSION = array(); // セッション変数を空にする
session_destroy();   // セッションを完全に破棄

// ログイン画面にリダイレクト
header("Location: login.php");
exit();

