<?php
$id_1 = $_SESSION["id"];
$id_2 = $_GET["id"];
$room_member = [$id_1, $id_2];
sort($room_member);
$room_member = implode(",", $room_member);

var_dump($room_member);

include("funcs.php");
sschk();
$pdo = db_conn();

$stmt = $pdo->prepare("SELECT * FROM (SELECT room_id, GROUP_CONCAT(owner_id ORDER BY owner_id SEPARATOR ',') AS room_member FROM cap_chat_room GROUP BY room_id) WHERE room_member=:room_member");
$stmt->bindValue(":room_member",$room_member,PDO::PARAM_STR);
$status = $stmt->execute();

if($status==false) {
    sql_error($stmt);
  }else{
    $row = $stmt->fetch();
}

echo $row["room_member"];
?>
