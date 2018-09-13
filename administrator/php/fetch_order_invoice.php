<?php
include "../../includes/settings.php";
include "../../includes/class_call_one_file.php";


$order_no = $_REQUEST['order_no'];
$invoice_sql = $db->query("SELECT 'hsn' AS hsn,`pt`.`product_name`,`pt`.`style_no`,`pst`.`size_description`,`pt`.`style_color_qty`,`ort`.`total_set`, 0 AS set_delevered,`ort`.`piece`, `ort`.`mrp`,`ortm`.`discount_percent`, ort.product_id, pdt.stock_in_hand FROM babygodb_order_master ortm, babygodb_orders_tbl ort, babygodb_product_details_tbl pdt, babygodb_product_size_tbl pst, babygodb_product_tbl pt WHERE ort.product_id=pt.product_id and ort.product_details_id=pdt.product_details_id and pdt.size_id=pst.product_size_id and ort.product_id=pt.product_id and ort.generate_no='".$order_no."' and ortm.generate_no='".$order_no."' ", PDO::FETCH_BOTH);

  $charge_total= $db->total($invoice_sql); 
if($charge_total>0){
$invoice_row = $db->result($invoice_sql); 
$response["order_row"] = array();
$response['status'] =true;

for ($i = 0; $i <count($invoice_row) ; $i++) {
	$order = array();
	$order["hsn"] 					= $invoice_row[$i]['hsn'];
	$order["product_name"] 			= $invoice_row[$i]['product_name'];
	$order["style_no"] 				= $invoice_row[$i]['style_no'];
	$order["size_description"] 		= $invoice_row[$i]['size_description'];
	$order["style_color_qty"] 		= $invoice_row[$i]['style_color_qty'];
	$order["total_set"] 			= $invoice_row[$i]['total_set'];
	$order["set_delevered"] 		= $invoice_row[$i]['set_delevered'];
	$order["piece"] 				= $invoice_row[$i]['piece'];
	$order["mrp"] 					= $invoice_row[$i]['mrp'];
	$order["discount_percent"] 		= $invoice_row[$i]['discount_percent'];
	$order["product_id"] 			= $invoice_row[$i]['product_id'];
	$order["stock_in_hand"] 		= $invoice_row[$i]['stock_in_hand'];

	array_push($response["order_row"], $order);
}


}else {
	$response['status'] =flse;
$response['msg'] ='no result found';
}             



 echo json_encode($response);
    

   
?>