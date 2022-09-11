<?php
$id = $_SESSION["id"];
include_once("funcs.php");

$threads="";
$room_name="";
$room_member="";
$common_interest="";

$pdo = db_conn();
$stmt = $pdo->prepare("SELECT id, owner_name FROM `cap_owner` WHERE id <> :id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

$member_list = array();
if($status==false) {
  sql_error($stmt);
}else{
  while($r = $stmt->fetch(PDO::FETCH_ASSOC)){
    $member_list[] = $r["owner_name"];
  };
};
$member_list = json_encode($member_list);

?>


<div id="area_room_name">
  <div class="area_add_member" style="display:none">
    <input type="text" id="add_member_name">
    <form method="post">
      <div id="added_members"></div>
      <button id="create_new_room">新規作成</button>
    </form>
  </div>
  <p id="room_name"><?=$room_name?></p>
  <div id="area_room_member" class="material-icons-outlined area_room_info">
    group
    <div id="room_member" class="room_info"><?=$room_member?></div>
  </div>
  <div id="area_common_interest" class="material-icons-outlined area_room_info">
    favorite
    <div id="common_interest" class="room_info"><?=$common_interest?></div>
  </div>
</div>

<div id="area_output">
  <div id="area_threads"><?=$threads?></div>
</div>

<div class="area_input" style="display:none">
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



<script>
  $(document).ready(function(){
    $('#add_member_name').autocomplete({
      source: <?=$member_list?>
    });
  });

  var i = 1;
  $('#add_member_name').change(function(){
    var added_member_name = $(this).val();
    var member_list = <?=$member_list?>;
    if(member_list.indexOf(added_member_name) != -1){
      var added_member = "";
      added_member += `<p id="added_member_${i}">${added_member_name}</p>`;
      $("#added_members").append(added_member);
      $(this).val('');
      i += 1;
    }
  });

  $("#create_new_room").on("click", function(){
    const params = new URLSearchParams();
    var j = 1;
    while(j <= i){
      params.append(`owner_name_${j}`, $(`#added_member_${j}`).text());
      j += 1;
    };
    params.append("number_members", i-1);
    console.log(params);
    axios.post('chat_new_room_process.php',params).then(function (response) {
      console.log(typeof response.data);
    }).catch(function (error) {
        console.log(error);
    }).then(function () {
        console.log("New Room Created");
    });
  });

  $('#area_room_member').on({
    "mouseenter": function() {
      const params = new URLSearchParams();
      params.append("room_id", $("#send").attr('name'));
      axios.post('chat_member_process.php',params).then(function (response) {
        console.log(typeof response.data);
        if(response.data){
          document.querySelector("#room_member").innerHTML=response.data;
        };
      }).catch(function (error) {
          console.log(error);
      }).then(function () {
          console.log("Room Member");
      });
      $("#room_member").show();
    },
    "mouseleave": function() {
      $("#room_member").hide();
    }
  });

  $('#area_common_interest').on({
    "mouseenter": function() {
      const params = new URLSearchParams();
      params.append("room_id", $("#send").attr('name'));
      axios.post('chat_interest_process.php',params).then(function (response) {
        console.log(typeof response.data);
        if(response.data){
          document.querySelector("#common_interest").innerHTML=response.data;
        };
      }).catch(function (error) {
          console.log(error);
      }).then(function () {
          console.log("Common Interest");
      });
      $("#common_interest").show();
    },
    "mouseleave": function() {
      $("#common_interest").hide();
    }
  });

  $("#room_name").on("click", function(){
    if(!$(this).hasClass('on')){
      $(this).addClass('on');
      var txt = $(this).text();
      $(this).html('<input id="room_rename" type="text" value="'+txt+'" />');
      $('#room_name > #room_rename').focus().blur(function(){
        var inputVal = $(this).val();
        if(inputVal===''){
          inputVal = this.defaultValue;
        };
        $(this).parent().removeClass('on').text(inputVal);
        const params = new URLSearchParams();
        params.append("room_name", inputVal);
        params.append("room_id", $("#send").attr('name'));
        axios.post('chat_room_rename_process.php',params).then(function (response) {
            console.log(typeof response.data);
            if(response.data){
              document.querySelector("#room_name").innerHTML=response.data;
            }
        }).catch(function (error) {
            console.log(error);
        }).then(function () {
            console.log("Room Renamed");
        });
      });
    };
  });

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

  var threads = "";
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
      console.log("Threads Reloaded");
    });
    threads = setTimeout(function() {reload_threads()},5000);
  }
  reload_threads();

  $(document).on("click",".btn_update", function(){
    clearTimeout(threads);
    const chat_id = $(this).attr('name');
    const message = "#chat_id_" + chat_id;
    if(!$(message).hasClass('on')){
      $(message).addClass('on');
      var txt = $(message).text();
      $(message).html('<input type="text" value="'+txt+'" />');
      $(`${message} > input`).focus().blur(function(){
        var inputVal = $(this).val();
        if(inputVal===''){
          inputVal = this.defaultValue;
        };
        $(this).parent().removeClass('on').text(inputVal);
        const params = new URLSearchParams();
        params.append("chat_id", chat_id);
        params.append("message", inputVal);
        axios.post('chat_update_process.php',params).then(function (response) {
            console.log(typeof response.data);
            if(response.data){
              document.querySelector(`${message}`).innerHTML=response.data;
            }
        }).catch(function (error) {
            console.log(error);
        }).then(function () {
            console.log("Threads Updated");
        });
        threads = setTimeout(function() {reload_threads()},5000);
      });
    };
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



</script>

