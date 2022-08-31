<?php
include_once("funcs.php");

$id = $_POST["id"];
$room_id = $_POST["room_id"];
$thread_flg = "1";

$pdo = db_conn();

$stmt   = $pdo->prepare("SELECT chat_id,room_id,sender_id,message,thread_flg,AAA.indate,owner_name FROM (SELECT * FROM cap_chat_content WHERE room_id=:room_id AND thread_flg=:thread_flg) AS AAA INNER JOIN cap_owner ON sender_id=cap_owner.id");
$stmt->bindValue(':room_id', $room_id, PDO::PARAM_INT);
$stmt->bindValue(':thread_flg', $thread_flg, PDO::PARAM_INT);
$status = $stmt->execute();

$threads="";

if($status==false) {
  sql_error($stmt);
}else{
  while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){
    $threads .= '<div class="thread">';
    $threads .=   '<div class="area_img"><div class="owner_img"></div></div>';
    $threads .=   '<div class="area_content">';
    $threads .=     '<div class="info"><div class="owner_name">'.$r["owner_name"].'</div><div class="dt_sent">'.$r["indate"].'</div></div>';
    $threads .=     '<div class="message_thread">'.$r["message"].'</div>';
    $threads .=     '<div class="command_thread">';
    $threads .=       '<button class="btn_like">いいね</button>';
    $threads .=       '<button class="btn_look" name='.$r["chat_id"].'>閲覧</button>';
    $threads .=       '<button class="btn_reply" name='.$r["chat_id"].'>返信</button>';
    if($r["sender_id"] == $id){
      $threads .=     '<button class="btn_update" name='.$r["chat_id"].'>編集</button>';
      $threads .=     '<button class="btn_delete" name='.$r["chat_id"].'>削除</button>';
    }
    $threads .=     '</div>';
    $threads .=   '</div>';
    $threads .= '</div>';
  }
}

echo $threads;
?>