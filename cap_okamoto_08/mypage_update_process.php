<?php
session_start();
include("funcs.php");
sschk();

$owner_name = $_POST["owner_name"];
$owner_ceo = $_POST['owner_ceo'];
$owner_url = $_POST['owner_url'];
$owner_foundation = $_POST['owner_foundation'];
$owner_capital = $_POST['owner_capital'];
$owner_employee = $_POST['owner_employee'];
$p_postal_code = $_POST['p_postal_code'];
$p_region = $_POST['p_region'];
$p_locality = $_POST['p_locality'];
$p_street_address = $_POST['p_street_address'];
$p_extended_address = $_POST['p_extended_address'];
$id = $_POST['id'];

$pdo = db_conn();

$stmt = $pdo->prepare("UPDATE cap_owner SET owner_name=:owner_name,owner_ceo=:owner_ceo,owner_url=:owner_url,owner_foundation=:owner_foundation,owner_capital=:owner_capital,owner_employee=:owner_employee,p_postal_code=:p_postal_code,p_region=:p_region,p_locality=:p_locality,p_street_address=:p_street_address,p_extended_address=:p_extended_address WHERE id=:id");
$stmt->bindValue(':owner_name', $owner_name, PDO::PARAM_STR);
$stmt->bindValue(':owner_ceo', $owner_ceo, PDO::PARAM_STR);
$stmt->bindValue(':owner_url', $owner_url, PDO::PARAM_STR);
$stmt->bindValue(':owner_foundation', $owner_foundation, PDO::PARAM_STR);
$stmt->bindValue(':owner_capital', $owner_capital, PDO::PARAM_INT);
$stmt->bindValue(':owner_employee', $owner_employee, PDO::PARAM_INT);
$stmt->bindValue(':p_postal_code', $p_postal_code, PDO::PARAM_INT);
$stmt->bindValue(':p_region', $p_region, PDO::PARAM_STR);
$stmt->bindValue(':p_locality', $p_locality, PDO::PARAM_STR);
$stmt->bindValue(':p_street_address', $p_street_address, PDO::PARAM_STR);
$stmt->bindValue(':p_extended_address', $p_extended_address, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

if($status==false){
  sql_error($stmt);
}else{
  redirect("index.php");
}

?>

