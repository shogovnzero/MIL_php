<?php
session_start();
include("funcs.php");
sschk();

// 登録情報・運航情報
$vessel_number = $_SESSION["join"]["vessel_number"];
$vessel_name_jp = $_SESSION["join"]["vessel_name_jp"];
$vessel_name_en = $_SESSION["join"]["vessel_name_en"];
$owner_id = $_SESSION["join"]["owner_id"];
$manager = $_SESSION["join"]["manager"];
$vessel_reg_port = $_SESSION["join"]["vessel_reg_port"];
$vessel_trade_pref = implode(",",$_SESSION["join"]["vessel_trade_pref"]);
$vessel_trade_port = $_SESSION["join"]["vessel_trade_port"];

// 船種・船型
$vessel_type = $_SESSION["join"]["vessel_type"];
$vessel_gt = $_SESSION["join"]["vessel_gt"];
$vessel_nt = $_SESSION["join"]["vessel_nt"];
$vessel_dwt = $_SESSION["join"]["vessel_dwt"];
$vessel_tank = $_SESSION["join"]["vessel_tank"];
$vessel_teu = $_SESSION["join"]["vessel_teu"];
$vessel_loa = $_SESSION["join"]["vessel_loa"];
$vessel_beam = $_SESSION["join"]["vessel_beam"];
$vessel_depth = $_SESSION["join"]["vessel_depth"];
$vessel_draft = $_SESSION["join"]["vessel_draft"];
$vessel_crew = $_SESSION["join"]["vessel_crew"];

// 技術情報
$vessel_sy = $_SESSION["join"]["vessel_sy"];
$vessel_built = $_SESSION["join"]["vessel_built"];
$vessel_me = $_SESSION["join"]["vessel_me"];
$vessel_fuel = implode(",",$_SESSION["join"]["vessel_fuel"]);

$pdo = db_conn();

$stmt = $pdo->prepare("INSERT INTO cap_vessel(vessel_number, vessel_name_jp, vessel_name_en, owner_id, manager, vessel_reg_port, vessel_trade_pref, vessel_trade_port,
vessel_type, vessel_gt, vessel_nt, vessel_dwt, vessel_tank, vessel_teu, vessel_loa, vessel_beam, vessel_depth, vessel_draft, vessel_crew,
vessel_sy, vessel_built, vessel_me, vessel_fuel)
VALUES(:vessel_number, :vessel_name_jp, :vessel_name_en, :owner_id, :manager, :vessel_reg_port, :vessel_trade_pref, :vessel_trade_port,
:vessel_type, :vessel_gt, :vessel_nt, :vessel_dwt, :vessel_tank, :vessel_teu, :vessel_loa, :vessel_beam, :vessel_depth, :vessel_draft, :vessel_crew,
:vessel_sy, :vessel_built, :vessel_me, :vessel_fuel)");


$stmt->bindValue(':vessel_number', $vessel_number, PDO::PARAM_INT);
$stmt->bindValue(':vessel_name_jp', $vessel_name_jp, PDO::PARAM_STR);
$stmt->bindValue(':vessel_name_en', $vessel_name_en, PDO::PARAM_STR);
$stmt->bindValue(':owner_id', $owner_id, PDO::PARAM_INT);
$stmt->bindValue(':manager', $manager, PDO::PARAM_STR);
$stmt->bindValue(':vessel_reg_port', $vessel_reg_port, PDO::PARAM_STR);
$stmt->bindValue(':vessel_trade_pref', $vessel_trade_pref, PDO::PARAM_STR);
$stmt->bindValue(':vessel_trade_port', $vessel_trade_port, PDO::PARAM_STR);


$stmt->bindValue(':vessel_type', $vessel_type, PDO::PARAM_STR);
$stmt->bindValue(':vessel_gt', $vessel_gt, PDO::PARAM_INT);
$stmt->bindValue(':vessel_nt', $vessel_nt, PDO::PARAM_INT);
$stmt->bindValue(':vessel_dwt', $vessel_dwt, PDO::PARAM_INT);
$stmt->bindValue(':vessel_tank', $vessel_tank, PDO::PARAM_INT);
$stmt->bindValue(':vessel_teu', $vessel_teu, PDO::PARAM_INT);
$stmt->bindValue(':vessel_loa', $vessel_loa, PDO::PARAM_INT);
$stmt->bindValue(':vessel_beam', $vessel_beam, PDO::PARAM_INT);
$stmt->bindValue(':vessel_depth', $vessel_depth, PDO::PARAM_INT);
$stmt->bindValue(':vessel_draft', $vessel_draft, PDO::PARAM_INT);
$stmt->bindValue(':vessel_crew', $vessel_crew, PDO::PARAM_INT);

$stmt->bindValue(':vessel_sy', $vessel_sy, PDO::PARAM_STR);
$stmt->bindValue(':vessel_built', $vessel_built, PDO::PARAM_STR);
$stmt->bindValue(':vessel_me', $vessel_me, PDO::PARAM_STR);
$stmt->bindValue(':vessel_fuel', $vessel_fuel, PDO::PARAM_STR);

$status = $stmt->execute();

if($status==false){
    sql_error($stmt);
}else{
    redirect("vessel_register.php");
}

?>
