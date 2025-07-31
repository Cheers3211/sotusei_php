<?php
session_start();
require_once('db_connect.php');

// 管理者チェック
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: admin_login.php");
    exit;
}

// ユーザー一覧取得
$sql = "SELECT id, name, email, created_at FROM users ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ユーザー管理</title>
    <style>
        body { font-family: sans-serif; padding: 30px; background: #f9f9f9; }
        table { width: 100%; border-collapse: collapse; background: #fff; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #eee; }
        form { display: inline; }
        .back { margin-top: 15px; display: inline-block; }
    </style>
</head>
<body>
    <h1>👤 ユーザー一覧（管理者用）</h1>
    <table>
        <tr>
            <th>ID</th><th>名前</th><th>メール</th><th>登録日</th><th>操作</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= htmlspecialchars($user['name']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= $user['created_at'] ?></td>
                <td>
                    <form method="post" action="delete_user.php" onsubmit="return confirm('本当に削除しますか？');">
                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                        <button type="submit">❌削除</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="admin_dashboard.php" class="back">← ダッシュボードに戻る</a>
</body>
</html>
