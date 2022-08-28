<?php
session_start();
$id = $_SESSION['id'];
include("funcs.php");
sschk();
$pdo = db_conn();

if(!empty($_POST)){
  if($_POST["owner_name"] === ""){
      $error["owner_name"] = "blank";
  }
  if($_POST["owner_email"] === ""){
      $error["owner_email"] = "blank";
  }
  if($_POST["owner_id"] === ""){
      $error["owner_id"] = "blank";
  }
  if($_POST["owner_pw"] === ""){
      $error["owner_pw"] = "blank";
  }
  if(!isset($error)){
      $stmt = $pdo->prepare("SELECT COUNT(*) as cnt_name FROM cap_owner WHERE owner_name=?");
      $stmt->execute(array($_POST["owner_name"]));
      $record = $stmt->fetch();
      if($record["cnt_name"] > 0){
          $error["owner_name"] = "duplicate";
      }

      $stmt = $pdo->prepare("SELECT COUNT(*) as cnt_email FROM cap_owner WHERE email=?");
      $stmt->execute(array($_POST["owner_email"]));
      $record = $stmt->fetch();
      if($record["cnt_email"] > 0){
          $error["owner_email"] = "duplicate";
      }

      $stmt = $pdo->prepare("SELECT COUNT(*) as cnt_id FROM cap_owner WHERE owner_id=?");
      $stmt->execute(array($_POST["owner_id"]));
      $record = $stmt->fetch();
      if($record["cnt_id"] > 0){
          $error["owner_id"] = "duplicate";
      }
  }
  if (!isset($error)) {
      $_SESSION['join'] = $_POST;
      redirect("signup_process.php");
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
  <title>CAP - 船舶新規登録</title>
  <link rel="stylesheet" href="./css/reset.css">
  <link rel="stylesheet" href="./css/style.css">
</head>

<body>
  <div class="container">
    <header>
      <?php include("menu.php"); ?>
    </header>
    <main>
      <form method="post" action="vessel_register_process.php">
        <div>登録情報・運航情報</div>
        <table class="">
          <tr>
            <td>船舶登録番号<span id="required">*</span></td>
            <td><input type="number" name="vessel_number"></td>
          </tr>
          <tr>
            <td>船名(日本語)<span id="required">*</span></td>
            <td><input type="text" name="vessel_name_jp"></td>
          </tr>
          <tr>
            <td>船名(英文)<span id="required">*</span></td>
            <td><input type="text" name="vessel_name_en"></td>
          </tr>
          <input type="hidden" name="owner_id" value="<?=$id?>">
          <tr>
            <td>船舶管理会社</td>
            <td><input type="text" name="manager" placeholder="自社管理の場合は空白"></td>
          </tr>
          <tr>
            <td>船籍港</td>
            <td><input type="text" name="vessel_reg_port"></td>
          </tr>
          <tr>
            <td>主な寄港先(都道府県)</td>
            <td>
              <table>
                <tr>
                  <td>北海道・東北</td>
                  <td>
                    <input type="checkbox" name="vessel_trade_pref" value="1">北海道
                    <input type="checkbox" name="vessel_trade_pref" value="2">青森県
                    <input type="checkbox" name="vessel_trade_pref" value="3">岩手県
                    <input type="checkbox" name="vessel_trade_pref" value="4">宮城県
                    <input type="checkbox" name="vessel_trade_pref" value="5">秋田県
                    <input type="checkbox" name="vessel_trade_pref" value="6">山形県
                    <input type="checkbox" name="vessel_trade_pref" value="7">福島県
                  </td>
                </tr>
                <tr>
                  <td>関東</td>
                  <td>
                    <input type="checkbox" name="vessel_trade_pref" value="8">茨城県
                    <input type="checkbox" name="vessel_trade_pref" value="9">栃木県
                    <input type="checkbox" name="vessel_trade_pref" value="10">群馬県
                    <input type="checkbox" name="vessel_trade_pref" value="11">埼玉県
                    <input type="checkbox" name="vessel_trade_pref" value="12">千葉県
                    <input type="checkbox" name="vessel_trade_pref" value="13">東京都
                    <input type="checkbox" name="vessel_trade_pref" value="14">神奈川県
                  </td>
                </tr>
                <tr>
                  <td>東海道・甲信越</td>
                  <td>
                    <input type="checkbox" name="vessel_trade_pref" value="15">新潟県
                    <input type="checkbox" name="vessel_trade_pref" value="16">富山県
                    <input type="checkbox" name="vessel_trade_pref" value="17">石川県
                    <input type="checkbox" name="vessel_trade_pref" value="18">福井県
                    <input type="checkbox" name="vessel_trade_pref" value="19">山梨県
                    <input type="checkbox" name="vessel_trade_pref" value="20">長野県
                    <input type="checkbox" name="vessel_trade_pref" value="21">岐阜県
                    <input type="checkbox" name="vessel_trade_pref" value="22">静岡県
                    <input type="checkbox" name="vessel_trade_pref" value="23">愛知県
                    <input type="checkbox" name="vessel_trade_pref" value="24">三重県
                  </td>
                </tr>
                <tr>
                  <td>関西</td>
                  <td>
                    <input type="checkbox" name="vessel_trade_pref" value="25">滋賀県
                    <input type="checkbox" name="vessel_trade_pref" value="26">京都府
                    <input type="checkbox" name="vessel_trade_pref" value="27">大阪府
                    <input type="checkbox" name="vessel_trade_pref" value="28">兵庫県
                    <input type="checkbox" name="vessel_trade_pref" value="29">奈良県
                    <input type="checkbox" name="vessel_trade_pref" value="30">和歌山県
                  </td>
                </tr>
                <tr>
                  <td>中国・四国</td>
                  <td>
                    <input type="checkbox" name="vessel_trade_pref" value="31">鳥取県
                    <input type="checkbox" name="vessel_trade_pref" value="32">島根県
                    <input type="checkbox" name="vessel_trade_pref" value="33">岡山県
                    <input type="checkbox" name="vessel_trade_pref" value="34">広島県
                    <input type="checkbox" name="vessel_trade_pref" value="35">山口県
                    <input type="checkbox" name="vessel_trade_pref" value="36">徳島県
                    <input type="checkbox" name="vessel_trade_pref" value="37">香川県
                    <input type="checkbox" name="vessel_trade_pref" value="38">愛媛県
                    <input type="checkbox" name="vessel_trade_pref" value="39">高知県
                  </td>
                </tr>
                <tr>
                  <td>九州・沖縄</td>
                  <td>
                    <input type="checkbox" name="vessel_trade_pref" value="40">福岡県
                    <input type="checkbox" name="vessel_trade_pref" value="41">佐賀県
                    <input type="checkbox" name="vessel_trade_pref" value="42">長崎県
                    <input type="checkbox" name="vessel_trade_pref" value="43">熊本県
                    <input type="checkbox" name="vessel_trade_pref" value="44">大分県
                    <input type="checkbox" name="vessel_trade_pref" value="45">宮崎県
                    <input type="checkbox" name="vessel_trade_pref" value="46">鹿児島県
                    <input type="checkbox" name="vessel_trade_pref" value="47">沖縄県
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td>主な寄港先(港)</td>
            <td><input type="text" name="vessel_trade_port"></td>
          </tr>
        </table>
        <div>船種・船型</div>
        <table class="">
          <tr>
            <td>船種</td>
            <td><select name="vessel_type">
              <option value="">下記から選択</option>
              <optgroup label="ガス船">
                <option value="10">ガス船全般</option>
                <option value="11">LNG船</option>
                <option value="12">LPG船</option>
                <option value="13">エタン船</option>
                <option value="14">エチレン船</option>
                <option value="15">アンモニア船</option>
                <option value="16">液化CO2船</option>
                <option value="17">液化水素船</option>
              </optgroup>
              <optgroup label="バルカー">
                <option value="20">バルカー全般</option>
                <option value="21">石炭専用船</option>
                <option value="22">石炭灰専用船</option>
                <option value="23">コークス専用船</option>
                <option value="24">鉱石専用船</option>
                <option value="25">鋼材専用船</option>
                <option value="26">穀物専用船</option>
                <option value="27">セメント専用船</option>
              </optgroup>
              <optgroup label="タンカー">
                <option value="30">タンカー全般</option>
                <option value="31">オイルタンカー</option>
                <option value="32">プロダクトタンカー</option>
                <option value="33">ケミカルタンカー</option>
              </optgroup>
              <optgroup label="他貨物船">
                <option value="40">他貨物船</option>
                <option value="41">コンテナ船</option>
                <option value="42">自動車運搬船</option>
                <option value="43">RORO船</option>
                <option value="44">重量貨物船</option>
              </optgroup>
              <optgroup label="旅客船・作業船">
                <option value="51">旅客船</option>
                <option value="52">ROPAX船</option>
                <option value="60">作業船一般</option>
                <option value="61">SEP船</option>
                <option value="62">SOV</option>
                <option value="63">CTV</option>
                <option value="64">タグボート</option>
                <option value="65">漁船</option>
              </optgroup>
            </select></td>
          </tr>
          <tr>
            <td>総トン数(GT)</td>
            <td><input type="number" name="vessel_gt"></td>
          </tr>
          <tr>
            <td>純トン数(NT)</td>
            <td><input type="number" name="vessel_nt"></td>
          </tr>
          <tr>
            <td>載貨重量トン数(DWT)</td>
            <td><input type="number" name="vessel_dwt"></td>
          </tr>
          <tr>
            <td>タンク容積(m3) ※ガス船のみ</td>
            <td><input type="number" name="vessel_tank"></td>
          </tr>
          <tr>
            <td>コンテナ積載数量(TEU) ※コンテナ船のみ</td>
            <td><input type="number" name="vessel_tank"></td>
          </tr>
          <tr>
            <td>全長/Loa(m)</td>
            <td><input type="number" name="vessel_loa"></td>
          </tr>
          <tr>
            <td>船幅/Beam(m)</td>
            <td><input type="number" name="vessel_beam"></td>
          </tr>
          <tr>
            <td>深さ/Depth(m)</td>
            <td><input type="number" name="vessel_depth"></td>
          </tr>
          <tr>
            <td>喫水/Draft(m)</td>
            <td><input type="number" name="vessel_draft"></td>
          </tr>
        </table>
        <div>技術情報</div>
        <table class="">
          <tr>
            <td>造船所</td>
            <td><input type="text" name="vessel_sy"></td>
          </tr>
          <tr>
            <td>竣工年月日</td>
            <td><input type="date" name="vessel_built"></td>
          </tr>
          <tr>
            <td>主機型式</td>
            <td><input type="text" name="vessel_me"></td>
          </tr>
          <tr>
            <td>燃料</td>
            <td>
              <table>
                <tr>
                  <td>従来燃料</td>
                  <td>
                    <input type="checkbox" name="vessel_fuel" value="1">軽油
                    <input type="checkbox" name="vessel_fuel" value="2">A重油
                    <input type="checkbox" name="vessel_fuel" value="3">B重油
                    <input type="checkbox" name="vessel_fuel" value="4">C重油
                  </td>
                </tr>
                <tr>
                  <td>次世代燃料</td>
                  <td>
                    <input type="checkbox" name="vessel_fuel" value="5">LNG
                    <input type="checkbox" name="vessel_fuel" value="6">LPG
                    <input type="checkbox" name="vessel_fuel" value="7">メタノール
                    <input type="checkbox" name="vessel_fuel" value="8">アンモニア
                    <input type="checkbox" name="vessel_fuel" value="9">電気推進
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        <input type="submit" value="登録">
      </form>
    </main>
    <footer>
    </footer>
  </div>
</body>
