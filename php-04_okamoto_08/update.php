<?php
// obtain POST data
$name = $_POST["book_name"];
$url = $_POST["book_url"];
$comment = $_POST["book_comment"];
$id    = $_POST["id"];

//DB access
include("funcs.php");
$pdo = db_conn();


//３．データ登録SQL作成
$sql = "UPDATE gs_bm_table SET book_name=:book_name, book_url=:book_url, book_comment=:book_comment WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':book_name', $name, PDO::PARAM_STR);
$stmt->bindValue(':book_url', $url, PDO::PARAM_STR);
$stmt->bindValue(':book_comment', $comment, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();


//４．データ登録処理後
if($status==false){
    sql_error($stmt);
}else{
    redirect("select.php");
}

?>
