<?php
session_start();
include("funcs.php");
sschk();
$pdo = db_conn();

$stmt   = $pdo->prepare("SELECT * FROM cap_owner");
$status = $stmt->execute();

$view="";
if($status==false) {
  sql_error($stmt);
}else{
  $view .= '<table>';
  $view .= '<tr>';
  $view .= '<th rowspan="2">船主</th>';
  $view .= '<th rowspan="2">所在地</th>';
  $view .= '<th rowspan="2">資本金 (百万円)</th>';
  $view .= '<th rowspan="2">従業員数 (人)</th>';
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
    $view .= '<td>'.number_format(h($r["owner_capital"])/1000000).'</td>';
    $view .= '<td>'.number_format(h($r["owner_employee"])).'</td>';
    $stmt2 = $pdo->prepare("SELECT COUNT(*) as cnt_number FROM cap_vessel WHERE owner_id=?");
    $stmt2->execute(array($r["id"]));
    $record = $stmt2->fetch();
    $view .= '<td>'.number_format(h($record["cnt_number"])).'</td>';
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
        <!-- $(table).append -->
      </table>
      <h2>検索結果</h2>
      <div id="table_owner"><?=$view?></div>
    </main>
    <footer>
    </footer>
  </div>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
  $("#search").on("click", function(){
    const params = new URLSearchParams();
    params.append("keyword", $("#keyword").val());
    axios.post('owner_search_process.php',params).then(function (response) {
        console.log(typeof response.data);
        if(response.data){
          document.querySelector("#table_owner").innerHTML=response.data;
        }
    }).catch(function (error) {
        console.log(error);
    }).then(function () {
        console.log("Last");
    });
  });

  var filter_num = 0;

  $("#owner_name").on("click", function(){
    filter_num += 1;
    var filter = `<tr>`;
    filter += `<td colspan="2">船主名</td>`;
    filter += `<td colspan="2"><input type="text" name="owner_name_${filter_num}" required></td>`;
    filter += `<td colspan="4"><select><option value="含む">含む</option><option value="含まない">含まない</option></select></td>`;
    filter += `<td colspan="2"><button>削除</button></td>`;
    filter += `</tr>`;
    $("#owner_search_filter").append(filter);
  });

  $("#p_region").on("click", function(){
    filter_num += 1;
    var filter = `<tr>`;
    filter += `<td colspan="2">所在地</td>`;
    filter += `<td colspan="2"><select name="p_region_${filter_num}"><optgroup label="北海道・東北"><option value="北海道">北海道</option><option value="青森県">青森県</option><option value="岩手県">岩手県</option><option value="宮城県">宮城県</option><option value="秋田県">秋田県</option><option value="山形県">山形県</option><option value="福島県">福島県</option><optgroup label="関東"><option value="茨城県">茨城県</option><option value="栃木県">栃木県</option><option value="群馬県">群馬県</option><option value="埼玉県">埼玉県</option><option value="千葉県">千葉県</option><option value="東京都">東京都</option><option value="神奈川県">神奈川県</option><optgroup label="東海道・甲信越"><option value="新潟県">新潟県</option><option value="富山県">富山県</option><option value="石川県">石川県</option><option value="福井県">福井県</option><option value="山梨県">山梨県</option><option value="長野県">長野県</option><option value="岐阜県">岐阜県</option><option value="静岡県">静岡県</option><option value="愛知県">愛知県</option><option value="三重県">三重県</option><optgroup label="関西"><option value="滋賀県">滋賀県</option><option value="京都府">京都府</option><option value="大阪府">大阪府</option><option value="兵庫県">兵庫県</option><option value="奈良県">奈良県</option><option value="和歌山県">和歌山県</option><optgroup label="中国・四国"><option value="鳥取県">鳥取県</option><option value="島根県">島根県</option><option value="岡山県">岡山県</option><option value="広島県">広島県</option><option value="山口県">山口県</option><option value="徳島県">徳島県</option><option value="香川県">香川県</option><option value="愛媛県">愛媛県</option><option value="高知県">高知県</option><optgroup label="九州・沖縄"><option value="福岡県">福岡県</option><option value="佐賀県">佐賀県</option><option value="長崎県">長崎県</option><option value="熊本県">熊本県</option><option value="大分県">大分県</option><option value="宮崎県">宮崎県</option><option value="鹿児島県">鹿児島県</option><option value="沖縄県">沖縄県</option></select></td>`;
    filter += `<td colspan="4"><select><option value="含む">含む</option><option value="含まない">含まない</option></select></td>`;
    filter += `<td colspan="2"><button>削除</button></td>`;
    filter += `</tr>`;
    $("#owner_search_filter").append(filter);
  });

  $("#owner_foundation").on("click", function(){
    filter_num += 1;
    var filter = `<tr>`;
    filter += `<td colspan="2">創業年</td>`;
    filter += `<td colspan="2"><input type="number" min="1800" max="2022" name="owner_foundation_${filter_num}" placeholder="年" required></td>`;
    filter += `<td colspan="4"><select><option value="以前">以前</option><option value="一致">一致</option><option value="以降">以降</option></select></td>`;
    filter += `<td colspan="2"><button>削除</button></td>`;
    filter += `</tr>`;
    $("#owner_search_filter").append(filter);
  });

  $(document).on("click","button", function(){
    $(this).parent().parent().remove();
  });
</script>
</html>