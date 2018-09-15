<?php
include "../../includes/settings.php";
include "../../includes/class_call_one_file.php";


//print_r($_REQUEST);

if (isset($_REQUEST['order_no']) && !empty($_REQUEST['order_no']) ) {
 $order_no = $_REQUEST['order_no'];

$name_value=array('order_no'=>$order_no);
$invoice_add=$db->insert('invoice_master', $name_value);

if ($invoice_add['affectedRow'] > 0) {
	$invoice_id = $invoice_add['insertedId'];
	$db->executequery("UPDATE babygodb_invoice_master t2, ( SELECT invoice_id, IF( LENGTH(invoice_id)>7, CONCAT('S-',invoice_id), CONCAT( 'S-', LPAD(`invoice_id`,7,'0') )) AS invoice_no FROM babygodb_invoice_master WHERE invoice_id='".$invoice_id."') t1 SET t2.`invoice_no` = t1.invoice_no WHERE t2.`invoice_id`=t1.invoice_id");

 $invoice_query=$db->query("SELECT `invoice_no` FROM `babygodb_invoice_master` WHERE `invoice_id`='".$invoice_id."'", PDO::FETCH_BOTH);
 $invoice_array = $db->result($invoice_query);
 $invoice_no= $invoice_array[0]['invoice_no']; 

if (isset($_POST['total_row'])) {
  for ($pr = 1; $pr <= $_REQUEST['total_row']; $pr++) {
	if(isset($_REQUEST['product_id_'. $pr]) && !empty($_REQUEST['product_id_'. $pr]) && !empty($_REQUEST['set_dispatch_'. $pr])){

	$product_id = $_REQUEST['product_id_'. $pr];
	$product_details_id = $_REQUEST['product_details_id_'. $pr];
	$hsn = $_REQUEST['hsn_'. $pr];
	$description = $_REQUEST['product_name_'. $pr];
	$style_no = $_REQUEST['style_no_'. $pr];
	$size = $_REQUEST['size_'. $pr];
	$colour = $_REQUEST['colour_'. $pr];
	$set_order = $_REQUEST['set_order_'. $pr];
	$set_dispatch = $_REQUEST['set_dispatch_'. $pr];
	$pcs = $_REQUEST['pcs_'. $pr];
	$mrp = $_REQUEST['mrp_'. $pr];
	$amount_discount = $_REQUEST['amount_discount_'. $pr];
	$net_amount = $_REQUEST['net_amount_'. $pr];
	$grand_amount = $_REQUEST['grand_amount_'. $pr];
	$discount_percent = $_REQUEST['discount_percent_'. $pr];

	$value =array("invoice_id"=>$invoice_id,"invoice_no"=>$invoice_no,"product_id"=>"".rep($product_id)."", "product_details_id"=>"".rep($product_details_id)."","hsn"=>"".rep($hsn)."","description"=>"".rep($description)."","style_no"=>"".rep($style_no)."","size"=>"".rep($size)."","colour"=>"".rep($colour)."","set_ordered"=>"".rep($set_order)."","set_dispatch"=>"".rep($set_dispatch)."","pcs"=>"".rep($pcs)."","mrp"=>"".rep($mrp)."","amount_discount"=>"".rep($amount_discount)."","net_amount"=>"".rep($net_amount)."","grand_amount"=>"".rep($grand_amount)."","discount_percent"=>"".rep($discount_percent)."");
	
	$db->insert('invoice_trns', $value);
 }
	}
}

		$response['status']=true;
		$response['msg']='Invoice is created successfully..';

	}else{
		$response['status']=false;
		$response['msg']='Please try Again ...';
	}
}else{
	$response['status']=false;
	$response['msg']='Please try Again required field missing.';
}
 
            



 echo json_encode($response);
    

   
?>