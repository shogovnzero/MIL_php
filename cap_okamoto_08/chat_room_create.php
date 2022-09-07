<?php
include_once("funcs.php");

$id = $_POST["id"];

$room_name = "";
$room_name .= '<input type="text" placeholder="参加メンバー名を入力">';
echo $room_name;
?>