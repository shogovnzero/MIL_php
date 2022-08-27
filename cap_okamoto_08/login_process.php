<?php
// session start
session_start();

// POST value
$owner_id = $_POST['owner_id'];
$owner_pw = $_POST['owner_pw'];

// DB access
include("funcs.php");
$pdo = db_conn();

// create SQL
$stmt = $pdo->prepare("SELECT * FROM cap_owner WHERE owner_id=:owner_id");
$stmt->bindValue(':owner_id',$owner_id, PDO::PARAM_STR);
$status = $stmt->execute();

// sql error
if($status==false){
    sql_error($stmt);
}

// login process
$val = $stmt->fetch();
$pw = password_verify($owner_pw, $val["owner_pw"]);
if($pw){
    $_SESSION["chk_ssid"] = session_id();
    $_SESSION["owner_name"] = $val["owner_name"];
    $_SESSION["id"] = $val["id"];
    redirect("index.php");
}else{
    $_SESSION["login_error"] = "error";
    redirect("login.php");
}

exit();
?>

