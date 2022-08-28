<?php
session_start();
include("funcs.php");
$pdo = db_conn();

if(!empty($_POST)){
    if($_POST["owner_name"] === ""){
        $error["owner_name"] = "blank";
    }
    if($_POST["owner_email"] === ""){
        $error["owner_email"] = "blank";
    }
    if($_POST["owner_id"] === ""){
        $error["owner_id"] = "blank";
    }
    if($_POST["owner_pw"] === ""){
        $error["owner_pw"] = "blank";
    }
    if(!isset($error)){
        $stmt = $pdo->prepare("SELECT COUNT(*) as cnt_name FROM cap_owner WHERE owner_name=?");
        $stmt->execute(array($_POST["owner_name"]));
        $record = $stmt->fetch();
        if($record["cnt_name"] > 0){
            $error["owner_name"] = "duplicate";
        }

        $stmt = $pdo->prepare("SELECT COUNT(*) as cnt_email FROM cap_owner WHERE email=?");
        $stmt->execute(array($_POST["owner_email"]));
        $record = $stmt->fetch();
        if($record["cnt_email"] > 0){
            $error["owner_email"] = "duplicate";
        }

        $stmt = $pdo->prepare("SELECT COUNT(*) as cnt_id FROM cap_owner WHERE owner_id=?");
        $stmt->execute(array($_POST["owner_id"]));
        $record = $stmt->fetch();
        if($record["cnt_id"] > 0){
            $error["owner_id"] = "duplicate";
        }
    }
    if (!isset($error)) {
        $_SESSION['join'] = $_POST;
        redirect("signup_process.php");
        exit();
    }
}

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
                <form method="post" action="">
                    <div class="area_auth">
                        <label for="owner_name">会社名<span id="required">*</span></label>
                        <?php if (!empty($error["owner_name"]) && $error['owner_name'] === 'blank'): ?>
                            <input type="text" name="owner_name" class="tbox_auth" placeholder="会社名">
                            <p class="error">*会社名は必須入力です</p>
                        <?php elseif (!empty($error["owner_name"]) && $error['owner_name'] === 'duplicate'): ?>
                            <input type="text" name="owner_name" class="tbox_auth" placeholder="会社名">
                            <p class="error">*この会社は登録済みです</p>
                        <?php elseif (!empty($_POST)): ?>
                            <input type="text" name="owner_name" class="tbox_auth" value="<?=$_POST["owner_name"]?>">
                        <?php else: ?>
                            <input type="text" name="owner_name" class="tbox_auth" placeholder="会社名">
                        <?php endif ?>
                    </div>
                    <div class="area_auth">
                        <label for="owner_email">メールアドレス<span id="required">*</span></label>
                        <?php if (!empty($error["owner_email"]) && $error['owner_email'] === 'blank'): ?>
                            <input type="email" name="owner_email" class="tbox_auth" placeholder="メールアドレス">
                            <p class="error">*メールアドレスは必須入力です</p>
                        <?php elseif (!empty($error["owner_email"]) && $error['owner_email'] === 'duplicate'): ?>
                            <input type="email" name="owner_email" class="tbox_auth" placeholder="メールアドレス">
                            <p class="error">*このメールアドレスは登録済みです</p>
                        <?php elseif (!empty($_POST)): ?>
                            <input type="email" name="owner_email" class="tbox_auth" value="<?=$_POST["owner_email"]?>">
                        <?php else: ?>
                            <input type="email" name="owner_email" class="tbox_auth" placeholder="メールアドレス">
                        <?php endif ?>
                    </div>
                    <div class="area_auth">
                        <label for="owner_id">ログインID<span id="required">*</span></label>
                        <?php if (!empty($error["owner_id"]) && $error['owner_id'] === 'blank'): ?>
                            <input type="text" name="owner_id" class="tbox_auth" placeholder="ログインID">
                            <p class="error">*ログインIDは必須入力です</p>
                        <?php elseif (!empty($error["owner_id"]) && $error['owner_id'] === 'duplicate'): ?>
                            <input type="text" name="owner_id" class="tbox_auth" placeholder="ログインID">
                            <p class="error">*このログインIDは既に使用されています</p>
                        <?php elseif (!empty($_POST)): ?>
                            <input type="text" name="owner_id" class="tbox_auth" value="<?=$_POST["owner_id"]?>">
                        <?php else: ?>
                            <input type="text" name="owner_id" class="tbox_auth" placeholder="ログインID">
                        <?php endif ?>
                    </div>
                    <div class="area_auth">
                        <label for="owner_pw">パスワード<span id="required">*</span></label>
                        <?php if (!empty($error["owner_pw"]) && $error['owner_pw'] === 'blank'): ?>
                            <input type="password" name="owner_pw" class="tbox_auth" placeholder="パスワード">
                            <p class="error">*パスワードは必須入力です</p>
                        <?php elseif (!empty($_POST)): ?>
                            <input type="password" name="owner_pw" class="tbox_auth" value="<?=$_POST["owner_pw"]?>">
                        <?php else: ?>
                            <input type="password" name="owner_pw" class="tbox_auth" placeholder="パスワード">
                        <?php endif ?>
                    </div>
                    <button type="submit" class="btn_auth">会員登録</button>
                </form>
            </div>
        </main>
        <footer>
        </footer>
    </div>
</body>