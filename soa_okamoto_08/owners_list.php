<?php
include("funcs.php");
$pdo = db_conn();      //DB接続関数

$stmt   = $pdo->prepare("SELECT * FROM soa_owner"); //SQLをセット
$status = $stmt->execute(); //SQLを実行→エラーの場合falseを$statusに代入

$view=""; //HTML文字列作り、入れる変数
if($status==false) {
  //SQLエラーの場合
  sql_error($stmt);
}else{
  //SQL成功の場合
  while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){ //データ取得数分繰り返す
    $view .= h($r["owner_name"])."|".h($r["email"]);
  }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>SOA - 船主検索</title>
  <link rel="stylesheet" href="./css/reset.css">
  <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <div class="container">
        <header>
        </header>
        <main>
            あああ
            <?=$view?>
        </main>
        <footer>
        </footer>
    </div>
</body>