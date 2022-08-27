<?php
include("funcs.php");
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>CAP - 会員登録</title>
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
                    <div></div>
                    <input type="text" name="owner_name" class="tbox_auth" placeholder="会社名">
                    <input type="email" name="owner_email" class="tbox_auth" placeholder="メールアドレス">
                    <input type="text" name="owner_id" class="tbox_auth" placeholder="ログインID">
                    <input type="password" name="owner_pw" class="tbox_auth" placeholder="パスワード">
                    <button type="submit" class="btn_auth">会員登録</button>
                </form>
            </div>
        </main>
        <footer>
        </footer>
    </div>
</body>