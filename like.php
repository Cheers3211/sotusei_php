<?php
session_start();
require_once('db_connect.php');

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = $_POST['post_id'];

    // すでにいいねしていないかチェック
    $sql = "SELECT * FROM likes WHERE post_id = :post_id AND user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
    $stmt->bindValue(':user_id', $user['id'], PDO::PARAM_INT);
    $stmt->execute();

    if (!$stmt->fetch()) {
        // 新しく「いいね」追加
        $insert_sql = "INSERT INTO likes (post_id, user_id) VALUES (:post_id, :user_id)";
        $insert_stmt = $pdo->prepare($insert_sql);
        $insert_stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
        $insert_stmt->bindValue(':user_id', $user['id'], PDO::PARAM_INT);
        $insert_stmt->execute();
    }
}

header("Location: timeline.php");
exit;
