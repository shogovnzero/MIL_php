<?php
$arr = ["a", "b", "c"];
$arr[] = "d";
// echo $arr;
echo "<pre>";
var_dump($arr);
echo "</pre>";

$str = "one, two, three";
$result = explode(",",  $str);
echo "<pre>";
var_dump($result);
echo "</pre>";
?>