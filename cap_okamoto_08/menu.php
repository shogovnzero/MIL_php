<?php
$id = $_SESSION["id"];
$pdo = db_conn();

$stmt   = $pdo->prepare("SELECT * FROM cap_vessel WHERE owner_id = $id");
$status = $stmt->execute();

$vessel="";
if($status==false) {
  sql_error($stmt);
}else{
  while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){
    $vessel .= '<a href="vessel_mine.php?id='.$r["id"].'">'.$r["vessel_name_jp"]."</a>";
  }
}
?>

<div class = "area_logo_header">
    <h1>CAP</h1>
</div>
<nav class = "area_nav_header">
    <div class="area_tab"><a href="owner_search.php">船主検索</a></div>
    <div class="area_tab"><a href="vessel_search.php">船舶検索</a></div>
    <div class="area_tab"><a href="chat.php">チャット</a></div>
    <div class="area_tab">
        <a>自社船舶</a>
        <div class="area_item">
          <?=$vessel?>
          <a href="vessel_register.php">船舶新規登録</a>
        </div>
    </div>
    <div class="area_tab">
        <a>My Info</a>
        <div class="area_item">
          <a href="index.php">自社ページ</a>
          <a href="mypage_update.php">自社ページ更新</a>
          <a href="logout.php">ログアウト</a>
        </div>
    </div>
</nav>
