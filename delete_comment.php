<?php
session_start();
require_once('db_connect.php');

// 管理者チェック

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user']['id'];
$event_id = $_POST['event_id'];
$comment = $_POST['comment'];

$stmt = $pdo->prepare("INSERT INTO event_comments (event_id, user_id, comment) VALUES (?, ?, ?)");
$stmt->execute([$event_id, $user_id, $comment]);

header("Location: event_detail.php?id=" . $event_id);
exit;
?>







// POSTでコメントIDが送られてきたら削除
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment_id'])) {
    $comment_id = $_POST['comment_id'];

    $delete = $pdo->prepare("DELETE FROM comments WHERE id = :comment_id");
    $delete->bindValue(':comment_id', $comment_id, PDO::PARAM_INT);
    $delete->execute();
}

// 削除後に戻る
header("Location: admin_dashboard.php");
exit;
