<?php
session_start();
require_once('db_connect.php');

if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit;
}

$user = $_SESSION['user'];
$user_id = $user['id'];

// 参加済みイベント取得
$sql = "SELECT e.id, e.title, e.event_date FROM event_participants ep JOIN events e ON ep.event_id = e.id WHERE ep.user_id = :user_id ORDER BY e.event_date DESC";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$joined_events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>マイページ - セラノア</title>
  <style>
    body {
      font-family: 'Noto Sans JP', sans-serif;
      background: #f7f9fc;
      padding: 40px 20px;
      color: #333;
    }
    .container {
      max-width: 800px;
      margin: auto;
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }
    h1 {
      color: #007ACC;
      font-size: 1.8em;
      margin-bottom: 20px;
    }
    .event-list {
      margin-top: 30px;
    }
    .event-item {
      background: #f0f7fc;
      padding: 15px;
      margin-bottom: 12px;
      border-radius: 8px;
    }
    .event-title {
      font-weight: bold;
      font-size: 1.1em;
      color: #007ACC;
    }
    .event-date {
      font-size: 0.95em;
      color: gray;
    }
    .event-link {
      display: inline-block;
      margin-top: 6px;
      font-size: 0.95em;
      text-decoration: none;
      color: #007ACC;
    }
    .event-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>マイページ（<?= htmlspecialchars($user['name']) ?> さん）</h1>

    <div class="event-list">
      <h2>📅 参加したイベント</h2>
      <?php if (count($joined_events) > 0): ?>
        <?php foreach ($joined_events as $event): ?>
          <div class="event-item">
            <div class="event-title"><?= htmlspecialchars($event['title']) ?></div>
            <div class="event-date">開催日：<?= htmlspecialchars($event['event_date']) ?></div>
            <a class="event-link" href="event_detail.php?id=<?= $event['id'] ?>">▶ 詳細を見る</a>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>まだイベントに参加していません。</p>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>

