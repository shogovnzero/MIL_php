<?php

session_start();

$sid = session_id();

echo $sid;

$_SESSION["name"] = "岡本";
$_SESSION["age"] = 25;
?>