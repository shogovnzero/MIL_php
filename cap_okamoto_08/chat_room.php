<?php
session_start();
$id = $_SESSION["id"];
$room_id = $_GET["room_id"]; 
include_once("funcs.php");
sschk();
$pdo = db_conn();

$stmt   = $pdo->prepare("SELECT COUNT(*) as find_owner FROM cap_chat_room WHERE room_id=? AND owner_id=?");
$stmt->execute(array($room_id, $id));
$record = $stmt->fetch();
if($record["find_owner"] == 0){
  redirect("chat_list.php");
}

$stmt2   = $pdo->prepare("SELECT * FROM cap_chat_name WHERE room_id=:room_id");
$stmt2->bindValue(':room_id', $room_id, PDO::PARAM_INT);
$status2 = $stmt2->execute();
if($status2==false) {
  sql_error($stmt2);
}else{
  $row2 = $stmt2->fetch();
}
$rooms="";
$threads="";
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>CAP - <?=$row2["room_name"]?></title>
  <link rel="stylesheet" href="./css/reset.css">
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/flick/jquery-ui.css">
  <link rel="stylesheet" href="./css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
</head>

<body>
  <div class="container">
    <header>
      <?php include("menu.php"); ?>
    </header>
    <main>
      <div class="base">
        <div class="area_list">
          <div id="rooms"><?=$rooms?></div>
        </div>
        <div class="area_room">
          <div id="area_room_name"><?=$row2["room_name"]?></div>
          <div id="area_output">
            <div id="area_threads"><?=$threads?></div>
          </div>
          <div class="area_input">
            <div class="area_message">
              <textarea id="message" name="message"></textarea>
              <input id="id" type="hidden" name="id" value="<?=$id?>">
              <input id="room_id" type="hidden" name="room_id" value="<?=$room_id?>">
              <input id="sender_id" type="hidden" name="sender_id" value="<?=$id?>">
              <input id="thread_flg" type="hidden" name="thread_flg" value="1">
            </div>
            <div class="area_btn">
              <input id="send" class="material-icons" type="submit" value="send">
            </div>
          </div>
        </div>
        <div id="area_thread" style="display: none">
          <?=$thread?>
          <div class="area_reply">
            <textarea id="message_reply" name="message"></textarea>
            <input id="id_reply" type="hidden" name="id" value="<?=$id?>">
            <input id="room_id_reply" type="hidden" name="room_id" value="<?=$room_id?>">
            <input id="sender_id_reply" type="hidden" name="sender_id" value="<?=$id?>">
            <input id="thread_flg_reply" type="hidden" name="thread_flg" value="0">
          </div>
          <div class="area_btn">
            <input id="send_reply" class="material-icons" type="submit" value="send">
          </div>
        </div>
      </div>
    </main>
    <footer>
    </footer>
  </div>
</body>
<script>
  // rooms
  function reload_rooms() {
    const params = new URLSearchParams();
    params.append("id", $("#id").val());
    axios.post('chat_rooms_reload_process.php',params).then(function (response) {
      console.log(typeof response.data);
      if(response.data){
        document.querySelector("#rooms").innerHTML=response.data;
      }
    }).catch(function (error) {
      console.log(error);
    }).then(function () {
      console.log("Last");
    });
    setTimeout(function() {reload_rooms()},5000);
  }
  reload_rooms();

  // threads
  $("#send").on("click", function(){
    const params = new URLSearchParams();
    params.append("id", $("#id").val());
    params.append("message", $("#message").val());
    params.append("room_id", $("#room_id").val());
    params.append("sender_id", $("#sender_id").val());
    params.append("thread_flg", $("#thread_flg").val());
    axios.post('chat_send_process.php',params).then(function (response) {
        console.log(typeof response.data);
        if(response.data){
          document.querySelector("#area_threads").innerHTML=response.data;
        }
    }).catch(function (error) {
        console.log(error);
    }).then(function () {
        console.log("Last");
        document.getElementById("message").value = "";
    });
  });

  $(document).on("click",".btn_update", function(){
    const params = new URLSearchParams();
    params.append("chat_id", $(this).attr('name'));
    params.append("id", $("#id").val());
    params.append("room_id", $("#room_id").val());
    axios.post('chat_update_process.php',params).then(function (response) {
        console.log(typeof response.data);
        if(response.data){
          document.querySelector("#area_threads").innerHTML=response.data;
        }
    }).catch(function (error) {
        console.log(error);
    }).then(function () {
        console.log("Last");
    });
  });

  $(document).on("click",".btn_delete", function(){
    const params = new URLSearchParams();
    params.append("chat_id", $(this).attr('name'));
    params.append("id", $("#id").val());
    params.append("room_id", $("#room_id").val());
    axios.post('chat_delete_process.php',params).then(function (response) {
        console.log(typeof response.data);
        if(response.data){
          document.querySelector("#area_threads").innerHTML=response.data;
        }
    }).catch(function (error) {
        console.log(error);
    }).then(function () {
        console.log("Last");
    });
  });

  $(document).on("click",".btn_reply", function(){
    const params = new URLSearchParams();
    $("#area_thread").show();
    params.append("id", $("#id").val());
    params.append("room_id", $("#room_id").val());
    params.append("chat_id", $(this).attr('name'));
    axios.post('chat_thread_reload_process.php',params).then(function (response) {
      console.log(typeof response.data);
      if(response.data){
        document.querySelector("#area_thread").innerHTML=response.data;
      }
    }).catch(function (error) {
      console.log(error);
    }).then(function () {
      console.log("Last");
    });
  });

  function reload_threads() {
    const params = new URLSearchParams();
    params.append("id", $("#id").val());
    params.append("room_id", $("#room_id").val());
    axios.post('chat_threads_reload_process.php',params).then(function (response) {
      console.log(typeof response.data);
      if(response.data){
        document.querySelector("#area_threads").innerHTML=response.data;
      }
    }).catch(function (error) {
      console.log(error);
    }).then(function () {
      console.log("Last");
    });
    setTimeout(function() {reload_threads()},5000);
  }
  reload_threads();

</script>
</html>