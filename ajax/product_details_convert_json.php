<?php
session_start();
 $product_id=$_REQUEST['product_id'];
 $customer_id=$_SESSION['customer_id'];
 $item=$_REQUEST['item'];
 
$json = array("status" => TRUE);
        $response["order_item"] = array();
        for ($i=0; $i <$item ; $i++) { 
        if ($_REQUEST['set_'.$i]>0 ) {         
          
        $product = array();
        $product["product_details_id"] = $_REQUEST['product_details_id_'.$i];
        $product["set"] = $_REQUEST['set_'.$i];
        $product["piece"] = $_REQUEST['piece_'.$i];
        $product["mrp"] = $_REQUEST['mrp_'.$i];
        $product["amount"] = $_REQUEST['amount_'.$i];
     
        array_push($response["order_item"], $product);
     }
    }


  $postArray = array(
    "product_id"  => $product_id,
    "customer_id" => $customer_id,
    "order_item" => $response["order_item"]
    ); //you might need to process any other post fields you have..

 $order_itm=count($response["order_item"]);

if ($order_itm>0) {
$json["product"]= $postArray;
echo json_encode($json);
}else{
 $json["status"] = FALSE;
 $json["msg"] ="Please select at least one product size.";
 
echo json_encode($json);

}


?>