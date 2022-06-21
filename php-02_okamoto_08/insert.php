<?php
// obtain POST data
$name = $_POST["book_name"];
$url = $_POST["book_url"];
$comment = $_POST["book_comment"];

// access to DB
try {
    $pdo = new PDO("mysql:dbname=***;charset=utf8;host=***","***","***");
} catch (PDOException $e) {
    exit("DBConnection Error: " . $e->getMessage());
}

// create SQL
$stmt = $pdo->prepare("insert into gs_bm_table(book_name, book_url, book_comment, indate) values(:book_name, :book_url, :book_comment, sysdate())");
$stmt->bindValue(':book_name',$name, PDO::PARAM_STR);
$stmt->bindValue(':book_url',$url, PDO::PARAM_STR);
$stmt->bindValue(':book_comment',$comment, PDO::PARAM_STR);
$status = $stmt->execute();

// after processing
if($status==false){
    $error = $stmt->errorInfo();
    exit("SQL_ERROR:".$error[2]);
}else{
    header("Location: index.php");
    exit();
}
?>