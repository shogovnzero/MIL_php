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
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Round|Material+Icons+Sharp|Material+Icons+Two+Tone" rel="stylesheet">
  <link rel="stylesheet" href="./css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
</head>

<body>
    <div class="container">
        <header>
        </header>
        <main>
            <div class="area_login">
                <div class="area_logo">
                    <img src="img/cap_logo_blue.png">
                </div>
                <p>Coastal ship owner Aggregator Platform</p>
                <p>内航船主マッチングプラットフォーム</p>
                <div class="area_input">
                    <form method="post" action="login_process.php">
                        <table>
                            <tr>
                                <th>ログインID</th>
                                <td><input type="text" name="owner_id" class="tbox_auth" required></td>
                            </tr>
                            <tr>
                                <th>パスワード</th>
                                <td><input type="password" name="owner_pw" class="tbox_auth" required></td>
                            </tr>
                            <!-- <tr>
                                <th>ログイン情報</th>
                                <td><label><input type="checkbox" value="remember-me">ログイン情報を保存する</label></td>
                            </tr> -->
                        </table>
                        <button type="submit" class="btn_auth">ログイン</button>
                        <?php if ($login_error === "error"):?>
                            <p class = "login_error">ログインIDまたはパスワードが間違っています</p>
                        <?php endif ?>
                    </form>
                </div>
                <div class="area_signup">
                    <p>初めての方はこちら</p>
                    <button type="submit" class="btn_auth"><a href="signup.php">会員登録</a></button>
                </div>
            </div>

        </main>
        <footer>
        </footer>
    </div>
</body>