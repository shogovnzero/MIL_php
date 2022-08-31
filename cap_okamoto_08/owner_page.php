<?php
session_start();
$owner_id = $_GET["id"];
include("funcs.php");
sschk();
$pdo = db_conn();

if($owner_id==$_SESSION["id"]){
  redirect("index.php");
}

$stmt = $pdo->prepare("SELECT * FROM cap_owner WHERE id=:id");
$stmt->bindValue(":id",$owner_id,PDO::PARAM_INT);
$status = $stmt->execute();

if($status==false) {
  sql_error($stmt);
}else{
  $row = $stmt->fetch();
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
  <link rel="stylesheet" href="./css/style.css">
</head>

<body>
  <div class="container">
    <header>
      <?php include("menu.php"); ?>
    </header>
    <main>
      <div class = "area_top">
        <div class = "area_logo"></div>
        <div class = "area_description">
          <div class = "owner_name"><?=$row["owner_name"]?></div>
          <div><a href="chat_create.php?id=<?=$id?>">chat with this owner</a></div>
          <div class = "owner_info">
            <table>
              <tr>
                <td>代表者</td>
                <td><?=$row["owner_ceo"]?></td>
              </tr>
              <tr>
                <td>会社URL</td>
                <td><a href="<?=$row["owner_url"]?>"><?=$row["owner_url"]?></a></td>
              </tr>
              <tr>
                <td>会社所在地</td>
                <td>〒<?=$row["p_postal_code"]." ".$row["p_region"].$row["p_locality"].$row["p_street_address"]." ".$row["p_extended_address"]?></td>
              </tr>
              <tr>
                <td>創立年月日</td>
                <td><?=$row["owner_foundation"]?></td>
              </tr>
              <tr>
                <td>資本金</td>
                <td><?=$row["owner_capital"]?></td>
              </tr>
              <tr>
                <td>従業員数</td>
                <td><?=$row["owner_employee"]?></td>
              </tr>
            </table>
          </div>
          <div class = "follow"></div>
        </div>
      </div>
      <div class = "area_main">
        <h3>保有・管理船舶</h3>
        <h3>関心事項</h3>
      </div>
    </main>
    <footer>
    </footer>
  </div>
</body>