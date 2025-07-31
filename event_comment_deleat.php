<?php
session_start();
require_once('db_connect.php');

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$comment_id = $_GET['id'];
$event_id = $_GET['event_id'];
$user_id = $_SESSION['user']['id'];
$is_admin = ($_SESSION['user']['role'] ?? '') === 'admin'; // 任意で後から

// コメント取得
$stmt = $pdo->prepare("SELECT * FROM event_comments WHERE id = ?");
$stmt->execute([$comment_id]);
$comment = $stmt->fetch();

// 投稿者か、管理者でなければ拒否
if (!$comment || ($comment['user_id'] != $user_id && !$is_admin)) {
    exit('削除権限がありません');
}

// 削除処理
$stmt = $pdo->prepare("DELETE FROM event_comments WHERE id = ?");
$stmt->execute([$comment_id]);

header("Location: event_detail.php?id=" . $event_id);
exit;
?>
