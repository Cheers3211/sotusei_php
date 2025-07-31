<?php
session_start();

// 管理者のIDとパスワード（仮設定）
define('ADMIN_ID', 'chii_admin');
define('ADMIN_PW', 'shigemioda0630');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['admin_id'] === ADMIN_ID && $_POST['admin_pw'] === ADMIN_PW) {
        $_SESSION['is_admin'] = true;
        header("Location: admin_dashboard.php");
        exit;
    } else {
        $error = "ログイン失敗。IDまたはパスワードが違います。";
    }
}
?>

<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>管理者ログイン</title></head>
<body>
    <h2>管理者ログイン</h2>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post">
        ID: <input type="text" name="admin_id"><br>
        PW: <input type="password" name="admin_pw"><br>
        <input type="submit" value="ログイン">
    </form>
</body>
</html>
