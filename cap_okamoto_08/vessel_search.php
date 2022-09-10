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
      <div class="filter">
        <h2>検索条件</h2>
        <table id="vessel_search_filter_0">
          <tr>
            <th id="vessel_operational">
              <a>運航情報</a>
              <div class="filter_item">
                <a id="vessel_name_jp">船名 (日本語)</a>
                <a id="vessel_name_en">船名 (英文)</a>
                <a id="manager">船舶管理会社</a>
                <a id="operator">オペレーター</a>
                <a id="vessel_reg_port">船籍港</a>
                <a id="vessel_trade_pref">主な寄港先(都道府県)</a>
                <a id="vessel_trade_port">主な寄港先(港)</a>
              </div>
            </th>
            <th id="vessel_type_size">
              <a>船種・船型</a>
              <div class="filter_item">
                <a id="vessel_type">船種</a>
                <a id="vessel_gt">総トン数</a>
                <a id="vessel_nt">純トン数</a>
                <a id="vessel_dwt">載貨重量トン数</a>
                <a id="vessel_tank">タンク容積(ガス船のみ)</a>
                <a id="vessel_teu">TEU(コンテナ船のみ)</a>
                <a id="vessel_loa">全長/Loa</a>
                <a id="vessel_beam">船幅/Beam</a>
                <a id="vessel_depth">深さ/Depth</a>
                <a id="vessel_draft">喫水/draft</a>
                <a id="vessel_crew">定員数</a>
              </div>
            </th>
            <th id="vessel_technical">
              <a>技術情報</a>
              <div class="filter_item">
                <a id="vessel_sy">造船所</a>
                <a id="vessel_built">建造年</a>
                <a id="vessel_me">主機型式</a>
                <a id="vessel_fuel">燃料</a>
              </div>
            </th>
            <th id="vessel_owner">
              <a>船主情報</a>
              <div class="filter_item">
                <a id="owner_name">船主名</a>
                <a id="p_region">所在地</a>
                <a id="owner_foundation">創業年</a>
                <a id="owner_capital">資本金</a>
                <a id="owner_employee">従業員数</a>
                <a id="owner_vessel">保有隻数</a>
                <a id="owner_cost">関心事項(運航コスト)</a>
                <a id="owner_crew_mng">関心事項(船員・安全運航)</a>
                <a id="owner_group">関心事項(船主グループ化)</a>
                <a id="owner_decarbon">関心事項(脱炭素化)</a>
              </div>
            </th>
          </tr>
        </table>
        <table id="vessel_search_filter"><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr></table>
        <!-- $("#vessel_search_filter").append -->
        <button id="search">検索</button>
      </div>
      <div class="result">
        <h2>検索結果</h2>
        <div id="table_vessel"><?=$view?></div>
      </div>
    </main>
    <footer>
    </footer>
  </div>
</body>

<script>
  var filter = "";
  var cnt_vessel_name_jp = 0;
  var cnt_vessel_name_en = 0;
  var cnt_manager = 0;
  var cnt_operator = 0;
  var cnt_vessel_reg_port = 0;
  var cnt_vessel_trade_pref = 0;
  var cnt_vessel_trade_port = 0;

  var cnt_vessel_type = 0;
  var cnt_vessel_gt = 0;
  var cnt_vessel_nt = 0;
  var cnt_vessel_dwt = 0;
  var cnt_vessel_tank = 0;
  var cnt_vessel_teu = 0;
  var cnt_vessel_loa = 0;
  var cnt_vessel_beam = 0;
  var cnt_vessel_depth = 0;
  var cnt_vessel_draft = 0;
  var cnt_vessel_crew = 0;

  var cnt_vessel_sy = 0;
  var cnt_vessel_built = 0;
  var cnt_vessel_me = 0;
  var cnt_vessel_fuel = 0;

  var cnt_owner_name = 0;
  var cnt_p_region = 0;
  var cnt_owner_foundation = 0;
  var cnt_owner_capital = 0;
  var cnt_owner_employee = 0;
  var cnt_owner_vessel = 0;
  var cnt_owner_cost = 0;
  var cnt_owner_crew_mng = 0;
  var cnt_owner_group = 0;
  var cnt_owner_decarbon = 0;

  // 運航情報
  $("#vessel_name_jp").on("click", function(){
    cnt_vessel_name_jp += 1;
    filter = `<tr>`;
    filter += `<td colspan="2">船名(日本語)</td>`;
    filter += `<td colspan="3"><input type="text" id="vessel_name_jp_${cnt_vessel_name_jp}" required></td>`;
    filter += `<td colspan="1"><select id="op_vessel_name_jp_${cnt_vessel_name_jp}"><option value="含む">含む</option><option value="含まない">含まない</option></select></td>`;
    filter += `<td colspan="3"></td>`;
    filter += `<td colspan="1"><button class="remove">削除</button></td>`;
    filter += `</tr>`;
    $("#vessel_search_filter").append(filter);
  });

  $("#vessel_name_en").on("click", function(){
    cnt_vessel_name_en += 1;
    filter = `<tr>`;
    filter += `<td colspan="2">船名(英文)</td>`;
    filter += `<td colspan="3"><input type="text" id="vessel_name_en_${cnt_vessel_name_en}" required></td>`;
    filter += `<td colspan="1"><select id="op_vessel_name_en_${cnt_vessel_name_en}"><option value="含む">含む</option><option value="含まない">含まない</option></select></td>`;
    filter += `<td colspan="3"></td>`;
    filter += `<td colspan="1"><button class="remove">削除</button></td>`;
    filter += `</tr>`;
    $("#vessel_search_filter").append(filter);
  });

  $("#manager").on("click", function(){
    cnt_manager += 1;
    filter = `<tr>`;
    filter += `<td colspan="2">船舶管理会社</td>`;
    filter += `<td colspan="3"><input type="text" id="manager_${cnt_manager}" required></td>`;
    filter += `<td colspan="1"><select id="op_manager_${cnt_manager}"><option value="含む">含む</option><option value="含まない">含まない</option></select></td>`;
    filter += `<td colspan="3"></td>`;
    filter += `<td colspan="1"><button class="remove">削除</button></td>`;
    filter += `</tr>`;
    $("#vessel_search_filter").append(filter);
  });

  $("#operator").on("click", function(){
    cnt_operator += 1;
    filter = `<tr>`;
    filter += `<td colspan="2">オペレーター</td>`;
    filter += `<td colspan="3"><input type="text" id="operator_${cnt_operator}" required></td>`;
    filter += `<td colspan="1"><select id="op_operator_${cnt_operator}"><option value="含む">含む</option><option value="含まない">含まない</option></select></td>`;
    filter += `<td colspan="3"></td>`;
    filter += `<td colspan="1"><button class="remove">削除</button></td>`;
    filter += `</tr>`;
    $("#vessel_search_filter").append(filter);
  });

  $("#vessel_reg_port").on("click", function(){
    cnt_vessel_reg_port += 1;
    filter = `<tr>`;
    filter += `<td colspan="2">船籍港</td>`;
    filter += `<td colspan="3"><input type="text" id="vessel_reg_port_${cnt_vessel_reg_port}" required></td>`;
    filter += `<td colspan="1"><select id="op_vessel_reg_port_${cnt_vessel_reg_port}"><option value="含む">含む</option><option value="含まない">含まない</option></select></td>`;
    filter += `<td colspan="3"></td>`;
    filter += `<td colspan="1"><button class="remove">削除</button></td>`;
    filter += `</tr>`;
    $("#vessel_search_filter").append(filter);
  });

  $("#vessel_trade_pref").on("click", function(){
    cnt_vessel_trade_pref += 1;
    filter = `<tr>`;
    filter += `<td colspan="2">主な寄港先(都道府県)</td>`;
    filter += `<td colspan="3"><select id="vessel_trade_pref_${cnt_vessel_trade_pref}"><optgroup label="北海道・東北"><option value="北海道">北海道</option><option value="青森県">青森県</option><option value="岩手県">岩手県</option><option value="宮城県">宮城県</option><option value="秋田県">秋田県</option><option value="山形県">山形県</option><option value="福島県">福島県</option><optgroup label="関東"><option value="茨城県">茨城県</option><option value="栃木県">栃木県</option><option value="群馬県">群馬県</option><option value="埼玉県">埼玉県</option><option value="千葉県">千葉県</option><option value="東京都">東京都</option><option value="神奈川県">神奈川県</option><optgroup label="東海道・甲信越"><option value="新潟県">新潟県</option><option value="富山県">富山県</option><option value="石川県">石川県</option><option value="福井県">福井県</option><option value="山梨県">山梨県</option><option value="長野県">長野県</option><option value="岐阜県">岐阜県</option><option value="静岡県">静岡県</option><option value="愛知県">愛知県</option><option value="三重県">三重県</option><optgroup label="関西"><option value="滋賀県">滋賀県</option><option value="京都府">京都府</option><option value="大阪府">大阪府</option><option value="兵庫県">兵庫県</option><option value="奈良県">奈良県</option><option value="和歌山県">和歌山県</option><optgroup label="中国・四国"><option value="鳥取県">鳥取県</option><option value="島根県">島根県</option><option value="岡山県">岡山県</option><option value="広島県">広島県</option><option value="山口県">山口県</option><option value="徳島県">徳島県</option><option value="香川県">香川県</option><option value="愛媛県">愛媛県</option><option value="高知県">高知県</option><optgroup label="九州・沖縄"><option value="福岡県">福岡県</option><option value="佐賀県">佐賀県</option><option value="長崎県">長崎県</option><option value="熊本県">熊本県</option><option value="大分県">大分県</option><option value="宮崎県">宮崎県</option><option value="鹿児島県">鹿児島県</option><option value="沖縄県">沖縄県</option></select></td>`;
    filter += `<td colspan="1"><select id="op_vessel_trade_pref_${cnt_vessel_trade_pref}"><option value="含む">含む</option><option value="含まない">含まない</option></select></td>`;
    filter += `<td colspan="3"></td>`;
    filter += `<td colspan="1"><button class="remove">削除</button></td>`;
    filter += `</tr>`;
    $("#vessel_search_filter").append(filter);
  });

  $("#vessel_trade_port").on("click", function(){
    cnt_vessel_trade_port += 1;
    filter = `<tr>`;
    filter += `<td colspan="2">主な寄港先(港)</td>`;
    filter += `<td colspan="3"><input type="text" id="vessel_trade_port_${cnt_vessel_trade_port}" required></td>`;
    filter += `<td colspan="1"><select id="op_vessel_trade_port_${cnt_vessel_trade_port}"><option value="含む">含む</option><option value="含まない">含まない</option></select></td>`;
    filter += `<td colspan="3"></td>`;
    filter += `<td colspan="1"><button class="remove">削除</button></td>`;
    filter += `</tr>`;
    $("#vessel_search_filter").append(filter);
  });

  // 船種・船型
  $("#vessel_type").on("click", function(){
    cnt_vessel_type += 1;
    filter = `<tr>`;
    filter += `<td colspan="2">船種</td>`;
    filter += `<td colspan="3"><select id="vessel_type_${cnt_vessel_type}" required><optgroup label="ガス船"><option value="LNG船">LNG船</option><option value="LPG船">LPG船</option><option value="エタン船">エタン船</option><option value="エチレン船">エチレン船</option><option value="アンモニア船">アンモニア船</option><option value="液化CO2船">液化CO2船</option><option value="液化水素船">液化水素船</option><option value="ガス船全般">ガス船全般</option><optgroup label="バルカー"><option value="石炭専用船">石炭専用船</option><option value="石炭灰専用船">石炭灰専用船</option><option value="コークス専用船">コークス専用船</option><option value="鉱石専用船">鉱石専用船</option><option value="鋼材専用船">鋼材専用船</option><option value="穀物専用船">穀物専用船</option><option value="セメント専用船">セメント専用船</option><option value="バルカー全般">バルカー全般</option><optgroup label="タンカー"><option value="オイルタンカー">オイルタンカー</option><option value="プロダクトタンカー">プロダクトタンカー</option><option value="ケミカルタンカー">ケミカルタンカー</option><option value="タンカー全般">タンカー全般</option><optgroup label="他貨物船"><option value="コンテナ船">コンテナ船</option><option value="自動車運搬船">自動車運搬船</option><option value="RORO船">RORO船</option><option value="重量貨物船">重量貨物船</option><option value="他貨物船">他貨物船</option><optgroup label="旅客船・作業船"><option value="旅客船">旅客船</option><option value="ROPAX船">ROPAX船</option><option value="作業船一般">作業船一般</option><option value="SEP船">SEP船</option><option value="SOV">SOV</option><option value="CTV">CTV</option><option value="タグボート">タグボート</option><option value="漁船">漁船</option></select></td>`;
    filter += `<td colspan="1"><select id="op_vessel_type_${cnt_vessel_type}"><option value="含む">含む</option><option value="含まない">含まない</option></select></td>`;
    filter += `<td colspan="3"></td>`;
    filter += `<td colspan="1"><button class="remove">削除</button></td>`;
    filter += `</tr>`;
    $("#vessel_search_filter").append(filter);
  });

  $("#vessel_gt").on("click", function(){
    cnt_vessel_gt += 1;
    filter = `<tr>`;
    filter += `<td colspan="2">総トン数</td>`;
    filter += `<td colspan="1"><select id="op_vessel_gt_${cnt_vessel_gt}"><option value="<"><</option><option value="<="><=</option><option value="=">=</option><option value=">=">>=</option><option value=">">></option></select></td>`;
    filter += `<td colspan="3"><input type="number" id="vessel_gt_${cnt_vessel_gt}" required>トン</td>`;
    filter += `<td colspan="3"></td>`;
    filter += `<td colspan="1"><button class="remove">削除</button></td>`;
    filter += `</tr>`;
    $("#vessel_search_filter").append(filter);
  });

  $("#vessel_nt").on("click", function(){
    cnt_vessel_nt += 1;
    filter = `<tr>`;
    filter += `<td colspan="2">純トン数</td>`;
    filter += `<td colspan="1"><select id="op_vessel_nt_${cnt_vessel_nt}"><option value="<"><</option><option value="<="><=</option><option value="=">=</option><option value=">=">>=</option><option value=">">></option></select></td>`;
    filter += `<td colspan="3"><input type="number" id="vessel_nt_${cnt_vessel_nt}" required>トン</td>`;
    filter += `<td colspan="3"></td>`;
    filter += `<td colspan="1"><button class="remove">削除</button></td>`;
    filter += `</tr>`;
    $("#vessel_search_filter").append(filter);
  });

  $("#vessel_dwt").on("click", function(){
    cnt_vessel_dwt += 1;
    filter = `<tr>`;
    filter += `<td colspan="2">載貨重量トン数</td>`;
    filter += `<td colspan="1"><select id="op_vessel_dwt_${cnt_vessel_dwt}"><option value="<"><</option><option value="<="><=</option><option value="=">=</option><option value=">=">>=</option><option value=">">></option></select></td>`;
    filter += `<td colspan="3"><input type="number" id="vessel_dwt_${cnt_vessel_dwt}" required>DWT</td>`;
    filter += `<td colspan="3"></td>`;
    filter += `<td colspan="1"><button class="remove">削除</button></td>`;
    filter += `</tr>`;
    $("#vessel_search_filter").append(filter);
  });

  $("#vessel_tank").on("click", function(){
    cnt_vessel_tank += 1;
    filter = `<tr>`;
    filter += `<td colspan="2">タンク容積(ガス船のみ)</td>`;
    filter += `<td colspan="1"><select id="op_vessel_tank_${cnt_vessel_tank}"><option value="<"><</option><option value="<="><=</option><option value="=">=</option><option value=">=">>=</option><option value=">">></option></select></td>`;
    filter += `<td colspan="3"><input type="number" id="vessel_tank_${cnt_vessel_tank}" required>m3</td>`;
    filter += `<td colspan="3"></td>`;
    filter += `<td colspan="1"><button class="remove">削除</button></td>`;
    filter += `</tr>`;
    $("#vessel_search_filter").append(filter);
  });

  $("#vessel_teu").on("click", function(){
    cnt_vessel_teu += 1;
    filter = `<tr>`;
    filter += `<td colspan="2">TEU(コンテナ船のみ)</td>`;
    filter += `<td colspan="1"><select id="op_vessel_teu_${cnt_vessel_teu}"><option value="<"><</option><option value="<="><=</option><option value="=">=</option><option value=">=">>=</option><option value=">">></option></select></td>`;
    filter += `<td colspan="3"><input type="number" id="vessel_teu_${cnt_vessel_teu}" required>TEU</td>`;
    filter += `<td colspan="3"></td>`;
    filter += `<td colspan="1"><button class="remove">削除</button></td>`;
    filter += `</tr>`;
    $("#vessel_search_filter").append(filter);
  });

  $("#vessel_loa").on("click", function(){
    cnt_vessel_loa += 1;
    filter = `<tr>`;
    filter += `<td colspan="2">全長/Loa</td>`;
    filter += `<td colspan="1"><select id="op_vessel_loa_${cnt_vessel_loa}"><option value="<"><</option><option value="<="><=</option><option value="=">=</option><option value=">=">>=</option><option value=">">></option></select></td>`;
    filter += `<td colspan="3"><input type="number" id="vessel_loa_${cnt_vessel_loa}" required>m</td>`;
    filter += `<td colspan="3"></td>`;
    filter += `<td colspan="1"><button class="remove">削除</button></td>`;
    filter += `</tr>`;
    $("#vessel_search_filter").append(filter);
  });

  $("#vessel_beam").on("click", function(){
    cnt_vessel_beam += 1;
    filter = `<tr>`;
    filter += `<td colspan="2">船幅/Beam</td>`;
    filter += `<td colspan="1"><select id="op_vessel_beam_${cnt_vessel_beam}"><option value="<"><</option><option value="<="><=</option><option value="=">=</option><option value=">=">>=</option><option value=">">></option></select></td>`;
    filter += `<td colspan="3"><input type="number" id="vessel_beam_${cnt_vessel_beam}" required>m</td>`;
    filter += `<td colspan="3"></td>`;
    filter += `<td colspan="1"><button class="remove">削除</button></td>`;
    filter += `</tr>`;
    $("#vessel_search_filter").append(filter);
  });

  $("#vessel_depth").on("click", function(){
    cnt_vessel_depth += 1;
    filter = `<tr>`;
    filter += `<td colspan="2">深さ/Depth</td>`;
    filter += `<td colspan="1"><select id="op_vessel_depth_${cnt_vessel_depth}"><option value="<"><</option><option value="<="><=</option><option value="=">=</option><option value=">=">>=</option><option value=">">></option></select></td>`;
    filter += `<td colspan="3"><input type="number" id="vessel_depth_${cnt_vessel_depth}" required>m</td>`;
    filter += `<td colspan="3"></td>`;
    filter += `<td colspan="1"><button class="remove">削除</button></td>`;
    filter += `</tr>`;
    $("#vessel_search_filter").append(filter);
  });

  $("#vessel_draft").on("click", function(){
    cnt_vessel_draft += 1;
    filter = `<tr>`;
    filter += `<td colspan="2">喫水/draft</td>`;
    filter += `<td colspan="1"><select id="op_vessel_draft_${cnt_vessel_draft}"><option value="<"><</option><option value="<="><=</option><option value="=">=</option><option value=">=">>=</option><option value=">">></option></select></td>`;
    filter += `<td colspan="3"><input type="number" id="vessel_draft_${cnt_vessel_draft}" required>m</td>`;
    filter += `<td colspan="3"></td>`;
    filter += `<td colspan="1"><button class="remove">削除</button></td>`;
    filter += `</tr>`;
    $("#vessel_search_filter").append(filter);
  });

  $("#vessel_crew").on("click", function(){
    cnt_vessel_crew += 1;
    filter = `<tr>`;
    filter += `<td colspan="2">定員数</td>`;
    filter += `<td colspan="1"><select id="op_vessel_crew_${cnt_vessel_crew}"><option value="<"><</option><option value="<="><=</option><option value="=">=</option><option value=">=">>=</option><option value=">">></option></select></td>`;
    filter += `<td colspan="3"><input type="number" id="vessel_crew_${cnt_vessel_crew}" required>m</td>`;
    filter += `<td colspan="3"></td>`;
    filter += `<td colspan="1"><button class="remove">削除</button></td>`;
    filter += `</tr>`;
    $("#vessel_search_filter").append(filter);
  });

  // 技術情報
  $("#vessel_sy").on("click", function(){
    cnt_vessel_sy += 1;
    filter = `<tr>`;
    filter += `<td colspan="2">造船所</td>`;
    filter += `<td colspan="3"><input type="text" id="vessel_sy_${cnt_vessel_sy}" required></td>`;
    filter += `<td colspan="1"><select id="op_vessel_sy_${cnt_vessel_sy}"><option value="含む">含む</option><option value="含まない">含まない</option></select></td>`;
    filter += `<td colspan="3"></td>`;
    filter += `<td colspan="1"><button class="remove">削除</button></td>`;
    filter += `</tr>`;
    $("#vessel_search_filter").append(filter);
  });

  $("#vessel_built").on("click", function(){
    cnt_vessel_built += 1;
    filter = `<tr>`;
    filter += `<td colspan="2">建造年</td>`;
    filter += `<td colspan="1"><select id="op_vessel_built_${cnt_vessel_built}"><option value="<"><</option><option value="<="><=</option><option value="=">=</option><option value=">=">>=</option><option value=">">></option></select></td>`;
    filter += `<td colspan="3"><input type="number" min="1900" max="2022" id="vessel_built_${cnt_vessel_built}" required>年</td>`;
    filter += `<td colspan="3"></td>`;
    filter += `<td colspan="1"><button class="remove">削除</button></td>`;
    filter += `</tr>`;
    $("#vessel_search_filter").append(filter);
  });

  $("#vessel_me").on("click", function(){
    cnt_vessel_me += 1;
    filter = `<tr>`;
    filter += `<td colspan="2">主機型式</td>`;
    filter += `<td colspan="3"><input type="text" id="vessel_me_${cnt_vessel_me}" required></td>`;
    filter += `<td colspan="1"><select id="op_vessel_me_${cnt_vessel_me}"><option value="含む">含む</option><option value="含まない">含まない</option></select></td>`;
    filter += `<td colspan="3"></td>`;
    filter += `<td colspan="1"><button class="remove">削除</button></td>`;
    filter += `</tr>`;
    $("#vessel_search_filter").append(filter);
  });

  $("#vessel_fuel").on("click", function(){
    cnt_vessel_fuel += 1;
    filter = `<tr>`;
    filter += `<td colspan="2">燃料</td>`;
    filter += `<td colspan="3"><select id="vessel_fuel_${cnt_vessel_fuel}"><option value="軽油">軽油</option><option value="A重油">A重油</option><option value="B重油">B重油</option><option value="C重油">C重油</option><option value="LNG">LNG</option><option value="LPG">LPG</option><option value="メタノール">メタノール</option><option value="アンモニア">アンモニア</option><option value="電気推進">電気推進</option></select></td>`;
    filter += `<td colspan="1"><select id="op_vessel_fuel_${cnt_vessel_fuel}"><option value="含む">含む</option><option value="含まない">含まない</option></select></td>`;
    filter += `<td colspan="3"></td>`;
    filter += `<td colspan="1"><button class="remove">削除</button></td>`;
    filter += `</tr>`;
    $("#vessel_search_filter").append(filter);
  });

  // 船主情報
  $("#owner_name").on("click", function(){
    cnt_owner_name += 1;
    filter = `<tr>`;
    filter += `<td colspan="2">船主名</td>`;
    filter += `<td colspan="3"><input type="text" id="owner_name_${cnt_owner_name}" required></td>`;
    filter += `<td colspan="1"><select id="op_owner_name_${cnt_owner_name}"><option value="含む">含む</option><option value="含まない">含まない</option></select></td>`;
    filter += `<td colspan="3"></td>`;
    filter += `<td colspan="1"><button class="remove">削除</button></td>`;
    filter += `</tr>`;
    $("#vessel_search_filter").append(filter);
  });

  $("#p_region").on("click", function(){
    cnt_p_region += 1;
    filter = `<tr>`;
    filter += `<td colspan="2">所在地</td>`;
    filter += `<td colspan="3"><select id="p_region_${cnt_p_region}"><optgroup label="北海道・東北"><option value="北海道">北海道</option><option value="青森県">青森県</option><option value="岩手県">岩手県</option><option value="宮城県">宮城県</option><option value="秋田県">秋田県</option><option value="山形県">山形県</option><option value="福島県">福島県</option><optgroup label="関東"><option value="茨城県">茨城県</option><option value="栃木県">栃木県</option><option value="群馬県">群馬県</option><option value="埼玉県">埼玉県</option><option value="千葉県">千葉県</option><option value="東京都">東京都</option><option value="神奈川県">神奈川県</option><optgroup label="東海道・甲信越"><option value="新潟県">新潟県</option><option value="富山県">富山県</option><option value="石川県">石川県</option><option value="福井県">福井県</option><option value="山梨県">山梨県</option><option value="長野県">長野県</option><option value="岐阜県">岐阜県</option><option value="静岡県">静岡県</option><option value="愛知県">愛知県</option><option value="三重県">三重県</option><optgroup label="関西"><option value="滋賀県">滋賀県</option><option value="京都府">京都府</option><option value="大阪府">大阪府</option><option value="兵庫県">兵庫県</option><option value="奈良県">奈良県</option><option value="和歌山県">和歌山県</option><optgroup label="中国・四国"><option value="鳥取県">鳥取県</option><option value="島根県">島根県</option><option value="岡山県">岡山県</option><option value="広島県">広島県</option><option value="山口県">山口県</option><option value="徳島県">徳島県</option><option value="香川県">香川県</option><option value="愛媛県">愛媛県</option><option value="高知県">高知県</option><optgroup label="九州・沖縄"><option value="福岡県">福岡県</option><option value="佐賀県">佐賀県</option><option value="長崎県">長崎県</option><option value="熊本県">熊本県</option><option value="大分県">大分県</option><option value="宮崎県">宮崎県</option><option value="鹿児島県">鹿児島県</option><option value="沖縄県">沖縄県</option></select></td>`;
    filter += `<td colspan="1"><select id="op_p_region_${cnt_p_region}"><option value="含む">含む</option><option value="含まない">含まない</option></select></td>`;
    filter += `<td colspan="3"></td>`;
    filter += `<td colspan="1"><button class="remove">削除</button></td>`;
    filter += `</tr>`;
    $("#vessel_search_filter").append(filter);
  });

  $("#owner_foundation").on("click", function(){
    cnt_owner_foundation += 1;
    filter = `<tr>`;
    filter += `<td colspan="2">創業年</td>`;
    filter += `<td colspan="1"><select id="op_owner_foundation_${cnt_owner_foundation}"><option value="<"><</option><option value="<="><=</option><option value="=">=</option><option value=">=">>=</option><option value=">">></option></select></td>`;
    filter += `<td colspan="3"><input type="number" min="1800" max="2022" id="owner_foundation_${cnt_owner_foundation}" required>年</td>`;
    filter += `<td colspan="3"></td>`;
    filter += `<td colspan="1"><button class="remove">削除</button></td>`;
    filter += `</tr>`;
    $("#vessel_search_filter").append(filter);
  });

  $("#owner_capital").on("click", function(){
    cnt_owner_capital += 1;
    filter = `<tr>`;
    filter += `<td colspan="2">資本金</td>`;
    filter += `<td colspan="1"><select id="op_owner_capital_${cnt_owner_capital}"><option value="<"><</option><option value="<="><=</option><option value="=">=</option><option value=">=">>=</option><option value=">">></option></select></td>`;
    filter += `<td colspan="3"><input type="number" id="owner_capital_${cnt_owner_capital}" required>百万円</td>`;
    filter += `<td colspan="3"></td>`;
    filter += `<td colspan="1"><button class="remove">削除</button></td>`;
    filter += `</tr>`;
    $("#vessel_search_filter").append(filter);
  });

  $("#owner_employee").on("click", function(){
    cnt_owner_employee += 1;
    filter = `<tr>`;
    filter += `<td colspan="2">従業員数</td>`;
    filter += `<td colspan="1"><select id="op_owner_employee_${cnt_owner_employee}"><option value="<"><</option><option value="<="><=</option><option value="=">=</option><option value=">=">>=</option><option value=">">></option></select></td>`;
    filter += `<td colspan="3"><input type="number" id="owner_employee_${cnt_owner_employee}" required>人</td>`;
    filter += `<td colspan="3"></td>`;
    filter += `<td colspan="1"><button class="remove">削除</button></td>`;
    filter += `</tr>`;
    $("#vessel_search_filter").append(filter);
  });

  $("#owner_vessel").on("click", function(){
    cnt_owner_vessel += 1;
    filter = `<tr>`;
    filter += `<td colspan="2">保有隻数</td>`;
    filter += `<td colspan="1"><select id="op_owner_vessel_${cnt_owner_vessel}"><option value="<"><</option><option value="<="><=</option><option value="=">=</option><option value=">=">>=</option><option value=">">></option></select></td>`;
    filter += `<td colspan="3"><input type="number" min="1" id="owner_vessel_${cnt_owner_vessel}" required>隻</td>`;
    filter += `<td colspan="3"></td>`;
    filter += `<td colspan="1"><button class="remove">削除</button></td>`;
    filter += `</tr>`;
    $("#vessel_search_filter").append(filter);
  });

  $("#owner_cost").on("click", function(){
    cnt_owner_cost += 1;
    filter = `<tr>`;
    filter += `<td colspan="2">運航コスト</td>`;
    filter += `<td colspan="3"><select id="owner_cost_${cnt_owner_cost}"><option value="船員費の見直し">船員費の見直し</option><option value="燃料の共同調達">燃料の共同調達</option><option value="機器資材の共同調達">機器資材の共同調達</option><option value="機器資材の在庫共有">機器資材の在庫共有</option><option value="保険料の見直し">保険料の見直し</option><option value="船舶管理費の見直し">船舶管理費の見直し</option></select></td>`;
    filter += `<td colspan="1"><select id="op_owner_cost_${cnt_owner_cost}"><option value="含む">含む</option><option value="含まない">含まない</option></select></td>`;
    filter += `<td colspan="3"></td>`;
    filter += `<td colspan="1"><button class="remove">削除</button></td>`;
    filter += `</tr>`;
    $("#vessel_search_filter").append(filter);
  });

  $("#owner_crew_mng").on("click", function(){
    cnt_owner_crew_mng += 1;
    filter = `<tr>`;
    filter += `<td colspan="2">船員・安全運航</td>`;
    filter += `<td colspan="3"><select id="owner_crew_mng_${cnt_owner_crew_mng}"><option value="船員採用">船員採用</option><option value="船員育成・教育">船員育成・教育</option><option value="船員管理">船員管理</option><option value="船員融通">船員融通</option><option value="省人化・自動化">省人化・自動化</option><option value="オペレーションマニュアル">オペレーションマニュアル</option><option value="コロナ対策">コロナ対策</option></select></td>`;
    filter += `<td colspan="1"><select id="op_owner_crew_mng_${cnt_owner_crew_mng}"><option value="含む">含む</option><option value="含まない">含まない</option></select></td>`;
    filter += `<td colspan="3"></td>`;
    filter += `<td colspan="1"><button class="remove">削除</button></td>`;
    filter += `</tr>`;
    $("#vessel_search_filter").append(filter);
  });

  $("#owner_group").on("click", function(){
    cnt_owner_group += 1;
    filter = `<tr>`;
    filter += `<td colspan="2">船主グループ化</td>`;
    filter += `<td colspan="3"><select id="owner_group_${cnt_owner_group}"><option value="共同船舶管理会社">共同船舶管理会社</option><option value="合併">合併</option><option value="売船">売船</option><option value="買船">買船</option><option value="事業売却">事業売却</option><option value="事業買収">事業買収</option></select></td>`;
    filter += `<td colspan="1"><select id="op_owner_group_${cnt_owner_group}"><option value="含む">含む</option><option value="含まない">含まない</option></select></td>`;
    filter += `<td colspan="3"></td>`;
    filter += `<td colspan="1"><button class="remove">削除</button></td>`;
    filter += `</tr>`;
    $("#vessel_search_filter").append(filter);
  });

  $("#owner_decarbon").on("click", function(){
    cnt_owner_decarbon += 1;
    filter = `<tr>`;
    filter += `<td colspan="2">脱炭素化</td>`;
    filter += `<td colspan="3"><select id="owner_decarbon_${cnt_owner_decarbon}"><option value="排出量可視化">排出量可視化</option><option value="ウェザールーティング">ウェザールーティング</option><option value="帆">帆</option><option value="空気潤滑">空気潤滑</option><option value="船上回収">船上回収</option><option value="次世代主機・燃料">次世代主機・燃料</option></select></td>`;
    filter += `<td colspan="1"><select id="op_owner_decarbon_${cnt_owner_decarbon}"><option value="含む">含む</option><option value="含まない">含まない</option></select></td>`;
    filter += `<td colspan="3"></td>`;
    filter += `<td colspan="1"><button class="remove">削除</button></td>`;
    filter += `</tr>`;
    $("#vessel_search_filter").append(filter);
  });

  $(document).on("click",".remove", function(){
    $(this).parent().parent().remove();
  });

  let i = 0;
  $("#search").on("click", function(){
    const params = new URLSearchParams();
    // 運航情報
    i = 1;
    while(i <= cnt_vessel_name_jp){
      if($(`#vessel_name_jp_${i}`)[0]){
        params.append(`vessel_name_jp_${i}`, $(`#vessel_name_jp_${i}`).val());
        params.append(`op_vessel_name_jp_${i}`, $(`#op_vessel_name_jp_${i}`).val());
      };
      i++;
    };
    params.append(`cnt_vessel_name_jp`, cnt_vessel_name_jp);

    i = 1;
    while(i <= cnt_vessel_name_en){
      if($(`#vessel_name_en_${i}`)[0]){
        params.append(`vessel_name_en_${i}`, $(`#vessel_name_en_${i}`).val());
        params.append(`op_vessel_name_en_${i}`, $(`#op_vessel_name_en_${i}`).val());
      };
      i++;
    };
    params.append(`cnt_vessel_name_en`, cnt_vessel_name_en);

    i = 1;
    while(i <= cnt_manager){
      if($(`#manager_${i}`)[0]){
        params.append(`manager_${i}`, $(`#manager_${i}`).val());
        params.append(`op_manager_${i}`, $(`#op_manager_${i}`).val());
      };
      i++;
    };
    params.append(`cnt_manager`, cnt_manager);

    i = 1;
    while(i <= cnt_operator){
      if($(`#operator_${i}`)[0]){
        params.append(`operator_${i}`, $(`#operator_${i}`).val());
        params.append(`op_operator_${i}`, $(`#op_operator_${i}`).val());
      };
      i++;
    };
    params.append(`cnt_operator`, cnt_operator);

    i = 1;
    while(i <= cnt_vessel_reg_port){
      if($(`#vessel_reg_port_${i}`)[0]){
        params.append(`vessel_reg_port_${i}`, $(`#vessel_reg_port_${i}`).val());
        params.append(`op_vessel_reg_port_${i}`, $(`#op_vessel_reg_port_${i}`).val());
      };
      i++;
    };
    params.append(`cnt_vessel_reg_port`, cnt_vessel_reg_port);

    i = 1;
    while(i <= cnt_vessel_trade_pref){
      if($(`#vessel_trade_pref_${i}`)[0]){
        params.append(`vessel_trade_pref_${i}`, $(`#vessel_trade_pref_${i}`).val());
        params.append(`op_vessel_trade_pref_${i}`, $(`#op_vessel_trade_pref_${i}`).val());
      };
      i++;
    };
    params.append(`cnt_vessel_trade_pref`, cnt_vessel_trade_pref);

    i = 1;
    while(i <= cnt_vessel_trade_port){
      if($(`#vessel_trade_port_${i}`)[0]){
        params.append(`vessel_trade_port_${i}`, $(`#vessel_trade_port_${i}`).val());
        params.append(`op_vessel_trade_port_${i}`, $(`#op_vessel_trade_port_${i}`).val());
      };
      i++;
    };
    params.append(`cnt_vessel_trade_port`, cnt_vessel_trade_port);

    // 船種・船型
    i = 1;
    while(i <= cnt_vessel_type){
      if($(`#vessel_type_${i}`)[0]){
        params.append(`vessel_type_${i}`, $(`#vessel_type_${i}`).val());
        params.append(`op_vessel_type_${i}`, $(`#op_vessel_type_${i}`).val());
      };
      i++;
    };
    params.append(`cnt_vessel_type`, cnt_vessel_type);

    i = 1;
    while(i <= cnt_vessel_gt){
      if($(`#vessel_gt_${i}`)[0]){
        params.append(`vessel_gt_${i}`, $(`#vessel_gt_${i}`).val());
        params.append(`op_vessel_gt_${i}`, $(`#op_vessel_gt_${i}`).val());
      };
      i++;
    };
    params.append(`cnt_vessel_gt`, cnt_vessel_gt);

    i = 1;
    while(i <= cnt_vessel_nt){
      if($(`#vessel_nt_${i}`)[0]){
        params.append(`vessel_nt_${i}`, $(`#vessel_nt_${i}`).val());
        params.append(`op_vessel_nt_${i}`, $(`#op_vessel_nt_${i}`).val());
      };
      i++;
    };
    params.append(`cnt_vessel_nt`, cnt_vessel_nt);

    i = 1;
    while(i <= cnt_vessel_dwt){
      if($(`#vessel_dwt_${i}`)[0]){
        params.append(`vessel_dwt_${i}`, $(`#vessel_dwt_${i}`).val());
        params.append(`op_vessel_dwt_${i}`, $(`#op_vessel_dwt_${i}`).val());
      };
      i++;
    };
    params.append(`cnt_vessel_dwt`, cnt_vessel_dwt);

    i = 1;
    while(i <= cnt_vessel_tank){
      if($(`#vessel_tank_${i}`)[0]){
        params.append(`vessel_tank_${i}`, $(`#vessel_tank_${i}`).val());
        params.append(`op_vessel_tank_${i}`, $(`#op_vessel_tank_${i}`).val());
      };
      i++;
    };
    params.append(`cnt_vessel_tank`, cnt_vessel_tank);

    i = 1;
    while(i <= cnt_vessel_teu){
      if($(`#vessel_teu_${i}`)[0]){
        params.append(`vessel_teu_${i}`, $(`#vessel_teu_${i}`).val());
        params.append(`op_vessel_teu_${i}`, $(`#op_vessel_teu_${i}`).val());
      };
      i++;
    };
    params.append(`cnt_vessel_teu`, cnt_vessel_teu);

    i = 1;
    while(i <= cnt_vessel_loa){
      if($(`#vessel_loa_${i}`)[0]){
        params.append(`vessel_loa_${i}`, $(`#vessel_loa_${i}`).val());
        params.append(`op_vessel_loa_${i}`, $(`#op_vessel_loa_${i}`).val());
      };
      i++;
    };
    params.append(`cnt_vessel_loa`, cnt_vessel_loa);

    i = 1;
    while(i <= cnt_vessel_beam){
      if($(`#vessel_beam_${i}`)[0]){
        params.append(`vessel_beam_${i}`, $(`#vessel_beam_${i}`).val());
        params.append(`op_vessel_beam_${i}`, $(`#op_vessel_beam_${i}`).val());
      };
      i++;
    };
    params.append(`cnt_vessel_beam`, cnt_vessel_beam);

    i = 1;
    while(i <= cnt_vessel_depth){
      if($(`#vessel_depth_${i}`)[0]){
        params.append(`vessel_depth_${i}`, $(`#vessel_depth_${i}`).val());
        params.append(`op_vessel_depth_${i}`, $(`#op_vessel_depth_${i}`).val());
      };
      i++;
    };
    params.append(`cnt_vessel_depth`, cnt_vessel_depth);

    i = 1;
    while(i <= cnt_vessel_draft){
      if($(`#vessel_draft_${i}`)[0]){
        params.append(`vessel_draft_${i}`, $(`#vessel_draft_${i}`).val());
        params.append(`op_vessel_draft_${i}`, $(`#op_vessel_draft_${i}`).val());
      };
      i++;
    };
    params.append(`cnt_vessel_draft`, cnt_vessel_draft);

    i = 1;
    while(i <= cnt_vessel_crew){
      if($(`#vessel_crew_${i}`)[0]){
        params.append(`vessel_crew_${i}`, $(`#vessel_crew_${i}`).val());
        params.append(`op_vessel_crew_${i}`, $(`#op_vessel_crew_${i}`).val());
      };
      i++;
    };
    params.append(`cnt_vessel_crew`, cnt_vessel_crew);

    // 技術情報
    i = 1;
    while(i <= cnt_vessel_sy){
      if($(`#vessel_sy_${i}`)[0]){
        params.append(`vessel_sy_${i}`, $(`#vessel_sy_${i}`).val());
        params.append(`op_vessel_sy_${i}`, $(`#op_vessel_sy_${i}`).val());
      };
      i++;
    };
    params.append(`cnt_vessel_sy`, cnt_vessel_sy);

    i = 1;
    while(i <= cnt_vessel_built){
      if($(`#vessel_built_${i}`)[0]){
        params.append(`vessel_built_${i}`, $(`#vessel_built_${i}`).val());
        params.append(`op_vessel_built_${i}`, $(`#op_vessel_built_${i}`).val());
      };
      i++;
    };
    params.append(`cnt_vessel_built`, cnt_vessel_built);

    i = 1;
    while(i <= cnt_vessel_me){
      if($(`#vessel_me_${i}`)[0]){
        params.append(`vessel_me_${i}`, $(`#vessel_me_${i}`).val());
        params.append(`op_vessel_me_${i}`, $(`#op_vessel_me_${i}`).val());
      };
      i++;
    };
    params.append(`cnt_vessel_me`, cnt_vessel_me);

    i = 1;
    while(i <= cnt_vessel_fuel){
      if($(`#vessel_fuel_${i}`)[0]){
        params.append(`vessel_fuel_${i}`, $(`#vessel_fuel_${i}`).val());
        params.append(`op_vessel_fuel_${i}`, $(`#op_vessel_fuel_${i}`).val());
      };
      i++;
    };
    params.append(`cnt_vessel_fuel`, cnt_vessel_fuel);

    // 船主情報
    i = 1;
    while(i <= cnt_owner_name){
      if($(`#owner_name_${i}`)[0]){
        params.append(`owner_name_${i}`, $(`#owner_name_${i}`).val());
        params.append(`op_owner_name_${i}`, $(`#op_owner_name_${i}`).val());
      };
      i++;
    };
    params.append(`cnt_owner_name`, cnt_owner_name);

    i = 1;
    while(i <= cnt_p_region){
      if($(`#p_region_${i}`)[0]){
        params.append(`p_region_${i}`, $(`#p_region_${i}`).val());
        params.append(`op_p_region_${i}`, $(`#op_p_region_${i}`).val());
      };
      i++;
    };
    params.append(`cnt_p_region`, cnt_p_region);

    i = 1;
    while(i <= cnt_owner_foundation){
      if($(`#owner_foundation_${i}`)[0]){
        params.append(`owner_foundation_${i}`, $(`#owner_foundation_${i}`).val());
        params.append(`op_owner_foundation_${i}`, $(`#op_owner_foundation_${i}`).val());
      };
      i++;
    };
    params.append(`cnt_owner_foundation`, cnt_owner_foundation);

    i = 1;
    while(i <= cnt_owner_capital){
      if($(`#owner_capital_${i}`)[0]){
        params.append(`owner_capital_${i}`, $(`#owner_capital_${i}`).val());
        params.append(`op_owner_capital_${i}`, $(`#op_owner_capital_${i}`).val());
      };
      i++;
    };
    params.append(`cnt_owner_capital`, cnt_owner_capital);

    i = 1;
    while(i <= cnt_owner_employee){
      if($(`#owner_employee_${i}`)[0]){
        params.append(`owner_employee_${i}`, $(`#owner_employee_${i}`).val());
        params.append(`op_owner_employee_${i}`, $(`#op_owner_employee_${i}`).val());
      };
      i++;
    };
    params.append(`cnt_owner_employee`, cnt_owner_employee);

    i = 1;
    while(i <= cnt_owner_vessel){
      if($(`#owner_vessel_${i}`)[0]){
        params.append(`owner_vessel_${i}`, $(`#owner_vessel_${i}`).val());
        params.append(`op_owner_vessel_${i}`, $(`#op_owner_vessel_${i}`).val());
      };
      i++;
    };
    params.append(`cnt_owner_vessel`, cnt_owner_vessel);

    i = 1;
    while(i <= cnt_owner_cost){
      if($(`#owner_cost_${i}`)[0]){
        params.append(`owner_cost_${i}`, $(`#owner_cost_${i}`).val());
        params.append(`op_owner_cost_${i}`, $(`#op_owner_cost_${i}`).val());
      };
      i++;
    };
    params.append(`cnt_owner_cost`, cnt_owner_cost);

    i = 1;
    while(i <= cnt_owner_crew_mng){
      if($(`#owner_crew_mng_${i}`)[0]){
        params.append(`owner_crew_mng_${i}`, $(`#owner_crew_mng_${i}`).val());
        params.append(`op_owner_crew_mng_${i}`, $(`#op_owner_crew_mng_${i}`).val());
      };
      i++;
    };
    params.append(`cnt_owner_crew_mng`, cnt_owner_crew_mng);

    i = 1;
    while(i <= cnt_owner_group){
      if($(`#owner_group_${i}`)[0]){
        params.append(`owner_group_${i}`, $(`#owner_group_${i}`).val());
        params.append(`op_owner_group_${i}`, $(`#op_owner_group_${i}`).val());
      };
      i++;
    };
    params.append(`cnt_owner_group`, cnt_owner_group);

    i = 1;
    while(i <= cnt_owner_decarbon){
      if($(`#owner_decarbon_${i}`)[0]){
        params.append(`owner_decarbon_${i}`, $(`#owner_decarbon_${i}`).val());
        params.append(`op_owner_decarbon_${i}`, $(`#op_owner_decarbon_${i}`).val());
      };
      i++;
    };
    params.append(`cnt_owner_decarbon`, cnt_owner_decarbon);

    axios.post('vessel_search_process.php',params).then(function (response) {
        console.log(typeof response.data);
        if(response.data){
          document.querySelector("#table_vessel").innerHTML=response.data;
        }
    }).catch(function (error) {
        console.log(error);
    }).then(function () {
        console.log("Result Found");
    });
  });

</script>
</html>
