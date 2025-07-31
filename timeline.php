<?php
session_start();
require_once('db_connect.php');

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
<html>
<head>
    <meta charset="UTF-8">
    <title>投稿一覧</title>
    <style>
        body { font-family: sans-serif; padding: 30px; background: #eef; }
        .container { max-width: 700px; margin: auto; }
        .post {
            background: white; margin-bottom: 15px; padding: 15px;
            border-radius: 8px; box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }
        .name { font-weight: bold; }
        .date { color: gray; font-size: 0.9em; }
    </style>
</head>
<body>
<div class="container">
    <h1>みんなの投稿</h1>
    <p><a href="post.php">← 投稿する</a> | <a href="mypage.php">マイページ</a></p>

    <?php foreach ($posts as $post): ?>
        <div class="post">
            <div class="name"><?= htmlspecialchars($post['name']) ?> さん</div>
            <div class="date"><?= htmlspecialchars($post['created_at']) ?></div>
            <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>

            <!-- 👍 いいね数＆ボタン -->
            <?php
            // いいね数取得
            $like_sql = "SELECT COUNT(*) FROM likes WHERE post_id = :post_id";
            $like_stmt = $pdo->prepare($like_sql);
            $like_stmt->bindValue(':post_id', $post['id'], PDO::PARAM_INT);
            $like_stmt->execute();
            $like_count = $like_stmt->fetchColumn();

            // いいね済みか？
            $check_sql = "SELECT * FROM likes WHERE post_id = :post_id AND user_id = :user_id";
            $check_stmt = $pdo->prepare($check_sql);
            $check_stmt->bindValue(':post_id', $post['id'], PDO::PARAM_INT);
            $check_stmt->bindValue(':user_id', $user['id'], PDO::PARAM_INT);
            $check_stmt->execute();
            $already_liked = $check_stmt->fetch();
            ?>

            <form method="post" action="like.php" style="display:inline;">
                <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                <?php if (!$already_liked): ?>
                    <button type="submit">👍 いいね</button>
                <?php endif; ?>
                <span>👍 <?= $like_count ?>件</span>
            </form>

            <!-- 💬 コメント表示 -->
            <?php
            $comment_sql = "SELECT comments.*, users.name FROM comments
                            JOIN users ON comments.user_id = users.id
                            WHERE comments.post_id = :post_id
                            ORDER BY comments.created_at ASC";
            $comment_stmt = $pdo->prepare($comment_sql);
            $comment_stmt->bindValue(':post_id', $post['id'], PDO::PARAM_INT);
            $comment_stmt->execute();
            $comments = $comment_stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <div style="margin-top: 10px; padding-left: 20px;">
                <?php foreach ($comments as $comment): ?>
                    <p>
                        <strong><?= htmlspecialchars($comment['name']) ?>：</strong>
                        <?= nl2br(htmlspecialchars($comment['comment'])) ?>
                        <span style="color: gray; font-size: 0.8em;">
                            （<?= htmlspecialchars($comment['created_at']) ?>）
                        </span>
                    </p>
                <?php endforeach; ?>
            </div>

            <!-- 💌 コメント投稿フォーム -->
            <form method="post" action="comment_post.php" style="margin-top: 10px; padding-left: 20px;">
                <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                <textarea name="comment" rows="2" style="width:100%;" required></textarea>
                <input type="submit" value="コメントする">
            </form>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>
