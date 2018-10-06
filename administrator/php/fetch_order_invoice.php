<?php
include "../../includes/settings.php";
include "../../includes/class_call_one_file.php";


$order_no = $_REQUEST['order_no'];
$invoice_sql = $db->query("SELECT ortm.generate_no AS order_no, pt.hsn AS hsn,`pt`.`product_name`,ort.product_details_id,ort.product_id,`pt`.`style_no`,`pst`.`size_description`,`pt`.`style_color_qty`,`ort`.`total_set`, IFNULL( set_delevered,0) AS set_delevered, (`ort`.`total_set` - IFNULL( set_delevered,0)) AS set_due ,`ort`.`piece`, `ort`.`mrp`,`ortm`.`discount_percent`, pdt.stock_in_hand FROM babygodb_order_master ortm INNER JOIN babygodb_orders_tbl ort ON ortm.generate_no=ort.generate_no LEFT JOIN babygodb_product_details_tbl pdt ON ort.product_details_id=pdt.product_details_id JOIN babygodb_product_size_tbl pst ON pdt.size_id=pst.product_size_id INNER JOIN babygodb_product_tbl pt ON ort.product_id=pt.product_id LEFT OUTER JOIN (SELECT IM.order_no, IFNULL(SUM(IT.set_dispatch),0) AS set_delevered,IT.product_id ,IT.product_details_id FROM babygodb_invoice_master AS IM LEFT JOIN babygodb_invoice_trns AS IT ON IT.invoice_no=IM.invoice_no WHERE IM.order_no='".$order_no."' GROUP BY IT.product_id, IT.product_details_id   ) as b ON b.order_no=ortm.generate_no AND b.product_id=pt.product_id AND b.product_details_id=pdt.product_details_id WHERE ortm.generate_no='".$order_no."' ", PDO::FETCH_BOTH);
 
 



$charge_total= $db->total($invoice_sql); 
if($charge_total>0){
$invoice_row = $db->result($invoice_sql); 
$response["order_row"] = array();
$response['status'] =true;
$response['total_row'] =$charge_total;
$response['order_no'] =$invoice_row[0]['order_no'];


for ($i = 0; $i <count($invoice_row) ; $i++) {
	if($invoice_row[$i]['set_due']>0){
	$order = array();
	$order["hsn"] 					= $invoice_row[$i]['hsn'];
	$order["product_name"] 			= $invoice_row[$i]['product_name'];
	$order["product_details_id"] 	= $invoice_row[$i]['product_details_id'];
	$order["product_id"] 			= $invoice_row[$i]['product_id'];	
	$order["style_no"] 				= $invoice_row[$i]['style_no'];
	$order["size_description"] 		= $invoice_row[$i]['size_description'];
	$order["style_color_qty"] 		= $invoice_row[$i]['style_color_qty'];
	$order["total_set"] 			= $invoice_row[$i]['total_set'];
	$order["set_delevered"] 		= $invoice_row[$i]['set_delevered'];
	$order["set_due"] 				= $invoice_row[$i]['set_due'];	
	$order["piece"] 				= $invoice_row[$i]['piece']/$invoice_row[$i]['total_set'];
	$order["mrp"] 					= $invoice_row[$i]['mrp'];
	$order["discount_percent"] 		= $invoice_row[$i]['discount_percent'];
	$order["stock_in_hand"] 		= $invoice_row[$i]['stock_in_hand'];

	array_push($response["order_row"], $order);
	}
}


}else {
	$response['status'] =flse;
$response['msg'] ='no result found';
}             



 echo json_encode($response);
    

   
?>