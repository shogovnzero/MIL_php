<?php
session_start();
$owner_name = $_SESSION["join"]["owner_name"];
$email = $_SESSION["join"]["owner_email"];
$owner_id = $_SESSION["join"]["owner_id"];
$owner_pw = password_hash($_SESSION["join"]["owner_pw"], PASSWORD_DEFAULT);

include("funcs.php");
$pdo = db_conn();

$stmt = $pdo->prepare("INSERT INTO cap_owner(owner_id, owner_pw, owner_name, email)VALUES(:owner_id, :owner_pw, :owner_name, :email)");
$stmt->bindValue(':owner_id', $owner_id, PDO::PARAM_STR);
$stmt->bindValue(':owner_pw', $owner_pw, PDO::PARAM_STR);
$stmt->bindValue(':owner_name', $owner_name, PDO::PARAM_STR);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$status = $stmt->execute();

if($status==false){
  sql_error($stmt);
}else{
  redirect("login.php");
}

?>

