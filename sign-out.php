<?php
 include "includes/settings.php";
include "includes/class_call_one_file.php";
unset($_SESSION['customer_id']);
unset($_SESSION['customer_name']);
 $_SESSION['customer_id']='';
 $_SESSION['customer_name']='';
 header('location: '.Site_URL.'');
?>