<?php
//1. GETデータ取得
$id   = $_GET["id"];

//2. DB接続します
include("funcs.php");
$pdo = db_conn();

//３．データ削除SQL作成
$sql = "DELETE FROM gs_bm_table WHERE id=:id"; // テーブル名要変更
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id',$id, PDO::PARAM_INT);
$status = $stmt->execute();


//４．データ登録処理後
if($status==false){
    sql_error($stmt);
}else{
    redirect("select.php");
}
?>
