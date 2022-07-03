<?php
//session start
session_start();

//POST
$lid = $_POST["lid"];
$lpw = $_POST["lpw"];

//access to DB
include("funcs.php");
$pdo = db_conn();

//create SQL
$stmt = $pdo->prepare("SELECT * FROM gs_user_table WHERE lid=:lid"); 
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
$status = $stmt->execute();

//STOP if error
if($status==false){
    sql_error($stmt);
}

//4. 抽出データ数を取得
$val = $stmt->fetch();         //1レコードだけ取得する方法
//$count = $stmt->fetchColumn(); //SELECT COUNT(*)で使用可能()


//5.該当１レコードがあればSESSIONに値を代入
//入力したPasswordと暗号化されたPasswordを比較！[戻り値：true,false]
$pw = password_verify($lpw, $val["lpw"]);
if($pw){ 
  //Login成功時
  $_SESSION["chk_ssid"]  = session_id();
  $_SESSION["kanri_flg"] = $val['kanri_flg'];
  $_SESSION["name"]      = $val['name'];
  //login success
  redirect("select.php");
}else{
  //login failure
  redirect("login.php");
}

exit();


