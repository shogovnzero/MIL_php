<?php
session_start();
include("funcs.php");
sschk();
$pdo = db_conn();

$stmt   = $pdo->prepare("SELECT * FROM cap_vessel INNER JOIN cap_owner ON cap_vessel.owner_id=cap_owner.id");
$status = $stmt->execute();

$view="";
if($status==false) {
  sql_error($stmt);
}else{
  $view .= '<table>';
  $view .= '<tr>';
  $view .= '<th>船名</th>';
  $view .= '<th>船種</th>';
  $view .= '<th>DWT [t]</th>';
  $view .= '<th>LOA [m]</th>';
  $view .= '<th>造船所</th>';
  $view .= '<th>建造年</th>';
  $view .= '<th>燃料</th>';
  $view .= '<th>定員数</th>';
  $view .= '<th>主要寄港先</th>';
  $view .= '<th>船主</th>';
  $view .= '</tr>';  
  while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .= '<tr>';
    $view .= '<td>'.'<a href="vessel_page.php?id='.h($r["vessel_id"]).'">'.h($r["vessel_name_jp"]).'</a>'.'</td>';
    $view .= '<td>'.h($r["vessel_type"]).'</td>';
    $view .= '<td>'.number_format(h($r["vessel_dwt"])).'</td>';
    $view .= '<td>'.number_format(h($r["vessel_loa"]),1).'</td>';
    $view .= '<td>'.h($r["vessel_sy"]).'</td>';
    $view .= '<td>'.substr(h($r["vessel_built"]),0,4).'年</td>';
    $view .= '<td>'.h($r["vessel_fuel"]).'</td>';
    $view .= '<td>'.number_format(h($r["vessel_crew"])).'</td>';
    $view .= '<td>'.h($r["vessel_trade_port"]).'</td>';
    $view .= '<td>'.'<a href="owner_page.php?id='.h($r["id"]).'">'.h($r["owner_name"]).'</a>'.'</td>';
    $view .= '</tr>';
  }
  $view .= '</table>';
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>CAP - 船舶検索</title>
  <link rel="stylesheet" href="./css/reset.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
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
      <input type="text" id="keyword">
      <button id="search">検索</button>
      <div id="table_vessel"><?=$view?></div>
    </main>
    <footer>
    </footer>
  </div>
</body>

<script>
  $("#search").on("click", function(){
    const params = new URLSearchParams();
    params.append("keyword", $("#keyword").val());
    axios.post('vessel_search_process.php',params).then(function (response) {
        console.log(typeof response.data);
        if(response.data){
          document.querySelector("#table_vessel").innerHTML=response.data;
        }
    }).catch(function (error) {
        console.log(error);
    }).then(function () {
        console.log("Last");
    });
  });
</script>
</html>
