<?php
session_start();
$id = $_SESSION["id"];
include("funcs.php");
sschk();
$pdo = db_conn();




?>