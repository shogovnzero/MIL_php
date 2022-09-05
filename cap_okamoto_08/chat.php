<?php
session_start();
$id = $_SESSION["id"];
include_once("funcs.php");
sschk();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>CAP - チャット</title>  
  <link rel="stylesheet" href="./css/reset.css">
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/flick/jquery-ui.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
</head>

<input id="id" type="hidden" name="id" value="<?=$id?>">

<body>
  <div class="container">
    <header>
      <?php include_once("menu.php"); ?>
    </header>
    <main>
      <div class="base">
        <div id="area_rooms">
          <?php include_once("chat_rooms.php"); ?>
        </div>
        <div id="area_room">
          <?php include_once("chat_threads.php"); ?>
        </div>
        <div id="area_thread" style="display:none">
          <?php include_once("chat_thread.php"); ?>
        </div>
      </div>
    </main>
    <footer>
    </footer>
  </div>
</body>

<script>
</script>
</html>