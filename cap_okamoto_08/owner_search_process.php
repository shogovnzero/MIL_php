<?php
session_start();
include("funcs.php");
sschk();
$pdo = db_conn();

$keyword = $_POST["keyword"];

$stmt = $pdo->prepare("SELECT * FROM cap_owner WHERE owner_name LIKE :keyword");
$stmt->bindValue(':keyword', "%".$keyword."%", PDO::PARAM_STR);
$status = $stmt->execute();

$view="";
if($status==false) {
  sql_error($stmt);
}else{
  while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .= "<p>".'<a href="owner_page.php?id='.h($r["id"]).'">'."船主ページ</a>".h($r["owner_name"])."|".h($r["p_region"]).h($r["p_locality"])."</p>";
  }
}

echo $view;
?>