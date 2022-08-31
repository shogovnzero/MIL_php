<?php
include_once("funcs.php");

$id = $_POST["id"];

$pdo = db_conn();

$stmt   = $pdo->prepare("SELECT * FROM (SELECT id,cap_chat_name.room_id,room_name,room_member FROM cap_chat_name INNER JOIN (SELECT room_id, GROUP_CONCAT(owner_id ORDER BY owner_id SEPARATOR ',' ) as room_member FROM cap_chat_room GROUP BY room_id) AS xxx ON cap_chat_name.room_id=xxx.room_id ORDER BY cap_chat_name.id) as yyy WHERE FIND_IN_SET(:id,room_member)");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

$rooms="";
if($status==false) {
    sql_error($stmt);
}else{
    $rooms .= '<ul>';
    while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){
        $rooms .= '<li class="room" name="'.$r["room_id"].'">'.$r["room_name"]."</li>";
    }
    $rooms .= '</ul>';
}

echo $rooms;
?>
