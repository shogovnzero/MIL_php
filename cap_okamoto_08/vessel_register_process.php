<?php
session_start();
$id = $_SESSION['id'];
include("funcs.php");
sschk();
$pdo = db_conn();

if(!empty($_POST)){
  if($_POST["vessel_number"] === ""){
    $error["vessel_number"] = "blank";
  }
  if($_POST["vessel_name_jp"] === ""){
    $error["vessel_name_jp"] = "blank";
  }
  if($_POST["vessel_name_en"] === ""){
    $error["vessel_name_en"] = "blank";
  }
  if(!isset($error)){
    $stmt = $pdo->prepare("SELECT COUNT(*) as cnt_number FROM cap_owner WHERE vessel_number=?");
    $stmt->execute(array($_POST["vessel_number"]));
    $record = $stmt->fetch();
    if($record["cnt_number"] > 0){
        $error["vessel_number"] = "duplicate";
    }
  }
  if (!isset($error)) {
    $_SESSION['join'] = $_POST;
    redirect("vessel_register_process.php");
    exit();
  }
}

?>
