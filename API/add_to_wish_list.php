<?php
include('common_connect.php'); // json response array
$response = array("status" => TRUE);

if (isset($_POST['add_to_wishlist']))  {
 
//print_r($_POST['add_to_wishlist']);

$aa= json_decode($_POST['add_to_wishlist'], true);

if(!empty($aa)){
 
 
  $product_id         =   $aa["product_id"];
  $customer_id        =   $aa["customer_id"];
  $order_status       =   "Wishlist";
  $orderchk_query = $db->query("select * from " . $db->tbl_pre . "orders_tbl where customer_id='" . $customer_id . "' and order_status='Wishlist' and product_id='".rep($product_id)."' ", PDO::FETCH_BOTH);

$order_num = $db->total($orderchk_query);
    if ($order_num == 0) {


 foreach($aa["order_item"] as $value){ 
        
      $product_details_id =   $value['product_details_id'];
      $set                =   $value['set'];
      $mrp                =   $value['mrp'];
      $piece                =   $value['piece'];
      $amount                =   $value['amount'];

 if (!empty($product_id) && !empty($customer_id) && !empty($product_details_id)  && !empty($mrp)&& !empty($piece) && !empty($amount) ) {
  $product = array();
$name_value = array('product_id' => rep($product_id), 'customer_id' => rep($customer_id), 'product_details_id' => rep($product_details_id), 'total_set' =>  $set, 'mrp' => rep($mrp), 'piece'=>rep($piece),'amount'=>rep($amount), 'order_status'=>rep($order_status));


  $order_add = $db->insert('orders_tbl', $name_value);
 
            }   
        } 
} else {
   $response["status"] = FALSE;
        $response["msg"] = "Product already exist in your Wishlist.";
}
       
$orderchk_query = $db->query("select distinct product_id from " . $db->tbl_pre . "orders_tbl where customer_id='" . $customer_id . "' and order_status='Wishlist' order by  `trans_id` DESC ", PDO::FETCH_BOTH);

$order_num = $db->total($orderchk_query);
    if ($order_num != 0) {
      $orderchk_array = $db->result($orderchk_query);
            if (count($orderchk_array)>0) {
$response["product"]["list"]= array();
$response["product"]["details"]=array();

  $customer_array = $customer->customer_display($db->tbl_pre . "customer_tbl ct, " . $db->tbl_pre . "customer_category_tbl cct", array(), "WHERE  ct.customer_id='".$customer_id."' and cct.category_id=ct.customer_category ");
  $response["discount_percent"]= $customer_array[0]["discount_persent"];

      for($k=0;$k<count($orderchk_array);$k++) {

$product_list= $Product->product_display($db->tbl_pre . "product_tbl", array(), "WHERE product_id ='".$orderchk_array[$k]["product_id"]."'  " );


        for ($i=0; $i <count($product_list) ; $i++) { 
        $product = array();
        
        $product["product_id"] = $product_list[$i]["product_id"];
        $product["product_name"] = $product_list[$i]["product_name"];
        $product["style_no"] = $product_list[$i]["style_no"];
         
        $product["style_list_image"] = SITE_URL.'images/product_list/'.$product_list[$i]["style_list_image"];
        
        // push single product into final response array
        array_push($response["product"]["list"], $product);

    }

}
for($k=0;$k<count($orderchk_array);$k++) {
$order_query = $db->query("select * from " . $db->tbl_pre . "orders_tbl where customer_id='" . $customer_id . "' and order_status='Wishlist' and product_id='".$orderchk_array[$k]["product_id"]."' ", PDO::FETCH_BOTH);
 $order_array = $db->result($order_query);
              for($d=0;$d<count($order_array);$d++) {
               $details = array();
 $pddetails=$Product->product_display($db->tbl_pre . "product_details_tbl pdt, " . $db->tbl_pre . "product_size_tbl sz ", array(), "WHERE pdt.product_id ='".$order_array[$d]["product_id"]."' and pdt.product_details_id='".$order_array[$d]["product_details_id"]."' and sz.product_size_id=pdt.size_id " );

  
                $details["style_set_qty"] = $pddetails[0]["style_set_qty"];
                $details["style_mrp_for_size"] = $pddetails[0]["style_mrp_for_size"];
                $details["stock_in_hand"] = $pddetails[0]["stock_in_hand"];
                $details["size_id"] = $pddetails[0]["size_id"];
                $details["size_description"] = $pddetails[0]["size_description"];

                $details["product_id"]              =   $order_array[$d]["product_id"];
                $details["customer_id"]             =   $order_array[$d]["customer_id"];
                $details["product_details_id"]      =   $order_array[$d]["product_details_id"];
                $details["set"]                   =   $order_array[$d]["total_set"];
                $details["piece"]                   =   $order_array[$d]["piece"];
                $details["mrp"]                   =   $order_array[$d]["mrp"];
                $details["amount"]                   =   $order_array[$d]["amount"];

                array_push($response["product"]["details"], $details);
          }
}
}



              




          }


      } 
       else{
        $response["status"] = false;
        $response["msg"] = "Product details empty..";
        echo json_encode($response);
            }
 echo json_encode($response);
  }
    else {
            $response["status"] = false;
        $response["msg"] = "Required field is missing";
        echo json_encode($response);
    }

?>
