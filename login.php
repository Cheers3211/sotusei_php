<?php
session_start();
require_once('db_connect.php');

// エラーメッセージ用
$error = '';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $lid = $_POST['lid'];
    $lpw = $_POST['lpw'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE lid = :lid");
    $stmt->bindValue(':lid', $lid);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($lpw, $user['lpw'])) {
        $_SESSION['user'] = $user;
        header("Location: mypage.php");
        exit();
    } else {
        $error = 'IDまたはパスワードが間違っています。';
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ログイン - セラノア</title>
  <style>
    body {
      font-family: 'Noto Sans JP', sans-serif;
      background-color: #eef4f8;
      margin: 0;
      padding: 40px;
    }
    .login-box {
      background: #fff;
      max-width: 500px;
      margin: auto;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 0 12px rgba(0,0,0,0.06);
      text-align: center;
    }
    h2 {
      color: #007ACC;
      margin-bottom: 20px;
    }
    .error {
      color: red;
      margin-bottom: 20px;
    }
    input[type="text"], input[type="password"] {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 1em;
    }
    input[type="submit"] {
      background: #007ACC;
      color: white;
      border: none;
      padding: 12px;
      width: 100%;
      font-weight: bold;
      font-size: 1em;
      border-radius: 6px;
      cursor: pointer;
      transition: background 0.3s;
    }
    input[type="submit"]:hover {
      background: #005f99;
    }
  </style>
</head>
<body>
  <div class="login-box">
    <h2>ログイン - セラノア</h2>
    <?php if ($error): ?>
      <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post">
      <input type="text" name="lid" placeholder="ログインID" required>
      <input type="password" name="lpw" placeholder="パスワード" required>
      <input type="submit" value="ログインする">
    </form>
  </div>
</body>
</html>
