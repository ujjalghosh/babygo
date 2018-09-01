<?php
session_start();
include("../includes/settings.php");
$recperpage = Backend_Pagination;
include ("../includes/class_call_one_file.php");
if(!isset($_SESSION['admin_login']) || $_SESSION['admin_login']!="Success") {
	$_SESSION['admin_msg']=messagedisplay("Please login first to access this page!",2);
	header('location: login.php');
}
?>