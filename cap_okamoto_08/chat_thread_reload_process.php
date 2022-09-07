<?php
include_once("funcs.php");

$id = $_POST["id"];
$thread_id = $_POST["thread_id"];

$pdo = db_conn();

$stmt   = $pdo->prepare("SELECT chat_id,room_id,sender_id,message,thread_flg,thread_id,AAA.indate,owner_name,owner_img FROM (SELECT * FROM cap_chat_content WHERE thread_id=:thread_id) AS AAA INNER JOIN cap_owner ON sender_id=cap_owner.id");
$stmt->bindValue(':thread_id', $thread_id, PDO::PARAM_INT);
$status = $stmt->execute();

$thread="";

if($status==false) {
  sql_error($stmt);
}else{
  $stmt2   = $pdo->prepare("SELECT chat_id,room_id,sender_id,message,thread_flg,thread_id,AAA.indate,owner_name,owner_img FROM (SELECT * FROM cap_chat_content WHERE chat_id=:thread_id) AS AAA INNER JOIN cap_owner ON sender_id=cap_owner.id");
  $stmt2->bindValue(':thread_id', $thread_id, PDO::PARAM_INT);
  $status2 = $stmt2->execute();
  if($status2==false) {
    sql_error($stmt2);
  }else{
    while( $r2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
      $thread .= '<div class="thread">';
      $thread .=   '<div class="area_img"><div class="owner_img">';
      if (empty($r2["owner_img"]) || $r2["owner_img"] == '1' || $r2["owner_img"] == '2'){
        $thread .=  '<span class="material-icons-outlined">groups</span>';
      } else {
        $thread .=   '<img src="img/'.$r2["owner_img"].'">';
      }
      $thread .=   '</div></div>';
      $thread .=   '<div class="area_content">';
      $thread .=     '<div class="info"><div class="owner_name">'.$r2["owner_name"].'</div><div class="dt_sent">'.$r2["indate"].'</div></div>';
      $thread .=     '<div id=inthread_chat_id_'.$r2["chat_id"].' class="message_thread">'.$r2["message"].'</div>';
      $thread .=     '<div class="command_thread">';
      $thread .=       '<button class="btn_like">いいね</button>';
      if($r2["sender_id"] == $id){
        $thread .=     '<button class="btn_inthread_update" name='.$r2["chat_id"].'>編集</button>';
        $thread .=     '<button class="btn_delete" name='.$r2["chat_id"].'>削除</button>';
      }
      $thread .=     '</div>';
      $thread .=   '</div>';
      $thread .= '</div>';
    }
  }
  while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){
    $thread .= '<div class="thread">';
    $thread .=   '<div class="area_img"><div class="owner_img">';
    if (empty($r["owner_img"]) || $r["owner_img"] == '1' || $r["owner_img"] == '2'){
      $thread .=  '<span class="material-icons-outlined">groups</span>';
    } else {
      $thread .=   '<img src="img/'.$r["owner_img"].'">';
    }
    $thread .=   '</div></div>';
    $thread .=   '<div class="area_content">';
    $thread .=     '<div class="info"><div class="owner_name">'.$r["owner_name"].'</div><div class="dt_sent">'.$r["indate"].'</div></div>';
    $thread .=     '<div id=inthread_chat_id_'.$r["chat_id"].' class="message_thread">'.$r["message"].'</div>';
    $thread .=     '<div class="command_thread">';
    $thread .=       '<button class="btn_like">いいね</button>';
    if($r["sender_id"] == $id){
      $thread .=     '<button class="btn_inthread_update" name='.$r["chat_id"].'>編集</button>';
      $thread .=     '<button class="btn_delete" name='.$r["chat_id"].'>削除</button>';
    }
    $thread .=     '</div>';
    $thread .=   '</div>';
    $thread .= '</div>';
  }
}

echo $thread;
?>