<?php
include('includes/session.php');
session_destroy();
session_start();
$_SESSION['admin_msg']=messagedisplay("You have successfully logout.",1);
header('Location: login.php');
?>