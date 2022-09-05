<?php
session_start();
include("funcs.php");
sschk();
$pdo = db_conn();

$stmt   = $pdo->prepare("SELECT * FROM cap_owner");
$status = $stmt->execute();

$view="";
if($status==false) {
  sql_error($stmt);
}else{
  $view .= '<table>';
  $view .= '<tr>';
  $view .= '<th rowspan="2">船主</th>';
  $view .= '<th rowspan="2">所在地</th>';
  $view .= '<th rowspan="2">資本金 (百万円)</th>';
  $view .= '<th rowspan="2">従業員数 (人)</th>';
  $view .= '<th rowspan="2">保有隻数</th>';
  $view .= '<th colspan="4">関心事項</th>';
  $view .= '</tr>';
  $view .= '<tr>';
  $view .= '<th>運航コスト</th>';
  $view .= '<th>船員・安全運航</th>';
  $view .= '<th>船主グループ化</th>';
  $view .= '<th>脱炭素化</th>';
  $view .= '</tr>';  
  while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .= '<tr>';
    $view .= '<td>'.h($r["owner_name"]).'</td>';
    $view .= '<td>'.h($r["p_region"]).h($r["p_locality"]).'</td>';
    $view .= '<td>'.number_format(h($r["owner_capital"])/1000000).'</td>';
    $view .= '<td>'.number_format(h($r["owner_employee"])).'</td>';
    $stmt2 = $pdo->prepare("SELECT COUNT(*) as cnt_number FROM cap_vessel WHERE owner_id=?");
    $stmt2->execute(array($r["id"]));
    $record = $stmt2->fetch();
    $view .= '<td>'.number_format(h($record["cnt_number"])).'</td>';
    $view .= '<td>'.h($r["owner_cost"]).'</td>';
    $view .= '<td>'.h($r["owner_crew_mng"]).'</td>';
    $view .= '<td>'.h($r["owner_group"]).'</td>';
    $view .= '<td>'.h($r["owner_decarbon"]).'</td>';
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
  <title>CAP - 船主検索</title>
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
      <div id="table_owner"><?=$view?></div>
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
          document.querySelector("#table_owner").innerHTML=response.data;
        }
    }).catch(function (error) {
        console.log(error);
    }).then(function () {
        console.log("Last");
    });
  });
</script>
</html>