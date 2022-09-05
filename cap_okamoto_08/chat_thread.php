<?php
$id = $_SESSION["id"];
include_once("funcs.php");
$pdo = db_conn();

$thread="";
$room_name="";
?>

<div id="thread"><?=$thread?></div>
<div class="area_reply">
  <textarea id="message_reply" name="message"></textarea>
  <input id="id_reply" type="hidden" name="id" value="<?=$id?>">
  <input id="room_id_reply" type="hidden" name="sender_id" value="">
  <input id="sender_id_reply" type="hidden" name="sender_id" value="<?=$id?>">
  <input id="thread_flg_reply" type="hidden" name="thread_flg" value="0">
</div>
<div class="area_btn">
  <input id="send_reply" class="material-icons" type="submit" name="thread_id" value="send">
</div>


<script>
  // threads
  $("#send_reply").on("click", function(){
    const params = new URLSearchParams();
    params.append("id", $("#id").val());
    params.append("message", $("#message_reply").val());
    params.append("room_id", $("#room_id_reply").val());
    params.append("sender_id", $("#sender_id_reply").val());
    params.append("thread_flg", $("#thread_flg_reply").val());
    params.append("thread_id", $("#send_reply").attr('name'));
    axios.post('chat_send_process.php',params).then(function (response) {
        console.log(typeof response.data);
        if(response.data){
          document.querySelector("#thread").innerHTML=response.data;
        }
    }).catch(function (error) {
        console.log(error);
    }).then(function () {
        console.log("Last");
        document.getElementById("message_reply").value = "";
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
          document.querySelector("#thread").innerHTML=response.data;
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
    params.append("thread_id", $("#send_reply").attr('name'));
    axios.post('chat_delete_process.php',params).then(function (response) {
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

  function reload_thread() {
    const params = new URLSearchParams();
    params.append("id", $("#id").val());
    params.append("thread_id", $("#send_reply").attr('name'));
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
    setTimeout(function() {reload_thread()},5000);
  }
  reload_thread();

</script>

