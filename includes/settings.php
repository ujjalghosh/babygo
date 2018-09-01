<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
ob_start();
include "functions.php";
include "functions_ext.php";
include "formatting.php";
include "classes/form.class.php";
include "classes/class.phpmailer.php";
include "classes/PaginationClass.php";
include "classes/class.query.extended.php";
 
include "classes/franchise_class.php"; 
include "classes/product_class.php";
include "classes/product_size_class.php";
include "classes/product_color_class.php";
include "classes/product_group_class.php";
include "classes/customer_category_class.php";
include "classes/product_details_class.php";
include "classes/product_image_class.php";
include "classes/order_class.php";
include "classes/notification_class.php";
include "classes/order_template_class.php";
include "classes/purchase_class.php";


include "classes/customer_class.php";
include "classes/product_type_style_class.php";
include "classes/product_category_class.php";
include "database_initial.php";

$db = new DB();
$db->connect($config);
$qryArray = array('tbl_name' => $db->tbl_pre . 'site_configuration_tbl', 'method' => PDO::FETCH_ASSOC);
$config = $db->select($qryArray);
$config_array = $db->result($config);
for ($row = 0; $row <= count($config_array); $row++) {
	define("" . str_replace(" ", "_", $config_array[$row]['site_configuration_name']) . "", $config_array[$row]['site_configuration_value']);
}

$site_url = Site_URL;
//$site_url="http://alpenwild.com/DraftNewSite/";
define("SITE_URL", $site_url);
define("COOKIE_EXPIRE", 60 * 60 * 24 * 100);
date_default_timezone_set(Current_Timezone);
define("SITE_DIRECTORY", $_SERVER['DOCUMENT_ROOT'] . '/EmailSystem/');
//echo SITE_DIRECTORY;
define("UPLOADS_DIRECTORY", SITE_DIRECTORY . 'uploads/');
define("UPLOADS_URL", SITE_URL . 'uploads/');
//100 days by default
//define("COOKIE_PATH", Site_Path);
//Avaible in whole domain
//writeht();
?>