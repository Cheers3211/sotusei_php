<?php
session_start();
require_once('db_connect.php');

// ログインチェック
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];

// 投稿一覧取得（新しい順）
$sql = "SELECT posts.*, users.name FROM posts
        JOIN users ON posts.user_id = users.id
        ORDER BY posts.created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>みんなの投稿</title>
  <style>
    body {
      font-family: 'Noto Sans JP', sans-serif;
      background: #f4f6fa;
      margin: 0;
      padding: 40px;
    }
    .container {
      max-width: 800px;
      margin: auto;
    }
    h1 {
      text-align: center;
      color: #007ACC;
    }
    .post {
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
      margin-bottom: 30px;
    }
    .post .name {
      font-weight: bold;
      color: #333;
    }
    .post .date {
      color: #777;
      font-size: 0.9em;
      margin-bottom: 10px;
    }
    .post p {
      line-height: 1.6;
    }

    .comment-block {
      margin-top: 20px;
      padding-left: 20px;
      border-left: 3px solid #eee;
    }
    .comment {
      font-size: 0.95em;
      margin-bottom: 10px;
    }
    .comment strong {
      color: #555;
    }
    .comment-form {
      margin-top: 15px;
    }
    textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      resize: vertical;
      font-size: 1em;
      margin-bottom: 10px;
    }
    input[type="submit"] {
      background: #007ACC;
      color: white;
      padding: 8px 16px;
      border: none;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s;
    }
    input[type="submit"]:hover {
      background: #005f99;
    }

    .nav-links {
      text-align: center;
      margin-bottom: 20px;
    }
    .nav-links a {
      margin: 0 10px;
      text-decoration: none;
      color: #007ACC;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>みんなの投稿</h1>

    <div class="nav-links">
      <a href="post.php">＋ 投稿する</a>
      <a href="mypage.php">マイページへ</a>
    </div>

    <?php foreach ($posts as $post): ?>
      <div class="post">
        <div class="name"><?= htmlspecialchars($post['name']) ?> さん</div>
        <div class="date"><?= htmlspecialchars($post['created_at']) ?></div>
        <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>

        <?php
        // コメント取得
        $comment_sql = "SELECT comments.*, users.name FROM comments
                        JOIN users ON comments.user_id = users.id
                        WHERE comments.post_id = :post_id
                        ORDER BY comments.created_at ASC";
        $comment_stmt = $pdo->prepare($comment_sql);
        $comment_stmt->bindValue(':post_id', $post['id'], PDO::PARAM_INT);
        $comment_stmt->execute();
        $comments = $comment_stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <div class="comment-block">
          <?php foreach ($comments as $comment): ?>
            <div class="comment">
              <strong><?= htmlspecialchars($comment['name']) ?>：</strong>
              <?= nl2br(htmlspecialchars($comment['comment'])) ?>
              <span style="color: gray; font-size: 0.8em;">
                （<?= htmlspecialchars($comment['created_at']) ?>）
              </span>
            </div>
          <?php endforeach; ?>

          <div class="comment-form">
            <form method="post" action="comment_post.php">
              <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
              <textarea name="comment" rows="2" required></textarea>
              <input type="submit" value="コメントする">
            </form>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</body>
</html>
