<?php
include_once("funcs.php");

$room_id = $_POST["room_id"];

$pdo = db_conn();

$stmt   = $pdo->prepare("SELECT room_id,owner_name,owner_cost,owner_crew_mng,owner_group,owner_decarbon FROM `cap_chat_room` INNER JOIN `cap_owner` ON cap_chat_room.owner_id=cap_owner.id WHERE room_id = :room_id");
$stmt->bindValue(':room_id', $room_id, PDO::PARAM_INT);
$status = $stmt->execute();

$room_member='<p class="info_title">チャットメンバー</p>';
if($status==false) {
  sql_error($stmt);
}else{
  while($r = $stmt->fetch(PDO::FETCH_ASSOC)){
    $room_member .= "<p>".$r["owner_name"]."</p>";
  };
};

echo $room_member;
?>