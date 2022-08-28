<?php
session_start();
$id = $_SESSION["id"];
include("funcs.php");
sschk();
$pdo = db_conn();

$stmt = $pdo->prepare("SELECT * FROM cap_owner WHERE id=:id");
$stmt->bindValue(":id",$id,PDO::PARAM_INT);
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
  <title>CAP - マイページ情報更新</title>
  <link rel="stylesheet" href="./css/reset.css">
  <link rel="stylesheet" href="./css/style.css">
  <script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>
</head>

<body>
    <div class="container">
        <header>
          <?php include("menu.php"); ?>
        </header>
        <main>
          <h3>会社概要</h3>
          <form class="h-adr" method="post" action="mypage_update_process.php">
            <table class="owner_info">
              <tr>
                <td>会社名<span id="required">*</span></td>
                <td><input type="text" name="owner_name" value="<?=$row["owner_name"]?>" required></td>
              </tr>
              <tr>
                <td>代表者<span id="required">*</span></td>
                <td><input type="text" name="owner_ceo" value="<?=$row["owner_ceo"]?>" required></td>
              </tr>
              <tr>
                <td>会社URL</td>
                <td><input type="url" name="owner_url" value="<?=$row["owner_url"]?>"></td>
              </tr>
              <tr>
                <td>創立年月日</td>
                <td><input type="date" name="owner_foundation" value="<?=$row["owner_foundation"]?>"></td>
              </tr>
              <tr>
                <td>資本金</td>
                <td><input type="number" name="owner_capital" value="<?=$row["owner_capital"]?>"></td>
              </tr>
              <tr>
                <td>従業員数</td>
                <td><input type="number" name="owner_employee" value="<?=$row["owner_employee"]?>"></td>
              </tr>
            </table>          
            <span class="p-country-name" style="display:none;">Japan</span>
            <table class="owner_info">
              <tr>
                <td>会社所在地</td>
                <td></td>
              </tr>
              <tr>
                <td>郵便番号<span id="required">*</span></td>
                <td><input type="text" class="p-postal-code" name="p_postal_code" value="<?=$row["p_postal_code"]?>" required></td>
              </tr>
              <tr>
                <td>都道府県<span id="required">*</span></td>
                <td><input type="text" class="p-region" name="p_region" value="<?=$row["p_region"]?>" readonly></td>
              </tr>
              <tr>
                <td>市区町村<span id="required">*</span><p id="example">(例: 兵庫県西宮市)</p></td>
                <td><input type="text" class="p-locality" name="p_locality" value="<?=$row["p_locality"]?>" readonly></td>
              </tr>
              <tr>
                <td>町域・番地<span id="required">*</span><p id="example">(例: 大社町1-1)</p></td>
                <td><input type="text" class="p-street-address" name="p_street_address" value="<?=$row["p_street_address"]?>" required></td>
              </tr>
              <tr>
                <td>建物名など<p id="example">(例: ○○マンション101号)</p></td>
                <td><input type="text" class="p-extended-address" name="p_extended_address" value="<?=$row["p_extended_address"]?>"></td>
              </tr>
              <input type="hidden" name="id" value="<?=$id?>">
            </table>
            <input type="submit" value="送信">
          </form>
        </main>
        <footer>
        </footer>
    </div>
</body>