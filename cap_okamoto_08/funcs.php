<?php
//XSS対応（ echoする場所以外での使用NG ）
function h($str){
    return htmlspecialchars($str, ENT_QUOTES);
}

//DB接続
function db_conn(){
    try {
        $db_name = "cap_db";
        $db_id   = "root";
        $db_pw   = "";
        $db_host = "localhost";

        if($_SERVER["HTTP_HOST"] != 'localhost'){
            $db_name = "shogovnzero_cap_db";  //データベース名
            $db_id   = "shogovnzero";  //アカウント名（さくらコントロールパネルに表示されています）
            $db_pw   = "Vienna1180";  //パスワード(さくらサーバー最初にDB作成する際に設定したパスワード)
            $db_host = "mysql57.shogovnzero.sakura.ne.jp"; //例）mysql**db.ne.jp...
        }
        return new PDO('mysql:dbname='.$db_name.';charset=utf8;host='.$db_host, $db_id, $db_pw);
    } catch (PDOException $e) {
        exit('DB Connection Error:'.$e->getMessage());
    }
}

//SQLエラー関数：sql_error($stmt)
function sql_error($stmt){
    $error = $stmt->errorInfo();
    exit('SQLError:'.$error[2]);
}

//リダイレクト関数: redirect($file_name)
function redirect($file_name){
    header("Location: ".$file_name);
    exit();
}

// Session Check (スケルトン)
function sschk(){
    if($_SESSION["chk_ssid"] != session_id()){
        exit("Login Error");
    }else{
        session_regenerate_id(true);
        $_SESSION["chk_ssid"] = session_id();
    }
}