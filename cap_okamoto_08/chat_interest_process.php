<?php
include_once("funcs.php");

$room_id = $_POST["room_id"];

$pdo = db_conn();

$stmt   = $pdo->prepare("SELECT room_id,owner_name,owner_cost,owner_crew_mng,owner_group,owner_decarbon FROM `cap_chat_room` INNER JOIN `cap_owner` ON cap_chat_room.owner_id=cap_owner.id WHERE room_id = :room_id");
$stmt->bindValue(':room_id', $room_id, PDO::PARAM_INT);
$status = $stmt->execute();

$interests="";
if($status==false) {
  sql_error($stmt);
}else{
  $i = 1;
  while($r = $stmt->fetch(PDO::FETCH_ASSOC)){
    if($i == 1){
      $interest_1 = array_merge(explode(",",$r["owner_cost"]),explode(",",$r["owner_crew_mng"]),explode(",",$r["owner_group"]),explode(",",$r["owner_decarbon"]));
      $i += 1;
    }else{
      $interest_2 = array_merge(explode(",",$r["owner_cost"]),explode(",",$r["owner_crew_mng"]),explode(",",$r["owner_group"]),explode(",",$r["owner_decarbon"]));
      $interests = array_intersect($interest_1, $interest_2);
      $interest_1 = $interest_2;
      $i += 1;
    };
  };
};

$common_interest='<p class="info_title">共通の関心事項</p>';
foreach($interests as $interest){
  $common_interest .= "<p>".$interest."</p>";
};

echo $common_interest;
?>