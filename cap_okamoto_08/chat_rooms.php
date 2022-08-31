<?php
?>

<div id="window_rooms">
  <?=$rooms?>
</div>

<script>
  function reload_rooms() {
    const params = new URLSearchParams();
    params.append("id", $("#id").val());
    axios.post('chat_rooms_reload_process.php',params).then(function (response) {
      console.log(typeof response.data);
      if(response.data){
        document.querySelector("#window_rooms").innerHTML=response.data;
      }
    }).catch(function (error) {
      console.log(error);
    }).then(function () {
      console.log("Last");
    });
    setTimeout(function() {reload_rooms()},5000);
  }
  reload_rooms();

  $(document).on("click",".room",function(){
    const params = new URLSearchParams();
    params.append("id", $("#id").val());
    params.append("room_id", $(this).attr('name'));
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
    axios.post('chat_room_name_process.php',params).then(function (response) {
      console.log(typeof response.data);
      if(response.data){
        document.querySelector("#area_room_name").innerHTML=response.data;
      }
    }).catch(function (error) {
      console.log(error);
    }).then(function () {
      console.log("Last");
    });
  });

</script>
