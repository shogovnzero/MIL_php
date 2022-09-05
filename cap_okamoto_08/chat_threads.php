<?php
$id = $_SESSION["id"];
include_once("funcs.php");
$pdo = db_conn();

$threads="";
$room_name="";
?>

<div class="area_room">
  <div id="area_room_name"><?=$room_name?></div>
  <div id="area_output">
    <div id="area_threads"><?=$threads?></div>
  </div>
  <div class="area_input">
    <div class="area_message">
      <textarea id="message" name="message"></textarea>
      <input id="id" type="hidden" name="id" value="<?=$id?>">
      <input id="sender_id" type="hidden" name="sender_id" value="<?=$id?>">
      <input id="thread_flg" type="hidden" name="thread_flg" value="1">
      <input id="thread_id" type="hidden" name="thread_id" value="">
    </div>
    <div class="area_btn">
      <input id="send" class="material-icons" type="submit" name="room_id" value="send">
    </div>
  </div>
</div>

<script>
  // threads
  $("#send").on("click", function(){
    const params = new URLSearchParams();
    params.append("id", $("#id").val());
    params.append("message", $("#message").val());
    params.append("room_id", $("#send").attr('name'));
    params.append("sender_id", $("#sender_id").val());
    params.append("thread_flg", $("#thread_flg").val());
    params.append("thread_id", $("#thread_id").val());
    axios.post('chat_thread_send_process.php',params).then(function (response) {
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
    params.append("room_id", $("#send").attr('name'));
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
    params.append("room_id", $("#send").attr('name'));
    axios.post('chat_thread_delete_process.php',params).then(function (response) {
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
    params.append("thread_id", $(this).attr('name'));
    var value = $('#send_reply').attr('name', $(this).attr('name'));
    axios.post('chat_thread_reload_process.php',params).then(function (response) {
      console.log(typeof response.data);
      if(response.data){
        document.querySelector("#thread").innerHTML=response.data;
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
    params.append("room_id", $("#send").attr('name'));
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

