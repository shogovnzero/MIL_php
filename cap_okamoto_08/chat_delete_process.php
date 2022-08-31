<?php
include_once("funcs.php");

$id = $_POST["id"];
$room_id = $_POST["room_id"];
$chat_id = $_POST["chat_id"];

$pdo = db_conn();

$stmt = $pdo->prepare("DELETE FROM cap_chat_content WHERE chat_id=:chat_id");
$stmt->bindValue(':chat_id', $chat_id, PDO::PARAM_INT);
$status = $stmt->execute();

include_once("chat_threads_reload_process.php")
?>
