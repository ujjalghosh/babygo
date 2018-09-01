<?php
include('common_connect.php'); // json response array
$response = array("status" => TRUE);

  
if (isset($_POST['order_no']))  {
  $generate_no =$_POST['order_no'];
$orderchk_query = $db->query("select distinct product_id from " . $db->tbl_pre . "orders_tbl where generate_no ='" . $generate_no  . "' ", PDO::FETCH_BOTH);

$order_num = $db->total($orderchk_query);
    if ($order_num != 0) {
      $orderchk_array = $db->result($orderchk_query);
            if (count($orderchk_array)>0) {
$response["product"]["list"]= array();
$response["product"]["invoice"]= array();

$order_invoice= $order->order_display($db->tbl_pre . "invoice_tbl", array(), "WHERE generate_no ='" . $generate_no  . "' " );
             if(count($order_invoice)>0){
             for($oi=0;$oi<count($order_invoice);$oi++) {
               $invoice = array();
          $date=date_create($order_invoice[$oi]["invoice_date"]);
               $invoice["invoice_date"] = date_format($date,"d.m.Y");
                $invoice["invoice_number"] = $order_invoice[$oi]["invoice_number"];
                $invoice["shipped_through"] = $order_invoice[$oi]["shipped_through"];
                $invoice["consignment_number"] = $order_invoice[$oi]["consignment_number"];
               
                array_push($response["product"]["invoice"], $invoice);
          }
 
}


$order_dtls= $order->order_display($db->tbl_pre . "order_master", array(), "WHERE generate_no ='" . $generate_no  . "' " );
 $response["product"]["total_amount"]=$order_dtls[0]["total_bill_amount"];
 $response["product"]["billing_address"]=$order_dtls[0]["billing_address"];
 $response["product"]["shipping_address"]=$order_dtls[0]["shipping_address"];
 
      for($k=0;$k<count($orderchk_array);$k++) {

$product_list= $Product->product_display($db->tbl_pre . "product_tbl", array(), "WHERE product_id ='".$orderchk_array[$k]["product_id"]."'  " );


        for ($i=0; $i <count($product_list) ; $i++) { 
        $product = array();
        
        $product["product_id"] = $product_list[$i]["product_id"];
        $product["product_name"] = $product_list[$i]["product_name"];
        $product["style_no"] = $product_list[$i]["style_no"];
         
        $product["style_list_image"] = SITE_URL.'images/product_list/'.$product_list[$i]["style_list_image"];
        
 
            $resdetails["product"]["details"]=array();
$order_query = $db->query("select * from " . $db->tbl_pre . "orders_tbl where generate_no ='" . $generate_no  . "' and product_id='".$product_list[$i]["product_id"]."'   ", PDO::FETCH_BOTH);
 $order_array = $db->result($order_query);
              for($d=0;$d<count($order_array);$d++) {
               $details = array();
 $pddetails=$Product->product_display($db->tbl_pre . "product_details_tbl pdt, " . $db->tbl_pre . "product_size_tbl sz ", array(), "WHERE pdt.product_id ='".$order_array[$d]["product_id"]."' and pdt.product_details_id='".$order_array[$d]["product_details_id"]."' and sz.product_size_id=pdt.size_id " );

  
               $details["style_set_qty"] = $pddetails[0]["style_set_qty"];
                $details["style_mrp_for_size"] = $pddetails[0]["style_mrp_for_size"];
                $details["stock_in_hand"] = $pddetails[0]["stock_in_hand"];
                $details["size_id"] = $pddetails[0]["size_id"];
                $details["size_description"] = $pddetails[0]["size_description"];

                $details["product_id"]                  =   $order_array[$d]["product_id"];
                $details["generate_no "]                =   $order_array[$d]["generate_no "];
                $details["product_details_id"]          =   $order_array[$d]["product_details_id"];
                $details["set"]                         =   $order_array[$d]["total_set"];
                $details["piece"]                       =   $order_array[$d]["piece"];
                $details["mrp"]                         =   $order_array[$d]["mrp"];
                $details["amount"]                      =   $order_array[$d]["amount"];
                array_push($resdetails["product"]["details"], $details);
          }
 

        $product["details"]=$resdetails["product"]["details"];
        
        // push single product into final response array
        array_push($response["product"]["list"], $product);

    }

}

}



              


$response["status"] = TRUE;
        $response["msg"] = "Order  details list..";
        echo json_encode($response);

          }


else{
         
        $response["status"] = FALSE;
        $response["msg"] = "No product found.";
        echo json_encode($response);
             }
 }
   
    else {
            $response["status"] = FALSE;
        $response["msg"] = "Order no required.";
        echo json_encode($response);
    }

?>
