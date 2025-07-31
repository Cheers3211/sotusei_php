<?php
session_start();
require_once('db_connect.php');

// ログインチェック
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = $_POST['post_id'];
    $comment = $_POST['comment'];

    if (!empty($comment)) {
        $sql = "INSERT INTO comments (post_id, user_id, comment)
                VALUES (:post_id, :user_id, :comment)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $user['id'], PDO::PARAM_INT);
        $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
        $stmt->execute();
    }
}

header("Location: timeline.php");
exit;
