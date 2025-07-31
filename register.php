<?php
// 登録処理（POSTのときだけ実行）
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once('db_connect.php');

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':password', $password, PDO::PARAM_STR);

    if ($stmt->execute()) {
        echo "<p>登録が完了しました！<a href='login.php'>ログインはこちら</a></p>";
        exit;
    } else {
        echo "<p>登録に失敗しました。もう一度お試しください。</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>セラノアに参加する</title>
  <style>
    body {
      font-family: 'Noto Sans JP', sans-serif;
      background: #f0f4f8;
      margin: 0;
      padding: 40px;
    }
    .register-box {
      max-width: 500px;
      margin: auto;
      background: white;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 0 12px rgba(0,0,0,0.06);
    }
    h2 {
      text-align: center;
      color: #007ACC;
      margin-bottom: 30px;
    }
    p.lead {
      text-align: center;
      margin-bottom: 20px;
      color: #555;
    }
    label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
      color: #333;
    }
    input[type="text"], input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border-radius: 6px;
      border: 1px solid #ccc;
      box-sizing: border-box;
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
  <div class="register-box">
    <h2>セラノアに参加する</h2>
    <p class="lead">あなたの一歩が、未来のセラノアを動かします。</p>

    <form method="post" action="register_act.php">
      <label>ユーザー名</label>
      <input type="text" name="name" required>

      <label>ID（メールなど）</label>
      <input type="text" name="lid" required>

      <label>パスワード</label>
      <input type="password" name="lpw" required>

      <input type="submit" value="参加する">
    </form>
  </div>
</body>
</html>
