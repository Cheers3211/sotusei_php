<?php
session_start();
require_once('db_connect.php');

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $event_date = $_POST['event_date'];
    $type = $_POST['type'];
    $user_id = $_SESSION['user']['id'];

    if (!isset($_POST['agree1']) || !isset($_POST['agree2'])) {
        echo "同意が必要です。";
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO events (title, description, event_date, type, created_by) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$title, $description, $event_date, $type, $user_id]);

    header("Location: event_list.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>イベント作成</title>
  <style>
    body {
      font-family: 'Noto Sans JP', sans-serif;
      background: #f7f9fc;
      padding: 30px;
      color: #222;
    }
    .form-card {
      background: white;
      padding: 30px;
      border-radius: 10px;
      max-width: 700px;
      margin: auto;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }
    h2 {
      text-align: center;
      margin-bottom: 25px;
      color: #007ACC;
    }
    label {
      display: block;
      font-weight: bold;
      margin-bottom: 6px;
      color: #333;
    }
    input[type="text"],
    input[type="date"],
    textarea,
    select {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 1em;
      box-sizing: border-box;
    }
    textarea {
      resize: vertical;
    }
    input[type="submit"] {
      background: #007ACC;
      color: white;
      padding: 12px 20px;
      border: none;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
      font-size: 1em;
      transition: background 0.3s;
    }
    input[type="submit"]:hover {
      background: #005f99;
    }
    .checkbox {
      margin-bottom: 15px;
      font-size: 0.95em;
    }
  </style>
</head>
<body>
  <div class="form-card">
    <h2>イベントを作成する</h2>
    <form method="post" action="">
      <label>イベントタイトル：</label>
      <input type="text" name="title" required>

      <label>イベント説明：</label>
      <textarea name="description" rows="5" required></textarea>

      <label>開催日：</label>
      <input type="date" name="event_date" required>

      <label>イベント種別：</label>
      <select name="type" required>
        <option value="">-- 選択してください --</option>
        <option value="project">🛠 サロン内プロジェクト型</option>
        <option value="course">📖 外部講師による講座型</option>
      </select>

      <div class="checkbox">
        <label>
          <input type="checkbox" name="agree1" required>
          フィールドワーク・ディスカッション・実践提案を含むイベントであることに同意します
        </label>
      </div>
      <div class="checkbox">
        <label>
          <input type="checkbox" name="agree2" required>
          イベント終了後にレポート投稿を行うことに同意します
        </label>
      </div>

      <input type="submit" value="イベントを作成する">
    </form>
  </div>
</body>
</html>
