<?php
session_start();
include("funcs.php");
sschk();

$owner_name = $_SESSION["join"]["owner_name"];
$owner_ceo = $_SESSION["join"]['owner_ceo'];
$owner_url = $_SESSION["join"]['owner_url'];
$owner_foundation = $_SESSION["join"]['owner_foundation'];
$owner_capital = $_SESSION["join"]['owner_capital'];
$owner_employee = $_SESSION["join"]['owner_employee'];
$p_postal_code = $_SESSION["join"]['p_postal_code'];
$p_region = $_SESSION["join"]['p_region'];
$p_locality = $_SESSION["join"]['p_locality'];
$p_street_address = $_SESSION["join"]['p_street_address'];
$p_extended_address = $_SESSION["join"]['p_extended_address'];
$id = $_SESSION["join"]['id'];
$owner_cost = implode(",",$_SESSION["join"]["owner_cost"]);
$owner_crew_mng = implode(",",$_SESSION["join"]["owner_crew_mng"]);
$owner_group = implode(",",$_SESSION["join"]["owner_group"]);
$owner_decarbon = implode(",",$_SESSION["join"]["owner_decarbon"]);


$pdo = db_conn();

$stmt = $pdo->prepare("UPDATE cap_owner SET owner_name=:owner_name,owner_ceo=:owner_ceo,owner_url=:owner_url,owner_foundation=:owner_foundation,owner_capital=:owner_capital,owner_employee=:owner_employee,p_postal_code=:p_postal_code,p_region=:p_region,p_locality=:p_locality,p_street_address=:p_street_address,p_extended_address=:p_extended_address, owner_cost=:owner_cost, owner_crew_mng=:owner_crew_mng, owner_group=:owner_group, owner_decarbon=:owner_decarbon WHERE id=:id");
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
$stmt->bindValue(':owner_cost', $owner_cost, PDO::PARAM_STR);
$stmt->bindValue(':owner_crew_mng', $owner_crew_mng, PDO::PARAM_STR);
$stmt->bindValue(':owner_group', $owner_group, PDO::PARAM_STR);
$stmt->bindValue(':owner_decarbon', $owner_decarbon, PDO::PARAM_STR);
$status = $stmt->execute();

if($status==false){
  sql_error($stmt);
}else{
  redirect("index.php");
}

?>

