<?php
include "../../includes/settings.php";
include "../../includes/class_call_one_file.php";

$invoice_id = $_REQUEST['invoice_id'];
//$invoice_sql = $db->query("SELECT im.`invoice_id`, im.`invoice_no`, im.`order_no`, DATE_FORMAT(im.`invoice_date`,'%d-%m-%Y') AS invoice_date FROM `".$db->tbl_pre."invoice_master` im LEFT JOIN ".$db->tbl_pre."invoice_trns it ON it.invoice_no=im.invoice_no  WHERE `order_no` ='".$order_no."' GROUP BY im.`invoice_no`", PDO::FETCH_BOTH);

$invoice_master=$db->delete("invoice_master", array("invoice_id" => $invoice_id));
$invoice_trns=$db->delete("invoice_trns", array("invoice_id" => $invoice_id));
$goods_delete=$db->delete("goods_movement_register", array("reference_id" => $invoice_id,"reference_type"=>"sales"));

if ($goods_delete['affectedRow'] > 0) {
	 goods_movement_summary();
$response['status'] =true;
$response['msg'] ='Invoice deleted successfully.';

} else {
$response['status'] =false;
$response['msg'] ='Invoice not deleted .';
}
 


 echo json_encode($response);
 ?>

