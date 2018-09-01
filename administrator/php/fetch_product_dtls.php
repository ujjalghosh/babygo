<?php 
include "../../includes/settings.php";
include "../../includes/class_call_one_file.php";
//if(isset($_POST['file'])){

 
$product_id=$_REQUEST['product_id'];

 

$product_sql = $db->query("SELECT * FROM `".$db->tbl_pre."product_tbl` WHERE `product_id`='".$product_id."'", PDO::FETCH_BOTH);
  $product_total= $db->total($product_sql); 
if($product_total==1){
$product_array = $db->result($product_sql); 
$response['status'] =true;
$response['mrp'] =  $product_array[0]['style_mrp_for_size'] ; 
}else{
$response['status'] =flse;
$response['msg'] ='no result found';
}

echo json_encode($response);

//}
?>