<?php
session_start();
require_once('db_connect.php');

// 管理者かチェック
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: admin_login.php");
    exit;
}

// POSTされた投稿IDを取得
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];

    // まずその投稿に紐づく「コメント」も削除（外部キー制約がある場合もあるので）
    $delete_comments = $pdo->prepare("DELETE FROM comments WHERE post_id = :post_id");
    $delete_comments->bindValue(':post_id', $post_id, PDO::PARAM_INT);
    $delete_comments->execute();

    // 投稿削除
    $delete_post = $pdo->prepare("DELETE FROM posts WHERE id = :post_id");
    $delete_post->bindValue(':post_id', $post_id, PDO::PARAM_INT);
    $delete_post->execute();
}

// 削除後はダッシュボードに戻る
header("Location: admin_dashboard.php");
exit;
