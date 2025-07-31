<?php
session_start();
require_once('db_connect.php');

// ユーザー情報（ログインしていれば格納）
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;

// イベント一覧取得
$sql = "SELECT * FROM events ORDER BY event_date ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>イベント一覧 - セラノア</title>
  <style>
    body {
      font-family: 'Noto Sans JP', sans-serif;
      background-color: #f7f9fc;
      padding: 40px 20px;
      color: #333;
    }
    h1 {
      text-align: center;
      color: #007ACC;
      margin-bottom: 30px;
    }
    .event {
      background: white;
      margin: 20px auto;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
      max-width: 700px;
    }
    .event-title {
      font-size: 1.4em;
      font-weight: bold;
      margin-bottom: 8px;
      color: #007ACC;
    }
    .event-date {
      font-size: 0.95em;
      color: gray;
      margin-bottom: 10px;
    }
    .event-detail {
      margin-bottom: 15px;
    }
    .join-button {
      display: inline-block;
      padding: 8px 16px;
      background-color: #007ACC;
      color: white;
      text-decoration: none;
      border-radius: 6px;
      font-weight: bold;
      transition: background-color 0.3s;
    }
    .join-button:hover {
      background-color: #005f99;
    }
    .login-notice {
      text-align: center;
      margin-top: 20px;
      color: #666;
    }
  </style>
</head>
<body>
  <h1>セラノアのイベント一覧</h1>

  <?php foreach ($events as $event): ?>
    <div class="event">
      <div class="event-title">
        <a href="event_detail.php?id=<?= $event['id'] ?>">
          <?= htmlspecialchars($event['title']) ?>
        </a>
      </div>
      <div class="event-date">
        開催日: <?= htmlspecialchars($event['event_date']) ?>
      </div>
      <div class="event-detail">
        <?= nl2br(htmlspecialchars($event['description'])) ?>
      </div>

      <?php if ($user): ?>
        <a class="join-button" href="event_join.php?id=<?= $event['id'] ?>">イベントに参加する</a>
      <?php else: ?>
        <div class="login-notice">※ 参加するにはログインが必要です</div>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
</body>
</html>

