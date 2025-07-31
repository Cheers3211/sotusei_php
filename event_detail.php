<?php
session_start();
require_once('db_connect.php');

$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;

if (!isset($_GET['id'])) {
  echo "イベントIDが指定されていません。";
  exit;
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM events WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$event = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$event) {
  echo "イベントが見つかりませんでした。";
  exit;
}

// 参加結果メッセージ
$join_message = '';
if (isset($_GET['joined'])) {
  if ($_GET['joined'] === 'success') {
    $join_message = '✅ イベント参加が完了しました！';
  } elseif ($_GET['joined'] === 'already') {
    $join_message = '⚠️ すでにこのイベントに参加済みです。';
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($event['title']) ?> - セラノア</title>
  <style>
    body {
      font-family: 'Noto Sans JP', sans-serif;
      background: #f9fafe;
      color: #333;
      padding: 40px 20px;
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
      margin-bottom: 10px;
    }
    .date {
      font-size: 0.95em;
      color: gray;
      margin-bottom: 20px;
    }
    .description {
      font-size: 1.1em;
      line-height: 1.8;
      margin-bottom: 30px;
    }
    .login-info {
      background: #eef6ff;
      padding: 20px;
      border-radius: 10px;
      margin-bottom: 20px;
    }
    .join-button {
      display: inline-block;
      padding: 10px 24px;
      background: #007ACC;
      color: white;
      text-decoration: none;
      font-weight: bold;
      border-radius: 8px;
    }
    .join-button:hover {
      background: #005f99;
    }
    .join-message {
      background: #e6f7e9;
      border: 1px solid #93d9a3;
      padding: 12px;
      margin-bottom: 20px;
      border-radius: 6px;
      color: #2a6f39;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1><?= htmlspecialchars($event['title']) ?></h1>
    <div class="date">開催日：<?= htmlspecialchars($event['event_date']) ?></div>

    <?php if ($join_message): ?>
      <div class="join-message"><?= $join_message ?></div>
    <?php endif; ?>

    <div class="description">
      <?= nl2br(htmlspecialchars($event['description'])) ?>
    </div>

    <?php if ($user): ?>
      <section>
        <h2>📌 詳細情報（ログイン済みのみ表示）</h2>
        <ul>
          <li>講師：<?= htmlspecialchars($event['speaker'] ?? '未定') ?></li>
          <li>募集人数：<?= htmlspecialchars($event['capacity'] ?? '制限なし') ?>名</li>
          <li>場所：<?= htmlspecialchars($event['location'] ?? 'オンライン') ?></li>
        </ul>
        <a href="event_join.php?id=<?= $event['id'] ?>" class="join-button">このイベントに参加する</a>
      </section>
    <?php else: ?>
      <div class="login-info">
        このイベントの詳細を見るにはログインが必要です。<br>
        <a href="login.php">ログインする</a> または <a href="register.php">新規登録する</a>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>
