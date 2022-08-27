<?php
session_start();
$id = $_SESSION["id"];
include("funcs.php");
sschk();
$pdo = db_conn();

$stmt   = $pdo->prepare("SELECT * FROM cap_owner");
$status = $stmt->execute();

$view="";
if($status==false) {
  sql_error($stmt);
}else{
  while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .= "<p>".'<a href="owner_page.php?id='.h($r["id"]).'">'."船主ページ</a>".h($r["owner_name"])."|".h($r["p_region"]).h($r["p_locality"])."</p>";
  }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>CAP - 船主検索</title>
  <link rel="stylesheet" href="./css/reset.css">
  <link rel="stylesheet" href="./css/style.css">
</head>

<body>
  <div class="container">
    <header>
      <?php include("menu.php"); ?>
    </header>
    <main>
      <input type="text" id="keyword">
      <button id="search">検索</button>
      <div id="view"><?=$view?></div>
    </main>
    <footer>
    </footer>
  </div>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
  $("#search").on("click", function(){
    const params = new URLSearchParams();
    params.append("keyword", $("#keyword").val());
    axios.post('owner_search_process.php',params).then(function (response) {
        console.log(typeof response.data);
        if(response.data){
          document.querySelector("#view").innerHTML=response.data;
        }
    }).catch(function (error) {
        console.log(error);
    }).then(function () {
        console.log("Last");
    });
  });
</script>
</html>