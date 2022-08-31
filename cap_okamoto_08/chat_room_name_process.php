<?php
include_once("funcs.php");

$id = $_POST["id"];
$room_id = $_POST["room_id"];

$pdo = db_conn();

$stmt   = $pdo->prepare("SELECT * FROM cap_chat_name WHERE room_id=:room_id");
$stmt->bindValue(':room_id', $room_id, PDO::PARAM_INT);
$status = $stmt->execute();
if($status==false) {
  sql_error($stmt);
}else{
  $row = $stmt->fetch();
}
$room_name = $row["room_name"];
echo $room_name;
?>