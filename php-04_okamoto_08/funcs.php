<?php

function h($str){
    return htmlspecialchars($str, ENT_QUOTES);
}

//DB connection
function db_conn(){
    try {
        //localhost
        $db_name = "mil_bookmark";
        $db_id   = "root";
        $db_pw   = "";
        $db_host = "localhost";

        //localhost以外
        if($_SERVER["HTTP_HOST"] != 'localhost'){
            $db_name = "***";
            $db_id   = "***";
            $db_pw   = "***";
            $db_host = "s***";
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

//SessionCheck(スケルトン)
function sschk(){
    if($_SESSION["chk_ssid"] != session_id()){
        exit("Login Error");
    }else{
        session_regenerate_id(true);
        $_SESSION["chk_ssid"] = session_id();
    }
}

?>
