<?php
include_once("funcs.php");

$room_id = $_POST["room_id"];
$room_name = $_POST["room_name"];

$pdo = db_conn();

$stmt   = $pdo->prepare("UPDATE cap_chat_name SET room_name=:room_name WHERE room_id=:room_id");
$stmt->bindValue(':room_id', $room_id, PDO::PARAM_INT);
$stmt->bindValue(':room_name', $room_name, PDO::PARAM_STR);
$status = $stmt->execute();
?>