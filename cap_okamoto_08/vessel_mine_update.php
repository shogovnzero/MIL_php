<?php
session_start();
$id = $_SESSION["id"];
$vessel_id = $_GET['id'];
include("funcs.php");
sschk();
$pdo = db_conn();

$stmt = $pdo->prepare("SELECT * FROM cap_vessel WHERE vessel_id=:id");
$stmt->bindValue(":id",$vessel_id,PDO::PARAM_INT);
$status = $stmt->execute();

if($status==false) {
  sql_error($stmt);
}else{
  $row = $stmt->fetch();
}

if($id != $row["owner_id"]){
  redirect("vessel_page.php?id=$vessel_id");
}

$pref = 0;
if (empty($POST)){
  $pref = $row["vessel_trade_pref"];
}
if (isset($_POST['vessel_trade_pref']) && is_array($_POST['vessel_trade_pref'])) {
  $pref = implode(",",$_POST['vessel_trade_pref']);
}

$fuel = 0;
if (empty($POST)){
  $fuel = $row["vessel_fuel"];
} 
if (isset($_POST['vessel_fuel']) && is_array($_POST['vessel_fuel'])) {
  $fuel = implode(",",$_POST['vessel_fuel']);
}

if(!empty($_POST)){
  if($_POST["vessel_number"] === ""){
    $error["vessel_number"] = "blank";
  }
  if($_POST["vessel_name_jp"] === ""){
    $error["vessel_name_jp"] = "blank";
  }
  if($_POST["vessel_name_en"] === ""){
    $error["vessel_name_en"] = "blank";
  }
  if(!isset($error)){
    $stmt = $pdo->prepare("SELECT COUNT(*) as cnt_number FROM cap_vessel WHERE vessel_number=?");
    $stmt->execute(array($_POST["vessel_number"]));
    $record = $stmt->fetch();
    if($record["cnt_number"] > 0){
      if($row["vessel_number"] != $_POST["vessel_number"]){
        $error["vessel_number"] = "duplicate";
      }
    }
  }
  if (!isset($error)) {
    $_SESSION['join'] = $_POST;
    redirect("vessel_mine_update_process.php");
    exit();
  }
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
      <form method="post" action="">
        <div class="area_top">
          <div class="area_logo"></div>
          <div class="area_description">
            <table>
              <tr>
                <th>船舶登録番号<span id="required">*</span></th>  
                <td>
                  <?php if (!empty($error["vessel_number"]) && $error['vessel_number'] === 'blank'): ?>
                    <input type="number" name="vessel_number">
                    <p class="error">*船舶登録番号は必須入力です</p>
                  <?php elseif (!empty($_POST)): ?>
                    <input type="number" name="vessel_number" value="<?=$_POST["vessel_number"]?>">
                  <?php else: ?>
                    <input type="number" name="vessel_number" value="<?=$row["vessel_number"]?>">
                  <?php endif ?>
                </td>
              </tr>
              <tr>
                <th>船名(日本語)<span id="required">*</span></th>
                <td>
                  <?php if (!empty($error["vessel_name_jp"]) && $error['vessel_name_jp'] === 'blank'): ?>
                    <input type="text" name="vessel_name_jp">
                    <p class="error">*船名は必須入力です</p>
                  <?php elseif (!empty($_POST)): ?>
                    <input type="text" name="vessel_name_jp" value="<?=$_POST["vessel_name_jp"]?>">
                  <?php else: ?>
                    <input type="text" name="vessel_name_jp" value="<?=$row["vessel_name_jp"]?>">
                  <?php endif ?>
                </td>
              </tr>
              <tr>
                <th>船名(英文)<span id="required">*</span></th>
                <td>
                  <?php if (!empty($error["vessel_name_en"]) && $error['vessel_name_en'] === 'blank'): ?>
                    <input type="text" name="vessel_name_en">
                    <p class="error">*船名は必須入力です</p>
                  <?php elseif (!empty($_POST)): ?>
                    <input type="text" name="vessel_name_en" value="<?=$_POST["vessel_name_en"]?>">
                  <?php else: ?>
                    <input type="text" name="vessel_name_en" value="<?=$row["vessel_name_en"]?>">
                  <?php endif ?>
                </td>
              </tr>
            </table>
          </div>
        </div>
        <div class="are_main"></div>
        <div>登録情報・運航情報</div>
        <table class="">
          <tr>
            <td>船舶登録番号<span id="required">*</span></td>  
            <td>
              <?php if (!empty($error["vessel_number"]) && $error['vessel_number'] === 'blank'): ?>
                <input type="number" name="vessel_number">
                <p class="error">*船舶登録番号は必須入力です</p>
              <?php elseif (!empty($_POST)): ?>
                <input type="number" name="vessel_number" value="<?=$_POST["vessel_number"]?>">
              <?php else: ?>
                <input type="number" name="vessel_number" value="<?=$row["vessel_number"]?>">
              <?php endif ?>
            </td>
          </tr>
          <tr>
            <td>船名(日本語)<span id="required">*</span></td>
            <td>
              <?php if (!empty($error["vessel_name_jp"]) && $error['vessel_name_jp'] === 'blank'): ?>
                <input type="text" name="vessel_name_jp">
                <p class="error">*船名は必須入力です</p>
              <?php elseif (!empty($_POST)): ?>
                <input type="text" name="vessel_name_jp" value="<?=$_POST["vessel_name_jp"]?>">
              <?php else: ?>
                <input type="text" name="vessel_name_jp" value="<?=$row["vessel_name_jp"]?>">
              <?php endif ?>
            </td>
          </tr>
          <tr>
            <td>船名(英文)<span id="required">*</span></td>
            <td>
              <?php if (!empty($error["vessel_name_en"]) && $error['vessel_name_en'] === 'blank'): ?>
                <input type="text" name="vessel_name_en">
                <p class="error">*船名は必須入力です</p>
              <?php elseif (!empty($_POST)): ?>
                <input type="text" name="vessel_name_en" value="<?=$_POST["vessel_name_en"]?>">
              <?php else: ?>
                <input type="text" name="vessel_name_en" value="<?=$row["vessel_name_en"]?>">
              <?php endif ?>
            </td>
          </tr>
          <tr>
            <td>船舶管理会社</td>
            <td>
              <?php if (!empty($_POST)): ?>
                <input type="text" name="manager" placeholder="自社管理の場合は空白" value="<?=$_POST["manager"]?>">
              <?php else: ?>
                <input type="text" name="manager" placeholder="自社管理の場合は空白" value="<?=$row["manager"]?>">
              <?php endif ?>
            </td>
          </tr>
          <tr>
            <td>オペレーター</td>
            <td>
              <?php if (!empty($_POST)): ?>
                <input type="text" name="operator" value="<?=$_POST["operator"]?>">
              <?php else: ?>
                <input type="text" name="operator" value="<?=$row["operator"]?>">
              <?php endif ?>
            </td>
          </tr>
          <tr>
            <td>船籍港</td>
            <td>
              <?php if (!empty($_POST)): ?>
                <input type="text" name="vessel_reg_port" value="<?=$_POST["vessel_reg_port"]?>">
              <?php else: ?>
                <input type="text" name="vessel_reg_port" value="<?=$row["vessel_reg_port"]?>">
              <?php endif ?>
            </td>
          </tr>
          <tr>
            <td>主な寄港先(都道府県)</td>
            <td>
              <table>
                <tr>
                  <td>北海道・東北</td>
                  <td>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="北海道" <?php if(strpos($pref,"北海道") !== false){echo 'checked="checked"';}?>>北海道</label>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="青森県" <?php if(strpos($pref,"青森県") !== false){echo 'checked="checked"';}?>>青森県</label>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="岩手県" <?php if(strpos($pref,"岩手県") !== false){echo 'checked="checked"';}?>>岩手県</label>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="宮城県" <?php if(strpos($pref,"宮城県") !== false){echo 'checked="checked"';}?>>宮城県</label>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="秋田県" <?php if(strpos($pref,"秋田県") !== false){echo 'checked="checked"';}?>>秋田県</label>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="山形県" <?php if(strpos($pref,"山形県") !== false){echo 'checked="checked"';}?>>山形県</label>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="福島県" <?php if(strpos($pref,"福島県") !== false){echo 'checked="checked"';}?>>福島県</label>
                  </td>
                </tr>
                <tr>
                  <td>関東</td>
                  <td>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="茨城県" <?php if(strpos($pref,"茨城県") !== false){echo 'checked="checked"';}?>>茨城県</label>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="栃木県" <?php if(strpos($pref,"栃木県") !== false){echo 'checked="checked"';}?>>栃木県</label>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="群馬県" <?php if(strpos($pref,"群馬県") !== false){echo 'checked="checked"';}?>>群馬県</label>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="埼玉県" <?php if(strpos($pref,"埼玉県") !== false){echo 'checked="checked"';}?>>埼玉県</label>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="千葉県" <?php if(strpos($pref,"千葉県") !== false){echo 'checked="checked"';}?>>千葉県</label>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="東京都" <?php if(strpos($pref,"東京都") !== false){echo 'checked="checked"';}?>>東京都</label>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="神奈川県" <?php if(strpos($pref,"神奈川県") !== false){echo 'checked="checked"';}?>>神奈川県</label>
                  </td>
                </tr>
                <tr>
                  <td>東海道・甲信越</td>
                  <td>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="新潟県" <?php if(strpos($pref,"新潟県") !== false){echo 'checked="checked"';}?>>新潟県</label>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="富山県" <?php if(strpos($pref,"富山県") !== false){echo 'checked="checked"';}?>>富山県</label>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="石川県" <?php if(strpos($pref,"石川県") !== false){echo 'checked="checked"';}?>>石川県</label>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="福井県" <?php if(strpos($pref,"福井県") !== false){echo 'checked="checked"';}?>>福井県</label>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="山梨県" <?php if(strpos($pref,"山梨県") !== false){echo 'checked="checked"';}?>>山梨県</label>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="長野県" <?php if(strpos($pref,"長野県") !== false){echo 'checked="checked"';}?>>長野県</label>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="岐阜県" <?php if(strpos($pref,"岐阜県") !== false){echo 'checked="checked"';}?>>岐阜県</label>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="静岡県" <?php if(strpos($pref,"静岡県") !== false){echo 'checked="checked"';}?>>静岡県</label>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="愛知県" <?php if(strpos($pref,"愛知県") !== false){echo 'checked="checked"';}?>>愛知県</label>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="三重県" <?php if(strpos($pref,"三重県") !== false){echo 'checked="checked"';}?>>三重県</label>
                  </td>
                </tr>
                <tr>
                  <td>関西</td>
                  <td>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="滋賀県" <?php if(strpos($pref,"滋賀県") !== false){echo 'checked="checked"';}?>>滋賀県</label>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="京都府" <?php if(strpos($pref,"京都府") !== false){echo 'checked="checked"';}?>>京都府</label>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="大阪府" <?php if(strpos($pref,"大阪府") !== false){echo 'checked="checked"';}?>>大阪府</label>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="兵庫県" <?php if(strpos($pref,"兵庫県") !== false){echo 'checked="checked"';}?>>兵庫県</label>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="奈良県" <?php if(strpos($pref,"奈良県") !== false){echo 'checked="checked"';}?>>奈良県</label>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="和歌山県" <?php if(strpos($pref,"和歌山県") !== false){echo 'checked="checked"';}?>>和歌山県</label>
                  </td>
                </tr>
                <tr>
                  <td>中国・四国</td>
                  <td>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="鳥取県" <?php if(strpos($pref,"鳥取県") !== false){echo 'checked="checked"';}?>>鳥取県</label>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="島根県" <?php if(strpos($pref,"島根県") !== false){echo 'checked="checked"';}?>>島根県</label>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="岡山県" <?php if(strpos($pref,"岡山県") !== false){echo 'checked="checked"';}?>>岡山県</label>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="広島県" <?php if(strpos($pref,"広島県") !== false){echo 'checked="checked"';}?>>広島県</label>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="山口県" <?php if(strpos($pref,"山口県") !== false){echo 'checked="checked"';}?>>山口県</label>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="徳島県" <?php if(strpos($pref,"徳島県") !== false){echo 'checked="checked"';}?>>徳島県</label>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="香川県" <?php if(strpos($pref,"香川県") !== false){echo 'checked="checked"';}?>>香川県</label>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="愛媛県" <?php if(strpos($pref,"愛媛県") !== false){echo 'checked="checked"';}?>>愛媛県</label>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="高知県" <?php if(strpos($pref,"高知県") !== false){echo 'checked="checked"';}?>>高知県</label>
                  </td>
                </tr>
                <tr>
                  <td>九州・沖縄</td>
                  <td>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="福岡県" <?php if(strpos($pref,"福岡県") !== false){echo 'checked="checked"';}?>>福岡県</label>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="佐賀県" <?php if(strpos($pref,"佐賀県") !== false){echo 'checked="checked"';}?>>佐賀県</label>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="長崎県" <?php if(strpos($pref,"長崎県") !== false){echo 'checked="checked"';}?>>長崎県</label>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="熊本県" <?php if(strpos($pref,"熊本県") !== false){echo 'checked="checked"';}?>>熊本県</label>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="大分県" <?php if(strpos($pref,"大分県") !== false){echo 'checked="checked"';}?>>大分県</label>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="宮崎県" <?php if(strpos($pref,"宮崎県") !== false){echo 'checked="checked"';}?>>宮崎県</label>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="鹿児島県" <?php if(strpos($pref,"鹿児島県") !== false){echo 'checked="checked"';}?>>鹿児島県</label>
                    <label><input type="checkbox" name="vessel_trade_pref[]" value="沖縄県" <?php if(strpos($pref,"沖縄県") !== false){echo 'checked="checked"';}?>>沖縄県</label>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td>主な寄港先(港)</td>
            <td>
              <?php if (!empty($_POST)): ?>
                <input type="text" name="vessel_trade_port" value="<?=$_POST["vessel_trade_port"]?>">
              <?php else: ?>
                <input type="text" name="vessel_trade_port" value="<?=$row["vessel_trade_port"]?>">
              <?php endif ?>
            </td>
          </tr>
        </table>
        <div>船種・船型</div>
        <table class="">
          <tr>
            <td>船種</td>
            <td><select name="vessel_type">
              <option value="">下記から選択</option>
              <optgroup label="ガス船">
                <option value="LNG船" <?php if(!empty($_POST['vessel_type'])&&'LNG船'===$_POST['vessel_type']){echo 'selected';}elseif(empty($_POST)&&$row["vessel_type"]=="LNG船"){echo 'selected';}?>>LNG船</option>
                <option value="LPG船" <?php if(!empty($_POST['vessel_type'])&&'LPG船'===$_POST['vessel_type']){echo 'selected';}elseif(empty($_POST)&&$row["vessel_type"]=="LPG船"){echo 'selected';}?>>LPG船</option>
                <option value="エタン船" <?php if(!empty($_POST['vessel_type'])&&'エタン船'===$_POST['vessel_type']){echo 'selected';}elseif(empty($_POST)&&$row["vessel_type"]=="エタン船"){echo 'selected';}?>>エタン船</option>
                <option value="エチレン船" <?php if(!empty($_POST['vessel_type'])&&'エチレン船'===$_POST['vessel_type']){echo 'selected';}elseif(empty($_POST)&&$row["vessel_type"]=="エチレン船"){echo 'selected';}?>>エチレン船</option>
                <option value="アンモニア船" <?php if(!empty($_POST['vessel_type'])&&'アンモニア船'===$_POST['vessel_type']){echo 'selected';}elseif(empty($_POST)&&$row["vessel_type"]=="アンモニア船"){echo 'selected';}?>>アンモニア船</option>
                <option value="液化CO2船" <?php if(!empty($_POST['vessel_type'])&&'液化CO2船'===$_POST['vessel_type']){echo 'selected';}elseif(empty($_POST)&&$row["vessel_type"]=="液化CO2船"){echo 'selected';}?>>液化CO2船</option>
                <option value="液化水素船" <?php if(!empty($_POST['vessel_type'])&&'液化水素船'===$_POST['vessel_type']){echo 'selected';}elseif(empty($_POST)&&$row["vessel_type"]=="液化水素船"){echo 'selected';}?>>液化水素船</option>
                <option value="ガス船全般" <?php if(!empty($_POST['vessel_type'])&&'ガス船全般'===$_POST['vessel_type']){echo 'selected';}elseif(empty($_POST)&&$row["vessel_type"]=="ガス船全般"){echo 'selected';}?>>ガス船全般</option>
              </optgroup>
              <optgroup label="バルカー">
                <option value="石炭専用船" <?php if(!empty($_POST['vessel_type'])&&'石炭専用船'===$_POST['vessel_type']){echo 'selected';}elseif(empty($_POST)&&$row["vessel_type"]=="石炭専用船"){echo 'selected';}?>>石炭専用船</option>
                <option value="石炭灰専用船" <?php if(!empty($_POST['vessel_type'])&&'石炭灰専用船'===$_POST['vessel_type']){echo 'selected';}elseif(empty($_POST)&&$row["vessel_type"]=="石炭灰専用船"){echo 'selected';}?>>石炭灰専用船</option>
                <option value="コークス専用船" <?php if(!empty($_POST['vessel_type'])&&'コークス専用船'===$_POST['vessel_type']){echo 'selected';}elseif(empty($_POST)&&$row["vessel_type"]=="コークス専用船"){echo 'selected';}?>>コークス専用船</option>
                <option value="鉱石専用船" <?php if(!empty($_POST['vessel_type'])&&'鉱石専用船'===$_POST['vessel_type']){echo 'selected';}elseif(empty($_POST)&&$row["vessel_type"]=="鉱石専用船"){echo 'selected';}?>>鉱石専用船</option>
                <option value="鋼材専用船" <?php if(!empty($_POST['vessel_type'])&&'鋼材専用船'===$_POST['vessel_type']){echo 'selected';}elseif(empty($_POST)&&$row["vessel_type"]=="鋼材専用船"){echo 'selected';}?>>鋼材専用船</option>
                <option value="穀物専用船" <?php if(!empty($_POST['vessel_type'])&&'穀物専用船'===$_POST['vessel_type']){echo 'selected';}elseif(empty($_POST)&&$row["vessel_type"]=="穀物専用船"){echo 'selected';}?>>穀物専用船</option>
                <option value="セメント専用船" <?php if(!empty($_POST['vessel_type'])&&'セメント専用船'===$_POST['vessel_type']){echo 'selected';}elseif(empty($_POST)&&$row["vessel_type"]=="セメント専用船"){echo 'selected';}?>>セメント専用船</option>
                <option value="バルカー全般" <?php if(!empty($_POST['vessel_type'])&&'バルカー全般'===$_POST['vessel_type']){echo 'selected';}elseif(empty($_POST)&&$row["vessel_type"]=="バルカー全般"){echo 'selected';}?>>バルカー全般</option>
              </optgroup>
              <optgroup label="タンカー">
                <option value="オイルタンカー" <?php if(!empty($_POST['vessel_type'])&&'オイルタンカー'===$_POST['vessel_type']){echo 'selected';}elseif(empty($_POST)&&$row["vessel_type"]=="オイルタンカー"){echo 'selected';}?>>オイルタンカー</option>
                <option value="プロダクトタンカー" <?php if(!empty($_POST['vessel_type'])&&'プロダクトタンカー'===$_POST['vessel_type']){echo 'selected';}elseif(empty($_POST)&&$row["vessel_type"]=="プロダクトタンカー"){echo 'selected';}?>>プロダクトタンカー</option>
                <option value="ケミカルタンカー" <?php if(!empty($_POST['vessel_type'])&&'ケミカルタンカー'===$_POST['vessel_type']){echo 'selected';}elseif(empty($_POST)&&$row["vessel_type"]=="ケミカルタンカー"){echo 'selected';}?>>ケミカルタンカー</option>
                <option value="タンカー全般" <?php if(!empty($_POST['vessel_type'])&&'タンカー全般'===$_POST['vessel_type']){echo 'selected';}elseif(empty($_POST)&&$row["vessel_type"]=="タンカー全般"){echo 'selected';}?>>タンカー全般</option>
              </optgroup>
              <optgroup label="他貨物船">
                <option value="コンテナ船" <?php if(!empty($_POST['vessel_type'])&&'コンテナ船'===$_POST['vessel_type']){echo 'selected';}elseif(empty($_POST)&&$row["vessel_type"]=="コンテナ船"){echo 'selected';}?>>コンテナ船</option>
                <option value="自動車運搬船" <?php if(!empty($_POST['vessel_type'])&&'自動車運搬船'===$_POST['vessel_type']){echo 'selected';}elseif(empty($_POST)&&$row["vessel_type"]=="自動車運搬船"){echo 'selected';}?>>自動車運搬船</option>
                <option value="RORO船" <?php if(!empty($_POST['vessel_type'])&&'RORO船'===$_POST['vessel_type']){echo 'selected';}elseif(empty($_POST)&&$row["vessel_type"]=="RORO船"){echo 'selected';}?>>RORO船</option>
                <option value="重量貨物船" <?php if(!empty($_POST['vessel_type'])&&'重量貨物船'===$_POST['vessel_type']){echo 'selected';}elseif(empty($_POST)&&$row["vessel_type"]=="重量貨物船"){echo 'selected';}?>>重量貨物船</option>
                <option value="他貨物船" <?php if(!empty($_POST['vessel_type'])&&'他貨物船'===$_POST['vessel_type']){echo 'selected';}elseif(empty($_POST)&&$row["vessel_type"]=="他貨物船"){echo 'selected';}?>>他貨物船</option>
              </optgroup>
              <optgroup label="旅客船・作業船">
                <option value="旅客船" <?php if(!empty($_POST['vessel_type'])&&'旅客船'===$_POST['vessel_type']){echo 'selected';}elseif(empty($_POST)&&$row["vessel_type"]=="旅客船"){echo 'selected';}?>>旅客船</option>
                <option value="ROPAX船" <?php if(!empty($_POST['vessel_type'])&&'ROPAX船'===$_POST['vessel_type']){echo 'selected';}elseif(empty($_POST)&&$row["vessel_type"]=="ROPAX船"){echo 'selected';}?>>ROPAX船</option>
                <option value="作業船一般" <?php if(!empty($_POST['vessel_type'])&&'作業船一般'===$_POST['vessel_type']){echo 'selected';}elseif(empty($_POST)&&$row["vessel_type"]=="作業船一般"){echo 'selected';}?>>作業船一般</option>
                <option value="SEP船" <?php if(!empty($_POST['vessel_type'])&&'SEP船'===$_POST['vessel_type']){echo 'selected';}elseif(empty($_POST)&&$row["vessel_type"]=="SEP船"){echo 'selected';}?>>SEP船</option>
                <option value="SOV" <?php if(!empty($_POST['vessel_type'])&&'SOV'===$_POST['vessel_type']){echo 'selected';}elseif(empty($_POST)&&$row["vessel_type"]=="SOV船"){echo 'selected';}?>>SOV</option>
                <option value="CTV" <?php if(!empty($_POST['vessel_type'])&&'CTV'===$_POST['vessel_type']){echo 'selected';}elseif(empty($_POST)&&$row["vessel_type"]=="CTV船"){echo 'selected';}?>>CTV</option>
                <option value="タグボート" <?php if(!empty($_POST['vessel_type'])&&'タグボート'===$_POST['vessel_type']){echo 'selected';}elseif(empty($_POST)&&$row["vessel_type"]=="タグボート"){echo 'selected';}?>>タグボート</option>
                <option value="漁船" <?php if(!empty($_POST['vessel_type'])&&'漁船'===$_POST['vessel_type']){echo 'selected';}elseif(empty($_POST)&&$row["vessel_type"]=="漁船"){echo 'selected';}?>>漁船</option>
              </optgroup>
            </select></td>
          </tr>
          <tr>
            <td>総トン数(GT)</td>
            <td>
              <?php if (!empty($_POST)): ?>
                <input type="number" name="vessel_gt" value="<?=$_POST["vessel_gt"]?>">
              <?php else: ?>
                <input type="number" name="vessel_gt" value="<?=$row["vessel_gt"]?>">
              <?php endif ?>
            </td>
          </tr>
          <tr>
            <td>純トン数(NT)</td>
            <td>
              <?php if (!empty($_POST)): ?>
                <input type="number" name="vessel_nt" value="<?=$_POST["vessel_nt"]?>">
              <?php else: ?>
                <input type="number" name="vessel_nt" value="<?=$row["vessel_nt"]?>">
              <?php endif ?>
            </td>
          </tr>
          <tr>
            <td>載貨重量トン数(DWT)</td>
            <td>
              <?php if (!empty($_POST)): ?>
                <input type="number" name="vessel_dwt" value="<?=$_POST["vessel_dwt"]?>">
              <?php else: ?>
                <input type="number" name="vessel_dwt" value="<?=$row["vessel_dwt"]?>">
              <?php endif ?>
            </td>
          </tr>
          <tr id="gascarrier" style="display:none">
            <td>タンク容積(m3) ※ガス船のみ</td>
            <td>
              <?php if (!empty($_POST)): ?>
                <input type="number" name="vessel_tank" value="<?=$_POST["vessel_tank"]?>">
              <?php else: ?>
                <input type="number" name="vessel_tank" value="<?=$row["vessel_tank"]?>">
              <?php endif ?>
            </td>
          </tr>
          <tr id="boxship" style="display:none">
            <td>コンテナ積載数量(TEU) ※コンテナ船のみ</td>
            <td>
              <?php if (!empty($_POST)): ?>
                <input type="number" name="vessel_teu" value="<?=$_POST["vessel_teu"]?>">
              <?php else: ?>
                <input type="number" name="vessel_teu" value="<?=$row["vessel_teu"]?>">
              <?php endif ?>
            </td>
          </tr>
          <tr>
            <td>全長/Loa(m)</td>
            <td>
              <?php if (!empty($_POST)): ?>
                <input type="number" name="vessel_loa" value="<?=$_POST["vessel_loa"]?>">
              <?php else: ?>
                <input type="number" name="vessel_loa" value="<?=$row["vessel_loa"]?>">
              <?php endif ?>
            </td>
          </tr>
          <tr>
            <td>船幅/Beam(m)</td>
            <td>
              <?php if (!empty($_POST)): ?>
                <input type="number" name="vessel_beam" value="<?=$_POST["vessel_beam"]?>">
              <?php else: ?>
                <input type="number" name="vessel_beam" value="<?=$row["vessel_beam"]?>">
              <?php endif ?>
            </td>
          </tr>
          <tr>
            <td>深さ/Depth(m)</td>
            <td>
              <?php if (!empty($_POST)): ?>
                <input type="number" name="vessel_depth" value="<?=$_POST["vessel_depth"]?>">
              <?php else: ?>
                <input type="number" name="vessel_depth" value="<?=$row["vessel_depth"]?>">
              <?php endif ?>
            </td>
          </tr>
          <tr>
            <td>喫水/Draft(m)</td>
            <td>
              <?php if (!empty($_POST)): ?>
                <input type="number" name="vessel_draft" value="<?=$_POST["vessel_draft"]?>">
              <?php else: ?>
                <input type="number" name="vessel_draft" value="<?=$row["vessel_draft"]?>">
              <?php endif ?>
            </td>
          </tr>
          <tr>
            <td>定員数</td>
            <td>
              <?php if (!empty($_POST)): ?>
                <input type="number" name="vessel_crew" value="<?=$_POST["vessel_crew"]?>">
              <?php else: ?>
                <input type="number" name="vessel_crew" value="<?=$row["vessel_crew"]?>">
              <?php endif ?>
            </td>
          </tr>
        </table>
        <div>技術情報</div>
        <table class="">
          <tr>
            <td>造船所</td>
            <td>
              <?php if (!empty($_POST)): ?>
                <input type="text" name="vessel_sy" value="<?=$_POST["vessel_sy"]?>">
              <?php else: ?>
                <input type="text" name="vessel_sy" value="<?=$row["vessel_sy"]?>">
              <?php endif ?>
            </td>
          </tr>
          <tr>
            <td>竣工年月日</td>
            <td>
              <?php if (!empty($_POST)): ?>
                <input type="date" name="vessel_built" value="<?=$_POST["vessel_built"]?>">
              <?php else: ?>
                <input type="date" name="vessel_built" value="<?=$row["vessel_built"]?>">
              <?php endif ?>
            </td>
          </tr>
          <tr>
            <td>主機型式</td>
            <td>
              <?php if (!empty($_POST)): ?>
                <input type="text" name="vessel_me" value="<?=$_POST["vessel_me"]?>">
              <?php else: ?>
                <input type="text" name="vessel_me" value="<?=$row["vessel_me"]?>">
              <?php endif ?>
            </td>
          </tr>
          <tr>
            <td>燃料</td>
            <td>
              <table>
                <tr>
                  <td>従来燃料</td>
                  <td>
                    <label><input type="checkbox" name="vessel_fuel[]" value="軽油" <?php if(strpos($fuel,"軽油") !== false){echo 'checked="checked"';}?>>軽油</label>
                    <label><input type="checkbox" name="vessel_fuel[]" value="A重油" <?php if(strpos($fuel,"A重油") !== false){echo 'checked="checked"';}?>>A重油</label>
                    <label><input type="checkbox" name="vessel_fuel[]" value="B重油" <?php if(strpos($fuel,"B重油") !== false){echo 'checked="checked"';}?>>B重油</label>
                    <label><input type="checkbox" name="vessel_fuel[]" value="C重油" <?php if(strpos($fuel,"C重油") !== false){echo 'checked="checked"';}?>>C重油</label>
                  </td>
                </tr>
                <tr>
                  <td>次世代燃料</td>
                  <td>
                    <label><input type="checkbox" name="vessel_fuel[]" value="LNG" <?php if(strpos($fuel,"LNG") !== false){echo 'checked="checked"';}?>>LNG</label>
                    <label><input type="checkbox" name="vessel_fuel[]" value="LPG" <?php if(strpos($fuel,"LPG") !== false){echo 'checked="checked"';}?>>LPG</label>
                    <label><input type="checkbox" name="vessel_fuel[]" value="メタノール" <?php if(strpos($fuel,"メタノール") !== false){echo 'checked="checked"';}?>>メタノール</label>
                    <label><input type="checkbox" name="vessel_fuel[]" value="アンモニア" <?php if(strpos($fuel,"アンモニア") !== false){echo 'checked="checked"';}?>>アンモニア</label>
                    <label><input type="checkbox" name="vessel_fuel[]" value="電気推進" <?php if(strpos($fuel,"電気推進") !== false){echo 'checked="checked"';}?>>電気推進</label>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <input type="hidden" name="vessel_id" value="<?=$vessel_id?>">
        </table>
        <input type="submit" value="更新">
      </form>
    </main>
    <footer>
    </footer>
  </div>
  <script>
    $("[name=vessel_type]").change(function(){
      let val = $("[name=vessel_type]").val();
      if (val=="コンテナ船"){
        $("#gascarrier").hide();
        $("#boxship").show();
      } else if (val=="LNG船" || val=="LPG船" || val=="エタン船" || val=="エチレン船" || val=="アンモニア船" || val=="液化CO2船" || val=="液化水素船" || val=="ガス船全般"){
        $("#gascarrier").show();
        $("#boxship").hide();
      }
    });
    $(function(){
      let val = $("[name=vessel_type]").val();
      if (val=="コンテナ船"){
        $("#gascarrier").hide();
        $("#boxship").show();
      } else if (val=="LNG船" || val=="LPG船" || val=="エタン船" || val=="エチレン船" || val=="アンモニア船" || val=="液化CO2船" || val=="液化水素船" || val=="ガス船全般"){
        $("#gascarrier").show();
        $("#boxship").hide();
      }
    });
  </script>
</body>