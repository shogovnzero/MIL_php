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

if($id != $row["id"]){
  redirect("owner_page.php?id=$id");
}

$owner_cost = 0;
if (empty($POST)){
  $owner_cost = $row["owner_cost"];
} 
if (isset($_POST['owner_cost']) && is_array($_POST['owner_cost'])) {
  $fuel = implode(",",$_POST['owner_cost']);
}

$owner_crew_mng = 0;
if (empty($POST)){
  $owner_crew_mng = $row["owner_crew_mng"];
} 
if (isset($_POST['owner_crew_mng']) && is_array($_POST['owner_crew_mng'])) {
  $fuel = implode(",",$_POST['owner_crew_mng']);
}

$owner_group = 0;
if (empty($POST)){
  $owner_group = $row["owner_group"];
} 
if (isset($_POST['owner_group']) && is_array($_POST['owner_group'])) {
  $fuel = implode(",",$_POST['owner_group']);
}

$owner_decarbon = 0;
if (empty($POST)){
  $owner_decarbon = $row["owner_decarbon"];
} 
if (isset($_POST['owner_decarbon']) && is_array($_POST['owner_decarbon'])) {
  $fuel = implode(",",$_POST['owner_decarbon']);
}

if(!empty($_POST)){
  $_SESSION['join'] = $_POST;
  // 画像アップロードのみ先行
  if($_FILES["owner_img"]["size"]>0){
    $owner_img = fileUpload("owner_img","img");
    $pdo = db_conn();
    $stmt = $pdo->prepare("UPDATE cap_owner SET owner_img=:owner_img WHERE id=:id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->bindValue(':owner_img', $owner_img, PDO::PARAM_STR);
    $status = $stmt->execute();
  }
  redirect("mypage_update_process.php");
  exit();
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
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
  <script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>
</head>

<body>
    <div class="container">
        <header>
          <?php include("menu.php"); ?>
        </header>
        <main>
          <form class="h-adr" method="post" action="" enctype="multipart/form-data">
            <div class="area_top">
              <div>
                <div class="area_logo">
                  <?php if (empty($row["owner_img"]) || $row["owner_img"] == '1' || $row["owner_img"] == '2'): ?>
                    <span class="material-icons-outlined">groups</span>
                  <?php else: ?>
                    <img src="img/<?=$row["owner_img"]?>">
                  <?php endif ?>
                </div>
                <p>画像アップロード</p>
                <input type="file" accept="image/*" name="owner_img">
              </div>
              <div class="area_description">
                <div class = "owner_name"><input type="text" name="owner_name" placeholder="会社名" value="<?=$row["owner_name"]?>" required></div>
                <div class="owner_info">
                  <table>
                    <tr>
                      <th>代表者<span id="required">*</span></th>
                      <td><input type="text" name="owner_ceo" value="<?=$row["owner_ceo"]?>" required></td>
                    </tr>
                    <tr>
                      <th>会社所在地</th>
                      <td>
                        <table>
                          <span class="p-country-name" style="display:none;">Japan</span>
                          <tr>
                            <td>郵便番号<span id="required">*</span></td>
                            <td><input type="text" class="p-postal-code" name="p_postal_code" value="<?=$row["p_postal_code"]?>" required></td>
                          </tr>
                          <tr>
                            <td>都道府県<span id="required">*</span></td>
                            <td><input type="text" class="p-region" name="p_region" value="<?=$row["p_region"]?>" readonly></td>
                          </tr>
                          <tr>
                            <td>市区町村<span id="required">*</span><p class="example">(例: 兵庫県西宮市)</p></td>
                            <td><input type="text" class="p-locality" name="p_locality" value="<?=$row["p_locality"]?>" readonly></td>
                          </tr>
                          <tr>
                            <td>町域・番地<span id="required">*</span><p class="example">(例: 大社町1-1)</p></td>
                            <td><input type="text" class="p-street-address" name="p_street_address" value="<?=$row["p_street_address"]?>" required></td>
                          </tr>
                          <tr>
                            <td>建物名など<p class="example">(例: ○○マンション101号)</p></td>
                            <td><input type="text" class="p-extended-address" name="p_extended_address" value="<?=$row["p_extended_address"]?>"></td>
                          </tr>
                          <input type="hidden" name="id" value="<?=$id?>"> 
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <th>創業年</th>
                      <td><input type="date" name="owner_foundation" value="<?=$row["owner_foundation"]?>"></td>
                    </tr>
                    <tr>
                      <th>資本金</th>
                      <td><input type="number" name="owner_capital" value="<?=$row["owner_capital"]?>">円</td>
                    </tr>
                    <tr>
                      <th>従業員数</th>
                      <td><input type="number" name="owner_employee" value="<?=$row["owner_employee"]?>">人</td>
                    </tr>
                    <tr>
                      <th>会社URL</th>
                      <td><input type="url" name="owner_url" value="<?=$row["owner_url"]?>"></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>

            <div class="area_main">
              <div class = "area_owner_interest">
                <h3>関心事項</h3>
                <div class="owner_interest">
                  <table>
                    <tr>
                      <th>運航コストの削減・見直し</th>
                      <td>
                        <p><label><input type="checkbox" name="owner_cost[]" value="船員費の見直し" <?php if(strpos($owner_cost,"船員費の見直し") !== false){echo 'checked="checked"';}?>>船員費の見直し</label></p>
                        <p><label><input type="checkbox" name="owner_cost[]" value="燃料の共同調達" <?php if(strpos($owner_cost,"燃料の共同調達") !== false){echo 'checked="checked"';}?>>燃料の共同調達</label></p>
                        <p><label><input type="checkbox" name="owner_cost[]" value="機器資材の共同調達" <?php if(strpos($owner_cost,"機器資材の共同調達") !== false){echo 'checked="checked"';}?>>機器資材の共同調達</label></p>
                        <p><label><input type="checkbox" name="owner_cost[]" value="機器資材の在庫共有" <?php if(strpos($owner_cost,"機器資材の在庫共有") !== false){echo 'checked="checked"';}?>>機器資材の在庫共有</label></p>
                        <p><label><input type="checkbox" name="owner_cost[]" value="保険料の見直し" <?php if(strpos($owner_cost,"保険料の見直し") !== false){echo 'checked="checked"';}?>>保険料の見直し</label></p>
                        <p><label><input type="checkbox" name="owner_cost[]" value="船舶管理費の見直し" <?php if(strpos($owner_cost,"船舶管理費の見直し") !== false){echo 'checked="checked"';}?>>船舶管理費の見直し</label></p>
                      </td>
                    </tr>
                    <tr>
                      <th>船員・安全運航</th>
                      <td>
                        <p><label><input type="checkbox" name="owner_crew_mng[]" value="船員採用" <?php if(strpos($owner_crew_mng,"船員採用") !== false){echo 'checked="checked"';}?>>船員採用</label></p>
                        <p><label><input type="checkbox" name="owner_crew_mng[]" value="船員育成・教育" <?php if(strpos($owner_crew_mng,"船員育成・教育") !== false){echo 'checked="checked"';}?>>船員育成・教育</label></p>
                        <p><label><input type="checkbox" name="owner_crew_mng[]" value="船員管理" <?php if(strpos($owner_crew_mng,"船員管理") !== false){echo 'checked="checked"';}?>>船員採用</label></p>
                        <p><label><input type="checkbox" name="owner_crew_mng[]" value="船員融通" <?php if(strpos($owner_crew_mng,"船員融通") !== false){echo 'checked="checked"';}?>>船員融通</label></p>
                        <p><label><input type="checkbox" name="owner_crew_mng[]" value="省人化・自動化" <?php if(strpos($owner_crew_mng,"省人化・自動化") !== false){echo 'checked="checked"';}?>>省人化・自動化</label></p>
                        <p><label><input type="checkbox" name="owner_crew_mng[]" value="オペレーションマニュアル" <?php if(strpos($owner_crew_mng,"オペレーションマニュアル") !== false){echo 'checked="checked"';}?>>オペレーションマニュアル</label></p>
                        <p><label><input type="checkbox" name="owner_crew_mng[]" value="コロナ対策" <?php if(strpos($owner_crew_mng,"コロナ対策") !== false){echo 'checked="checked"';}?>>コロナ対策</label></p>
                      </td>
                    </tr>
                    <tr>
                      <th>船主グループ化</th>
                      <td>
                        <p><label><input type="checkbox" name="owner_group[]" value="共同船舶管理会社" <?php if(strpos($owner_group,"共同船舶管理会社") !== false){echo 'checked="checked"';}?>>共同船舶管理会社</label></p>
                        <p><label><input type="checkbox" name="owner_group[]" value="合併" <?php if(strpos($owner_group,"合併") !== false){echo 'checked="checked"';}?>>合併</label></p>
                        <p><label><input type="checkbox" name="owner_group[]" value="売船" <?php if(strpos($owner_group,"売船") !== false){echo 'checked="checked"';}?>>売船</label></p>
                        <p><label><input type="checkbox" name="owner_group[]" value="買船" <?php if(strpos($owner_group,"買船") !== false){echo 'checked="checked"';}?>>買船</label></p>
                        <p><label><input type="checkbox" name="owner_group[]" value="事業売却" <?php if(strpos($owner_group,"事業売却") !== false){echo 'checked="checked"';}?>>事業売却</label></p>
                        <p><label><input type="checkbox" name="owner_group[]" value="事業買収" <?php if(strpos($owner_group,"事業買収") !== false){echo 'checked="checked"';}?>>事業買収</label></p>
                      </td>
                    </tr>
                    <tr>
                      <th>脱炭素化</th>
                      <td>
                        <p><label><input type="checkbox" name="owner_decarbon[]" value="排出量可視化" <?php if(strpos($owner_decarbon,"排出量可視化") !== false){echo 'checked="checked"';}?>>排出量可視化</label></p>
                        <p><label><input type="checkbox" name="owner_decarbon[]" value="ウェザールーティング" <?php if(strpos($owner_decarbon,"ウェザールーティング") !== false){echo 'checked="checked"';}?>>ウェザールーティング</label></p>
                        <p><label><input type="checkbox" name="owner_decarbon[]" value="帆" <?php if(strpos($owner_decarbon,"帆") !== false){echo 'checked="checked"';}?>>帆</label></p>
                        <p><label><input type="checkbox" name="owner_decarbon[]" value="空気潤滑" <?php if(strpos($owner_decarbon,"空気潤滑") !== false){echo 'checked="checked"';}?>>空気潤滑</label></p>
                        <p><label><input type="checkbox" name="owner_decarbon[]" value="船上回収" <?php if(strpos($owner_decarbon,"船上回収") !== false){echo 'checked="checked"';}?>>船上回収</label></p>
                        <p><label><input type="checkbox" name="owner_decarbon[]" value="次世代主機・燃料" <?php if(strpos($owner_decarbon,"次世代主機・燃料") !== false){echo 'checked="checked"';}?>>次世代主機・燃料</label></p>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
            <input type="submit" name="upload" value="送信">
          </form>
        </main>
        <footer>
        </footer>
    </div>
</body>