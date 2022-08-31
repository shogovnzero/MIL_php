<?php
session_start();
include("funcs.php");
sschk();
$pdo = db_conn();

$keyword = $_POST["keyword"];

$stmt = $pdo->prepare("SELECT * FROM cap_vessel WHERE vessel_type LIKE :keyword");
$stmt->bindValue(':keyword', "%".$keyword."%", PDO::PARAM_STR);
$status = $stmt->execute();

$view="";
if($status==false) {
  sql_error($stmt);
}else{
  while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .= "<p>".'<a href="vessel_page.php?id='.h($r["id"]).'">'."船舶ページ</a>".h($r["vessel_name_jp"])."|".h($r["vessel_type"])."</p>";
  }
}

echo $view;
?>