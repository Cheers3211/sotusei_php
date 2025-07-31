<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once('db_connect.php');

$name = $_POST["name"];
$lid = $_POST["lid"];
$lpw = password_hash($_POST["lpw"], PASSWORD_DEFAULT);

// DB登録
$stmt = $pdo->prepare("INSERT INTO users(name, lid, lpw) VALUES(:name, :lid, :lpw)");
$stmt->bindValue(':name', $name);
$stmt->bindValue(':lid', $lid);
$stmt->bindValue(':lpw', $lpw);
$status = $stmt->execute();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>登録完了 - セラノア</title>
  <style>
    body {
      font-family: 'Noto Sans JP', sans-serif;
      background-color: #f0f4f8;
      text-align: center;
      padding: 80px 20px;
      color: #333;
    }
    .box {
      background: white;
      max-width: 500px;
      margin: auto;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 0 12px rgba(0,0,0,0.06);
    }
    h2 {
      color: #007ACC;
      margin-bottom: 20px;
    }
    p {
      font-size: 1.1em;
      margin-bottom: 30px;
    }
    a {
      display: inline-block;
      padding: 12px 24px;
      background: #007ACC;
      color: white;
      text-decoration: none;
      font-weight: bold;
      border-radius: 6px;
      transition: background 0.3s;
    }
    a:hover {
      background: #005f99;
    }
  </style>
</head>
<body>
  <div class="box">
    <?php if ($status): ?>
      <h2>🎉 登録が完了しました！</h2>
      <p>ようこそ、セラノアへ。<br>ログインして、新しいつながりを始めましょう。</p>
      <a href="login.php">ログインする</a>
    <?php else: ?>
      <h2>⚠️ 登録エラー</h2>
      <p>登録中にエラーが発生しました。<br>もう一度お試しください。</p>
    <?php endif; ?>
  </div>
</body>
</html>

