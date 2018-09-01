<?php
include('common_connect.php'); 
// json response array
$response = array("status" => TRUE);
 
if (isset($_REQUEST['product_id'])) {
 
    // receiving the post params
    $product_id    = $_REQUEST['product_id'];
    $group_id = $_REQUEST['group_id'];
    $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
    if($page==1){
         $frm=0;
    }
    else{
    $page=$page*10;
    $frm=$page-10;
    }

if( isset($_REQUEST['product_id'])  ){
$product = $Product->product_display($db->tbl_pre . "product_tbl", array(), "WHERE product_id ='".$product_id."'  " );

$response["product_description"]= $product[0]["style_decription"];

$response["product"]["details"]=$Product->product_display($db->tbl_pre . "product_details_tbl", array(), "WHERE product_id ='".$product_id."'  " );

$response["product"]["related"]=$Product->product_display($db->tbl_pre . "product_tbl", array(), "WHERE group_id ='".$product[0]["group_id"]."' and product_status='Active' " );


$response["product"]["images"]=$Product->product_display($db->tbl_pre . "product_images_tb", array(), "WHERE  product_id  ='".$product_id."'  " );



$product_totalnum = $Product->product_display($db->tbl_pre . "product_tbl", array(), "WHERE product_id ='".$product_id."' " );
 




}

    $response["status"] = TRUE;
    $response["msg"] = "This is your product list";

 
echo json_encode($response);
}
 else {
    // required post params is missing
    $response["status"] = FALSE;
    $response["msg"] = "Required parameters category is missing!";
    echo json_encode($response);
}
?>