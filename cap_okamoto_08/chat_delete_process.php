<?php
include_once("funcs.php");

$id = $_POST["id"];
$chat_id = $_POST["chat_id"];
$thread_id = $_POST["thread_id"];

$pdo = db_conn();

$stmt = $pdo->prepare("DELETE FROM cap_chat_content WHERE chat_id=:chat_id");
$stmt->bindValue(':chat_id', $chat_id, PDO::PARAM_INT);
$status = $stmt->execute();

include_once("chat_thread_reload_process.php");
?>
