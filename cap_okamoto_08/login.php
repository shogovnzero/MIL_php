<?php
session_start();
include("funcs.php");
if(!empty($_SESSION["login_error"])){
    $login_error = $_SESSION["login_error"];
} else {
    $login_error = "";
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>CAP - ログイン</title>
  <link rel="stylesheet" href="./css/reset.css">
  <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <div class="container">
        <header>
        </header>
        <main>
            <div>
                <form method="post" action="login_process.php">
                    <input type="text" name="owner_id" class="tbox_auth" placeholder="ログインID">
                    <input type="password" name="owner_pw" class="tbox_auth" placeholder="パスワード">
                    <label>
                        <input type="checkbox" value="remember-me">ログイン情報を保存する
                    </label>
                    <button type="submit" class="btn_auth">ログイン</button>
                    <?php if ($login_error === "error"):?>
                        <p class = "login_error">ログインIDまたはパスワードが間違っています</p>
                    <?php endif ?>
                </form>
            </div>
            <div>
                <p>初めての方はこちら</p>
                <button type="submit" class="btn_auth"><a href="signup.php">会員登録</a></button>
            </div>
        </main>
        <footer>
        </footer>
    </div>
</body>