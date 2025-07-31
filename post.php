<?php
session_start();
require_once('db_connect.php');

// ログインチェック
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];
$message = '';

// 投稿処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = $_POST['content'];

    if (!empty($content)) {
        $sql = "INSERT INTO posts (user_id, content) VALUES (:user_id, :content)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':user_id', $user['id'], PDO::PARAM_INT);
        $stmt->bindValue(':content', $content, PDO::PARAM_STR);
        $stmt->execute();

        $message = "投稿しました！";
    } else {
        $message = "投稿内容を入力してください。";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>投稿フォーム</title>
    <style>
        body { font-family: sans-serif; padding: 30px; background: #f2f2f2; }
        .box { background: white; padding: 20px; border-radius: 8px; max-width: 500px; margin: auto; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        textarea { width: 100%; height: 100px; }
        input[type="submit"] {
            background-color: #007BFF; color: white; padding: 10px;
            width: 100%; border: none; border-radius: 4px; margin-top: 10px;
        }
        .msg { text-align: center; color: green; margin-bottom: 10px; }
        .error { color: red; }
    </style>
</head>
<body>

<div class="box">
    <h2>こんにちは、<?= htmlspecialchars($user['name']) ?> さん</h2>

    <?php if ($message): ?>
        <p class="msg"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="post" action="post.php">
        <label>今日のひとこと：
            <textarea name="content" required></textarea>
        </label>
        <input type="submit" value="投稿する">
    </form>

    <p style="text-align:center; margin-top:20px;">
        <a href="mypage.php">← マイページに戻る</a>
    </p>
</div>

</body>
</html>
