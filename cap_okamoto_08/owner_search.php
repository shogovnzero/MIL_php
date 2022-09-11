<?php
session_start();
include_once("funcs.php");
sschk();
$pdo = db_conn();

$stmt = $pdo->prepare("SELECT * FROM cap_owner INNER JOIN (SELECT count(owner_id) AS owner_vessel, owner_id FROM cap_vessel GROUP BY owner_id HAVING owner_vessel>0) AS xxx ON id=xxx.owner_id");
$status = $stmt->execute();

$view="";
if($status==false) {
  sql_error($stmt);
}else{
  $view .= '<table>';
  $view .= '<tr>';
  $view .= '<th rowspan="2">船主</th>';
  $view .= '<th rowspan="2">所在地</th>';
  $view .= '<th rowspan="2">保有隻数</th>';
  $view .= '<th colspan="4">関心事項</th>';
  $view .= '</tr>';
  $view .= '<tr>';
  $view .= '<th>運航コスト</th>';
  $view .= '<th>船員・<br>安全運航</th>';
  $view .= '<th>船主グループ化</th>';
  $view .= '<th>脱炭素化</th>';
  $view .= '</tr>';  
  while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .= '<tr>';
    $view .= '<td>'.'<a href="owner_page.php?id='.h($r["id"]).'">'.h($r["owner_name"]).'</a>'.'</td>';
    $view .= '<td>'.h($r["p_region"]).h($r["p_locality"]).'</td>';
    $view .= '<td>'.number_format(h($r["owner_vessel"])).'</td>';
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
      <div class="filter">
        <h2>検索条件</h2>
        <table id="owner_search_filter">
          <tr>
            <th id="owner_name" rowspan="2">会社名</th>
            <th id="p_region" rowspan="2">所在地</th>
            <th id="owner_foundation" rowspan="2">創業年</th>
            <th id="owner_capital" rowspan="2">資本金</th>
            <th id="owner_employee" rowspan="2">従業員数</th>
            <th id="owner_vessel" rowspan="2">保有隻数</th>
            <th colspan="4">関心事項</th>
          </tr>
          <tr>
            <th id="owner_cost">運航コスト</th>
            <th id="owner_crew_mng">船員・<br>安全運航</th>
            <th id="owner_group">船主グループ化</th>
            <th id="owner_decarbon">脱炭素化</th>
          </tr>
          <!-- $("#owner_search_filter").append -->
        </table>
        <button id="search">検索</button>
      </div>
      <div class="result">
        <h2>検索結果</h2>
        <div id="table_owner"><?=$view?></div>
      </div>
    </main>
    <footer>
    </footer>
  </div>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
  var filter = "";
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

  $("#owner_name").on("click", function(){
    cnt_owner_name += 1;
    filter = `<tr>`;
    filter += `<td colspan="2">会社名</td>`;
    filter += `<td colspan="3"><input type="text" id="owner_name_${cnt_owner_name}" required></td>`;
    filter += `<td colspan="1"><select id="op_owner_name_${cnt_owner_name}"><option value="含む">含む</option><option value="含まない">含まない</option></select></td>`;
    filter += `<td colspan="3"></td>`;
    filter += `<td colspan="1"><button class="remove">削除</button></td>`;
    filter += `</tr>`;
    $("#owner_search_filter").append(filter);
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
    $("#owner_search_filter").append(filter);
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
    $("#owner_search_filter").append(filter);
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
    $("#owner_search_filter").append(filter);
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
    $("#owner_search_filter").append(filter);
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
    $("#owner_search_filter").append(filter);
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
    $("#owner_search_filter").append(filter);
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
    $("#owner_search_filter").append(filter);
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
    $("#owner_search_filter").append(filter);
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
    $("#owner_search_filter").append(filter);
  });

  $(document).on("click",".remove", function(){
    $(this).parent().parent().remove();
  });

  let i = 0;
  $("#search").on("click", function(){
    const params = new URLSearchParams();
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

    axios.post('owner_search_process.php',params).then(function (response) {
        console.log(typeof response.data);
        if(response.data){
          document.querySelector("#table_owner").innerHTML=response.data;
        }
    }).catch(function (error) {
        console.log(error);
    }).then(function () {
        console.log("Result Found");
    });
  });
</script>
</html>