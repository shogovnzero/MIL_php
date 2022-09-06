<?php
include_once("funcs.php");

$chat_id = $_POST["chat_id"];
$message = $_POST["message"];

$pdo = db_conn();

$stmt   = $pdo->prepare("UPDATE cap_chat_content SET message=:message WHERE chat_id=:chat_id");
$stmt->bindValue(':chat_id', $chat_id, PDO::PARAM_INT);
$stmt->bindValue(':message', $message, PDO::PARAM_STR);
$status = $stmt->execute();

echo $message;
?>
