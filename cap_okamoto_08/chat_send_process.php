<?php
include_once("funcs.php");

$id = $_POST["id"];
$room_id = $_POST["room_id"];
$sender_id = $_POST["sender_id"];
$message = $_POST["message"];
$thread_flg = $_POST["thread_flg"];

$pdo = db_conn();

$stmt = $pdo->prepare("INSERT INTO cap_chat_content(room_id, sender_id, message, thread_flg, indate) VALUES(:room_id, :sender_id, :message, :thread_flg, sysdate())");
$stmt->bindValue(':room_id', $room_id, PDO::PARAM_INT);
$stmt->bindValue(':sender_id', $sender_id, PDO::PARAM_INT);
$stmt->bindValue(':message', $message, PDO::PARAM_STR);
$stmt->bindValue(':thread_flg', $thread_flg, PDO::PARAM_INT);
$status = $stmt->execute();

include_once("chat_threads_reload_process.php")
?>
