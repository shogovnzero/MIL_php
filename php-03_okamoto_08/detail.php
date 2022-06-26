<?php
$id = $_GET["id"];

// access to DB
include("funcs.php");
$pdo = db_conn();

// create SQL for data reading
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table WHERE id=:id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

// show data
$view="";

if($status==false){
    sql_error($stmt);
}else{
    $row = $stmt->fetch();
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
            <form method="post" action="update.php">
                <table class="table_form">
                    <tr class="item_form">
                        <th>書籍名</th>
                        <td><input class="input_box" type="text" name="book_name" value="<?=$row["book_name"]?>" maxlength="64" required></td>
                    </tr>
                    <tr class="item_form">
                        <th>書籍URL</th>
                        <td><input class="input_box" type="url" name="book_url" value="<?=$row["book_url"]?>" required></td>
                    </tr>
                    <tr class="item_form">
                        <th>書籍コメント</th>
                        <td><textarea name="book_comment"><?=$row["book_comment"]?></textarea></td>
                    </tr>
                    <input type="hidden" name="id" value="<?=$row["id"]?>">
                </table>
                <input type="submit" value="送信">
            </form>
        </main>
        <footer>
        </footer>
    </div>
</body>
</html>