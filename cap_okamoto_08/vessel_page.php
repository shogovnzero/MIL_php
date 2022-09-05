<?php
session_start();
$id = $_SESSION["id"];
$vessel_id = $_GET['id'];
include("funcs.php");
sschk();
$pdo = db_conn();

$stmt = $pdo->prepare("SELECT * FROM cap_vessel WHERE vessel_id=:vessel_id");
$stmt->bindValue(":vessel_id",$vessel_id,PDO::PARAM_INT);
$status = $stmt->execute();

if($status==false) {
  sql_error($stmt);
}else{
  $row = $stmt->fetch();
}

if($id == $row["owner_id"]){
  redirect("vessel_mine.php?id=$vessel_id");
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
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
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
      <div class="area_top">
        <div class="area_logo"></div>
        <div class="area_description">
          <table>
            <tr>
              <th>船舶登録番号</th>  
              <td><?=$row["vessel_number"]?></td>
            </tr>
            <tr>
              <th>船名(日本語)<span id="required">*</span></th>
              <td><?=$row["vessel_name_jp"]?></td>
            </tr>
            <tr>
              <th>船名(英文)<span id="required">*</span></th>
              <td><?=$row["vessel_name_en"]?></td>
            </tr>
            <tr>
              <th>船主名</th>
              <td><a href="owner_page.php?id=<?=$row2["id"]?>"><?=$row2["owner_name"]?></td>
            </tr>
            <tr>
              <th>船主URL</th>
              <td><a href="<?=$row2["owner_url"]?>"><?=$row2["owner_url"]?></a></td>
            </tr>
            <tr>
              <th>船主所在地</th>
              <td>〒<?=$row2["p_postal_code"]." ".$row2["p_region"].$row2["p_locality"].$row2["p_street_address"]." ".$row2["p_extended_address"]?></td>
            </tr>
          </table>
        </div>
      </div>
      <div class="area_main">
        <div class="area_vessel_category">
          <h3>運航情報</h3>
          <div class="vessel_operational">
            <table>
              <tr>
                <th>船舶管理会社</th>
                <td>
                  <?php if (empty($row["manager"])): ?>
                    自社管理
                  <?php else: ?>
                    <?=$row["manager"]?>
                  <?php endif ?>
                </td>
              </tr>
              <tr>
                <th>オペレーター</th>
                <td><?=$row["operator"]?></td>
              </tr>
              <tr>
                <th>船籍港</th>
                <td><?=$row["vessel_reg_port"]?></td>
              </tr>
              <tr>
                <th>主な寄港先(都道府県)</th>
                <td><?=$row["vessel_trade_pref"]?></td>
              </tr>
              <tr>
                <th>主な寄港先(港)</th>
                <td><?=$row["vessel_trade_port"]?></td>
              </tr>
            </table>
          </div>
        </div>
        <div class="area_vessel_category">
          <h3>船種・船型</h3>
          <div class="vessel_operational">
            <table>
              <tr>
                <th>船種</th>
                <td><?=$row["vessel_type"]?></td>
              </tr>
              <tr>
                <th>総トン数</th>
                <td><?=number_format($row["vessel_gt"])?> [GT]</td>
              </tr>
              <tr>
                <th>純トン数</th>
                <td><?=number_format($row["vessel_nt"])?> [NT]</td>
              </tr>
              <tr>
                <th>載貨重量トン数</th>
                <td><?=number_format($row["vessel_dwt"])?> [DWT]</td>
              </tr>
              <?php if ($row["vessel_type"]=="LNG船" || $row["vessel_type"]=="LPG船" || $row["vessel_type"]=="エタン船" || $row["vessel_type"]=="エチレン船" || $row["vessel_type"]=="アンモニア船" || $row["vessel_type"]=="液化CO2船" || $row["vessel_type"]=="液化水素船" || $row["vessel_type"]=="ガス船全般"): ?>
                <tr>
                  <th>タンク容積</th>
                  <td><?=number_format($row["vessel_tank"])?> [m3]</td>
                </tr>
              <?php endif ?>
              <?php if ($row["vessel_type"]=="コンテナ船"): ?>
                <tr>
                  <th>コンテナ積載数量</th>
                  <td><?=number_format($row["vessel_teu"])?> [TEU]</td>
                </tr>
              <?php endif ?>
              <tr>
                <th>全長/Loa</th>
                <td><?=number_format($row["vessel_loa"],1)?> [m]</td>
              </tr>
              <tr>
                <th>船幅/Beam</th>
                <td><?=number_format($row["vessel_beam"],1)?> [m]</td>
              </tr>
              <tr>
                <th>深さ/Depth</th>
                <td><?=number_format($row["vessel_depth"],1)?> [m]</td>
              </tr>
              <tr>
                <th>喫水/Draft</th>
                <td><?=number_format($row["vessel_draft"],1)?> [m]</td>
              </tr>
              <tr>
                <th>定員数</th>
                <td><?=number_format($row["vessel_crew"])?> [人]</td>
              </tr>
            </table>
          </div>
        </div>
        <div class="area_vessel_category">
          <h3>技術情報</h3>
          <div class="vessel_operational">
            <table>
              <tr>
                <th>造船所</th>
                <td><?=$row["vessel_sy"]?></td>
              </tr>
              <tr>
                <th>竣工年月日</th>
                <td><?=$row["vessel_built"]?></td>
              </tr>
              <tr>
                <th>主機型式</th>
                <td><?=$row["vessel_me"]?></td>
              </tr>
              <tr>
                <th>燃料</th>
                <td><?=$row["vessel_fuel"]?></td>
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
