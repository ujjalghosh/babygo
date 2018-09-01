<?php
include ("mysql.class.php");
$db = new DB1();
$db->connect($database_server, $database_username, $database_password, false, false, $database_name, 'alpenwild_');
?>
