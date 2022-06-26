<?php
// obtain POST data
$name = $_POST["book_name"];
$url = $_POST["book_url"];
$comment = $_POST["book_comment"];

include("funcs.php");
$pdo = db_conn();

// create SQL
$stmt = $pdo->prepare("insert into gs_bm_table(book_name, book_url, book_comment, indate) values(:book_name, :book_url, :book_comment, sysdate())");
$stmt->bindValue(':book_name',$name, PDO::PARAM_STR);
$stmt->bindValue(':book_url',$url, PDO::PARAM_STR);
$stmt->bindValue(':book_comment',$comment, PDO::PARAM_STR);
$status = $stmt->execute();

// after processing
if($status==false){
    sql_error($stmt);
}else{
    redirect("index.php");
}
?>