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

//SQLエラー関数
function sql_error($stmt){
    $error = $stmt->errorInfo();
    exit('SQLError:'.$error[2]);
}

//リダイレクト関数:
function redirect($file_name){
    header("Location: ".$file_name);
    exit();
}

// Session Check
function sschk(){
    if($_SESSION["chk_ssid"] != session_id()){
        exit("Login Error");
    }else{
        session_regenerate_id(true);
        $_SESSION["chk_ssid"] = session_id();
    }
}

// ファイルアップロード
function fileUpload($fname,$path){
    if (isset($_FILES[$fname]) && $_FILES[$fname]["error"] ==0 ) {
        $file_name = $_FILES[$fname]["name"];
        //一時保存場所取得
        $tmp_path  = $_FILES[$fname]["tmp_name"];
        $extension = pathinfo($file_name, PATHINFO_EXTENSION);
        $file_name = uniqid(mt_rand(), true).".".$extension;
        $file_dir_path = $path."/".$file_name;
        if ( is_uploaded_file( $tmp_path ) ) {
            if ( move_uploaded_file( $tmp_path, $file_dir_path ) ) {
                chmod( $file_dir_path, 0644 );
                return $file_name;
            } else {
                return 1; //失敗時：ファイル移動に失敗
            }
        }
    } else {
        return 2; //失敗時：ファイル取得エラー
    }
};