<?php
session_start();
$response = array("status" => TRUE);
 $total_cart=$_REQUEST['total_cart'];
 $customer_id=$_SESSION['customer_id'];
 $response["cart_details"] = array();

for ($to=0; $to <$total_cart ; $to++) { 
    $product = array();
     $response1["quantity"] = array();
    $product["product_id"]  = $_REQUEST['product_id_'.$to];
    $product["customer_id"] = $customer_id;

    for ($i=0; $i <$_REQUEST['product_item_'.$product["product_id"]] ; $i++) { 
        $product_item = array();
        $product_item["product_details_id"]  =      $_REQUEST[$product["product_id"].'_product_details_id_'.$i];
        $product_item["set"]                 =      $_REQUEST[$product["product_id"].'_set_'.$i];
        $product_item["piece"]               =      $_REQUEST[$product["product_id"].'_piece_'.$i];
        $product_item["mrp"]                 =      $_REQUEST[$product["product_id"].'_mrp_'.$i];
        $product_item["amount"]              =      $_REQUEST[$product["product_id"].'_amount_'.$i];

    array_push($response1["quantity"], $product_item);
    }
    $product["product_quantity"] =$response1["quantity"];
    array_push($response["cart_details"], $product);
}

$response["total_bill_amount"]          = $_REQUEST['total_bill_amount'];
$response["billing_address"]            = $_REQUEST['billing_address'];
$response["shipping_address"]           = $_REQUEST['shipping_address'];


$response["remarks"]  = $_REQUEST['remarks'];
$response["discount_percent"]  = $_REQUEST['discount_percent'];
$response["billing_city"]  = $_REQUEST['billing_city'];
$response["billing_state"]  = $_REQUEST['billing_state'];
$response["billing_pin"]  = $_REQUEST['billing_pin'];
$response["shipping_city"]  = $_REQUEST['shipping_city'];
$response["shipping_state"]  = $_REQUEST['shipping_state'];
$response["shipping_pin"]  = $_REQUEST['shipping_pin']; 

$cart_details=count($response["cart_details"]);

if ( $cart_details>0) {
/*    if ($response["preferred_courier_service"]=='') {
     $response["status"] = FALSE;
    $response["msg"] = "Please enter your Order instructions.";  
   echo json_encode($response);
    } else {
        $response["status"] = TRUE;
        echo json_encode($response);
    }*/
        $response["status"] = TRUE;
        echo json_encode($response);
}
else{
   $response["status"] = FALSE;
   $response["msg"] = "Please add product size for place order";
   echo json_encode($response);

}



 