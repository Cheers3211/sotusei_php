<?php
session_start();
require_once('db_connect.php');

if (!isset($_SESSION['user'])) {
  header('Location: login.php');
  exit;
}

$user_id = $_SESSION['user']['id'];
$event_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// 二重登録チェック
$sql_check = "SELECT COUNT(*) FROM event_participants WHERE event_id = :event_id AND user_id = :user_id";
$stmt_check = $pdo->prepare($sql_check);
$stmt_check->bindValue(':event_id', $event_id, PDO::PARAM_INT);
$stmt_check->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt_check->execute();
$count = $stmt_check->fetchColumn();

if ($count > 0) {
  // すでに参加済み
  header("Location: event_detail.php?id=$event_id&joined=already");
  exit;
}

// 参加登録
$sql = "INSERT INTO event_participants (event_id, user_id, joined_at) VALUES (:event_id, :user_id, NOW())";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':event_id', $event_id, PDO::PARAM_INT);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();

header("Location: event_detail.php?id=$event_id&joined=success");
exit;
?>
