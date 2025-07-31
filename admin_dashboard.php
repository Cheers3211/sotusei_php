<?php
session_start();
require_once('db_connect.php');

// 管理者チェック
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: admin_login.php");
    exit;
}

// 投稿一覧
$sql = "SELECT posts.*, users.name FROM posts
        JOIN users ON posts.user_id = users.id
        ORDER BY posts.created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// コメント一覧
$comment_sql = "SELECT comments.*, users.name FROM comments
                JOIN users ON comments.user_id = users.id
                ORDER BY comments.created_at DESC";
$comment_stmt = $pdo->prepare($comment_sql);
$comment_stmt->execute();
$comments = $comment_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>管理ダッシュボード</title>
    <style>
        body { font-family: sans-serif; padding: 30px; background: #f0f0f0; }
        .block { background: #fff; padding: 15px; margin-bottom: 20px; border-radius: 8px; box-shadow: 0 0 5px #ccc; }
        h2 { border-bottom: 1px solid #ccc; padding-bottom: 5px; }
        form { display: inline; }
    </style>
</head>
<body>
    <h1>管理者ダッシュボード</h1>

    <div class="block">
        <h2>📝 投稿一覧（削除可能）</h2>
        <?php foreach ($posts as $post): ?>
            <p>
                <strong><?= htmlspecialchars($post['name']) ?>：</strong>
                <?= nl2br(htmlspecialchars($post['content'])) ?>
                <span style="color: gray;">（<?= $post['created_at'] ?>）</span>
                <form method="post" action="delete_post.php" onsubmit="return confirm('本当に削除しますか？');">
                    <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                    <button type="submit">❌削除</button>
                </form>
            </p>
        <?php endforeach; ?>
    </div>

    <div class="block">
        <h2>💬 コメント一覧（削除可能）</h2>
        <?php foreach ($comments as $comment): ?>
            <p>
                <strong><?= htmlspecialchars($comment['name']) ?>：</strong>
                <?= nl2br(htmlspecialchars($comment['comment'])) ?>
                <span style="color: gray;">（<?= $comment['created_at'] ?>）</span>
                <form method="post" action="delete_comment.php" onsubmit="return confirm('本当に削除しますか？');">
                    <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
                    <button type="submit">❌削除</button>
                </form>
            </p>
        <?php endforeach; ?>
    </div>
</body>
</html>
