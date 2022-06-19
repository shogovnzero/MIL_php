<?php
require_once("funcs.php");

// access to DB
try {
    $pdo = new PDO("mysql:dbname=shogovnzero_gs_bm_table;charset=utf8;host=mysql57.shogovnzero.sakura.ne.jp","shogovnzero","Vienna1180");
} catch (PDOException $e) {
    exit("DBConnection Error:".$e->getMessage());
}

// create SQL for data reading
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table");
$status = $stmt->execute();

// show data
$view="";

if($status==false){
    $error = $stmt->errorInfo();
    exit("SQL_ERROR:".$error[2]);
}else{
    $view .= "<table class='table_bmlist'>";
    $view .= "<thead>";
    $view .= "<tr>";
    $view .= "<th>ID</th>";
    $view .= "<th>書籍名</th>";
    $view .= "<th>書籍URL</th>";
    $view .= "<th>コメント</th>";
    $view .= "<th>登録日時</th>";
    $view .= "</tr>";
    $view .= "</thead>";
    $view .= "<tbody>";
    while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
        $view .= "<tr>";
        $view .= "<td>".h($res["id"])."</td>";
        $view .= "<td>".h($res["book_name"])."</td>";
        $view .= "<td>".h($res["book_url"])."</td>";
        $view .= "<td>".h($res["book_comment"])."</td>";
        $view .= "<td>".h($res["indate"])."</td>";
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
                </ul>
            </nav>
        </header>
        <main>
            <div><?=$view?></div>
        </main>
    </div>
</body>
</html>