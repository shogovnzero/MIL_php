<?php
$name = $_POST["name"];
$mail = $_POST["mail"];
$film_title = $_POST["film_title"];
$film_review = $_POST["film_review"];
$comment = $_POST["comment"];
$c = ",";

//文字作成
$str = date("Y-m-d H:i:s").$c.$name.$c.$mail.$c.$film_title.$c.$film_review.$c.$comment;
//File書き込み
$file = fopen("data/data.csv","a");	// ファイル読み込み a for append
fwrite($file, $str."\n");
fclose($file);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Review - write</title>
</head>
<body>
    <div class="container">
        <h1>Your review is uploaded</h1>
        <ul>
            <li><a href="post.php">Write another review...</a></li>
            <li><a href="read.php">View all the reviews...</a></li>
            <li><a href="index.php">Back to main page...</a></li>
        </ul>
    </div>
</body>
</html>