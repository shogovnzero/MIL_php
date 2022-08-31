<?php
session_start();
$id = $_SESSION["id"];
$vessel_id = $_GET['id'];
include("funcs.php");
sschk();
$pdo = db_conn();

$stmt = $pdo->prepare("SELECT * FROM cap_vessel WHERE id=:id");
$stmt->bindValue(":id",$vessel_id,PDO::PARAM_INT);
$status = $stmt->execute();

if($status==false) {
  sql_error($stmt);
}else{
  $row = $stmt->fetch();
}

$stmt2   = $pdo->prepare("SELECT * FROM cap_owner WHERE id=:id");
$stmt2->bindValue(":id",$row["owner_id"],PDO::PARAM_INT);
$status2 = $stmt2->execute();

$view="";
if($status2==false) {
  sql_error($stmt2);
}else{
  $row2 = $stmt2->fetch();
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>CAP - <?=$row["vessel_name_jp"]?></title>
  <link rel="stylesheet" href="./css/reset.css">
  <link rel="stylesheet" href="./css/style.css">
</head>

<body>
  <div class="container">
    <header>
      <?php include("menu.php"); ?>
    </header>
    <main>
      <div>船主情報</div>
      <div class = "owner_info">
        <table>
        <tr>
          <td>会社名</td>
          <td><?=$row2["owner_name"]?></td>
        </tr>
        <tr>
          <td>会社URL</td>
          <td><a href="<?=$row2["owner_url"]?>"><?=$row2["owner_url"]?></a></td>
        </tr>
        <tr>
          <td>会社所在地</td>
          <td>〒<?=$row2["p_postal_code"]." ".$row2["p_region"].$row2["p_locality"].$row2["p_street_address"]." ".$row2["p_extended_address"]?></td>
        </tr>
        </table>
      </div>
      <div>登録情報・運航情報</div>
      <table class="">
        <tr>
          <td>船舶登録番号</td>  
          <td><?=$row["vessel_number"]?></td>
        </tr>
        <tr>
          <td>船名(日本語)<span id="required">*</span></td>
          <td><?=$row["vessel_name_jp"]?></td>
        </tr>
        <tr>
          <td>船名(英文)<span id="required">*</span></td>
          <td><?=$row["vessel_name_en"]?></td>
        </tr>
        <tr>
          <td>船舶管理会社</td>
          <td>
            <?php if (empty($row["manager"])): ?>
              自社管理
            <?php else: ?>
              <?=$row["manager"]?>
            <?php endif ?>
          </td>
        </tr>
        <tr>
          <td>船籍港</td>
          <td><?=$row["vessel_reg_port"]?></td>
        </tr>
        <tr>
          <td>主な寄港先(都道府県)</td>
          <td><?=$row["vessel_trade_pref"]?></td>
        </tr>
        <tr>
          <td>主な寄港先(港)</td>
          <td><?=$row["vessel_trade_port"]?></td>
        </tr>
      </table>
      <div>船種・船型</div>
      <table class="">
        <tr>
          <td>船種</td>
          <td><?=$row["vessel_type"]?></td>
        </tr>
        <tr>
          <td>総トン数(GT)</td>
          <td><?=$row["vessel_gt"]?></td>
        </tr>
        <tr>
          <td>純トン数(NT)</td>
          <td><?=$row["vessel_nt"]?></td>
        </tr>
        <tr>
          <td>載貨重量トン数(DWT)</td>
          <td><?=$row["vessel_dwt"]?></td>
        </tr>
        <?php if ($row["vessel_type"]=="LNG船" || $row["vessel_type"]=="LPG船" || $row["vessel_type"]=="エタン船" || $row["vessel_type"]=="エチレン船" || $row["vessel_type"]=="アンモニア船" || $row["vessel_type"]=="液化CO2船" || $row["vessel_type"]=="液化水素船" || $row["vessel_type"]=="ガス船全般"): ?>
          <tr>
            <td>タンク容積(m3)</td>
            <td><?=$row["vessel_tank"]?></td>
          </tr>
        <?php endif ?>
        <?php if ($row["vessel_type"]=="コンテナ船"): ?>
          <tr>
            <td>コンテナ積載数量(TEU)</td>
            <td><?=$row["vessel_teu"]?></td>
          </tr>
        <?php endif ?>
        <tr>
          <td>全長/Loa(m)</td>
          <td><?=$row["vessel_loa"]?></td>
        </tr>
        <tr>
          <td>船幅/Beam(m)</td>
          <td><?=$row["vessel_beam"]?></td>
        </tr>
        <tr>
          <td>深さ/Depth(m)</td>
          <td><?=$row["vessel_depth"]?></td>
        </tr>
        <tr>
          <td>喫水/Draft(m)</td>
          <td><?=$row["vessel_draft"]?></td>
        </tr>
      </table>
      <div>技術情報</div>
      <table class="">
        <tr>
          <td>造船所</td>
          <td><?=$row["vessel_sy"]?></td>
        </tr>
        <tr>
          <td>竣工年月日</td>
          <td><?=$row["vessel_built"]?></td>
        </tr>
        <tr>
          <td>主機型式</td>
          <td><?=$row["vessel_me"]?></td>
        </tr>
        <tr>
          <td>燃料</td>
          <td><?=$row["vessel_fuel"]?></td>
        </tr>
      </table>
    </main>
    <footer>
    </footer>
  </div>
</body>
