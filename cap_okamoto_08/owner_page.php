<?php
session_start();
$owner_id = $_GET["id"];
include("funcs.php");
sschk();
$pdo = db_conn();

if($owner_id==$_SESSION["id"]){
  redirect("index.php");
}

$stmt   = $pdo->prepare("SELECT * FROM cap_vessel INNER JOIN cap_owner ON cap_vessel.owner_id=cap_owner.id WHERE cap_owner.id=:id");
$stmt->bindValue(":id",$owner_id,PDO::PARAM_INT);
$status = $stmt->execute();

$view="";
if($status==false) {
  sql_error($stmt);
}else{
  $view .= '<table class="owner_vessel">';
  $view .= '<tr>';
  $view .= '<th>船名</th>';
  $view .= '<th>船種</th>';
  $view .= '<th>DWT[t]</th>';
  $view .= '<th>LOA[m]</th>';
  $view .= '<th>造船所</th>';
  $view .= '<th>建造年</th>';
  $view .= '<th>燃料</th>';
  $view .= '<th>定員数</th>';
  $view .= '<th>主要寄港先</th>';
  $view .= '</tr>';  
  while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .= '<tr>';
    $view .= '<td>'.'<a href="vessel_page.php?id='.h($r["vessel_id"]).'">'.h($r["vessel_name_jp"]).'</a>'.'</td>';
    $view .= '<td>'.h($r["vessel_type"]).'</td>';
    $view .= '<td>'.number_format(h($r["vessel_dwt"])).'</td>';
    $view .= '<td>'.number_format(h($r["vessel_loa"])).'</td>';
    $view .= '<td>'.h($r["vessel_sy"]).'</td>';
    $view .= '<td>'.substr(h($r["vessel_built"]),0,4).'年</td>';
    $view .= '<td>'.h($r["vessel_fuel"]).'</td>';
    $view .= '<td>'.number_format(h($r["vessel_crew"])).'</td>';
    $view .= '<td>'.h($r["vessel_trade_port"]).'</td>';
    $view .= '<td></td>';
    $view .= '</tr>';    
  }
  $view .= '</table>';
}

$stmt2   = $pdo->prepare("SELECT * FROM cap_vessel INNER JOIN cap_owner ON cap_vessel.owner_id=cap_owner.id WHERE cap_owner.id=:id");
$stmt2->bindValue(":id",$owner_id,PDO::PARAM_INT);
$status2 = $stmt2->execute();

if($status2==false) {
  sql_error($stmt2);
}else{
  $row = $stmt2->fetch();
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>CAP - 船主ページ</title>
  <link rel="stylesheet" href="./css/reset.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Round|Material+Icons+Sharp|Material+Icons+Two+Tone" rel="stylesheet">
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
      <div class = "area_top">
        <div class = "area_logo">
          <?php if (empty($row["owner_img"]) || $row["owner_img"] == '1' || $row["owner_img"] == '2'): ?>
            <span class="material-icons-outlined">groups</span>
          <?php else: ?>
            <img src="img/<?=$row["owner_img"]?>">
          <?php endif ?>
        </div>
        <div class = "area_description">
          <div class = "owner_name"><?=$row["owner_name"]?></div>
          <div class = "owner_info">
            <table>
              <tr>
                <th>代表者</th>
                <td><?=$row["owner_ceo"]?></td>
              </tr>
              <tr>
                <th>会社所在地</th>
                <td>〒<?=$row["p_postal_code"]." ".$row["p_region"].$row["p_locality"].$row["p_street_address"]." ".$row["p_extended_address"]?></td>
              </tr>
              <tr>
                <th>創立年月日</th>
                <td><?=date('Y年m月d日', strtotime($row["owner_foundation"]))?></td>
              </tr>
              <tr>
                <th>資本金</th>
                <td><?=number_format($row["owner_capital"])?>円</td>
              </tr>
              <tr>
                <th>従業員数</th>
                <td><?=number_format($row["owner_employee"])?>人</td>
              </tr>
              <tr>
                <th>会社URL</th>
                <td><a href="<?=$row["owner_url"]?>"><?=$row["owner_url"]?></a></td>
              </tr>
            </table>
          </div>
          <div class = "follow"></div>
        </div>
      </div>
      <div class = "area_main">
        <div class = "area_owner_vessel">
          <h3>保有船舶</h3>
          <div id="view"><?=$view?></div>
        </div>
        <div class = "area_owner_interest">
          <h3>関心事項</h3>
          <div class="owner_interest">
            <table>
              <tr>
                <th>運航コストの削減・見直し</th>
                <td><?=$row["owner_cost"]?></td>
              </tr>
              <tr>
                <th>船員・安全運航</th>
                <td><?=$row["owner_crew_mng"]?></td>
              </tr>
              <tr>
                <th>船主グループ化</th>
                <td><?=$row["owner_group"]?></td>
              </tr>
              <tr>
                <th>脱炭素化</th>
                <td><?=$row["owner_decarbon"]?></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </main>
    <footer>
    </footer>
  </div>
</body>