<?php
session_start();
include_once("funcs.php");
$pdo = db_conn();

$id = $_SESSION["id"];
$number_members = $_POST["number_members"];
$room_id = mt_rand();

$stmt3 = $pdo->prepare("INSERT INTO cap_chat_room(room_id, owner_id) VALUES(:room_id, :owner_id)");
$stmt3->bindValue(":room_id", $room_id, PDO::PARAM_INT);
$stmt3->bindValue(":owner_id", $id, PDO::PARAM_INT);
$status3 = $stmt3->execute();

$stmt4 = $pdo->prepare("SELECT * FROM cap_owner WHERE id=:id");
$stmt4->bindValue(":id",$id,PDO::PARAM_INT);
$status4 = $stmt4->execute();
if($status4==false) {
  sql_error($stmt4);
}else{
  $row4 = $stmt4->fetch();
};
$room_name = $row4["owner_name"];

$i = 1;
while($i <= $number_members){
  $owner_name = $_POST["owner_name_".$i];
  $room_name .= " / ".$owner_name;
  $i += 1;
};
$stmt5 = $pdo->prepare("INSERT INTO cap_chat_name(room_id, room_name) VALUES(:room_id, :room_name)");
$stmt5->bindValue(":room_id", $room_id, PDO::PARAM_INT);
$stmt5->bindValue(":room_name", $room_name, PDO::PARAM_STR);
$status5 = $stmt5->execute();

$i = 1;
while($i <= $number_members){
  $owner_name = $_POST["owner_name_".$i];
  $stmt = $pdo->prepare("SELECT * FROM cap_owner WHERE owner_name=:owner_name");
  $stmt->bindValue(":owner_name",$owner_name,PDO::PARAM_STR);
  $status = $stmt->execute();
  if($status==false) {
    sql_error($stmt);
  }else{
    $row = $stmt->fetch();
  };
  $stmt2 = $pdo->prepare("INSERT INTO cap_chat_room(room_id, owner_id) VALUES(:room_id, :owner_id)");
  $stmt2->bindValue(":room_id",$room_id,PDO::PARAM_INT);
  $stmt2->bindValue(":owner_id",$row["id"],PDO::PARAM_INT);
  $status2 = $stmt2->execute();
  $i += 1;
};

?>
