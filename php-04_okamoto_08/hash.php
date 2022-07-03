<?php
$pw = password_hash("test4", PASSWORD_DEFAULT);
echo $pw;
// var_dump(password_verify("test1", $pw));
?>