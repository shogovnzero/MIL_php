<?php
// session start
session_start();

// access to DB
include("funcs.php");
sschk();
$pdo = db_conn();

// create SQL for data reading
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table"); //テーブル名要変更
$status = $stmt->execute();

// show data
$view="";

if($status==false){
    sql_error($stmt);
}else{
    $view .= "<table class='table_bmlist'>";
    $view .= "<thead>";
    $view .= "<tr>";
    $view .= "<th>ID</th>";
    $view .= "<th>書籍名</th>";
    $view .= "<th>書籍URL</th>";
    $view .= "<th>コメント</th>";
    $view .= "<th>登録日時</th>";
    $view .= "<th>削除</th>";
    $view .= "</tr>";
    $view .= "</thead>";
    $view .= "<tbody>";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
        $view .= "<tr>";
        $view .= "<td>".'<a href="detail.php?id='.h($res["id"]).'">'.h($res["id"])."</a>"."</td>";
        $view .= "<td>".'<a href="detail.php?id='.h($res["id"]).'">'.h($res["book_name"])."</a>"."</td>";
        $view .= "<td>".'<a href="detail.php?id='.h($res["id"]).'">'.h($res["book_url"])."</a>"."</td>";
        $view .= "<td>".'<a href="detail.php?id='.h($res["id"]).'">'.h($res["book_comment"])."</a>"."</td>";
        $view .= "<td>".'<a href="detail.php?id='.h($res["id"]).'">'.h($res["indate"])."</a>"."</td>";
        $view .= "<td>".'<a href="delete.php?id='.h($res["id"]).'">'."[削除]"."</a>"."</td>";
        $view .= "</tr>";
    }
    $view .= "<tbody>";
    $view .= "</table>";
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録書籍一覧</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <nav class="area_nav_header">
                <ul class="list_nav_header">
                <a class="item_nav_header" href="index.php"><li>書籍登録</li></a>
                <a class="item_nav_header" href="select.php"><li>書籍一覧</li></a>
                <a class="item_nav_header" href="logout.php"><li>ログアウト</li></a>
                </ul>
            </nav>
        </header>
        <main>
            <div><?=$view?></div>
        </main>
    </div>
</body>
</html>