<?php
include('common_connect.php'); 
// json response array
$response = array("status" => TRUE);
 
 

 
if(isset($_REQUEST['customer_id'])) {
 
$customer_id=$_POST['customer_id'];
 
  $order_list_array = $order->order_display($db->tbl_pre . "order_master", array(), "WHERE customer_id=" . $customer_id . "");
 
  if (count($order_list_array)>0) {
      

       $response["order_list"]  = array();

        for ($i=0; $i <count($order_list_array) ; $i++) { 
        $order_list = array();
        $order_list["order_no"] = $order_list_array[$i]["generate_no"];
        $date=date_create($order_list_array[$i]["order_Date"]);
 
        $order_list["order_date"] = date_format($date,"d.m.Y");
        $order_list["order_amount"] = $order_list_array[$i]["total_bill_amount"];
        $order_list["order_status"] = $order_list_array[$i]["order_status"];
 
        // push single product into final response array
        array_push($response["order_list"], $order_list);
    }
 $response["status"] = FALSE;
    $response["msg"] = "Order list";
 
echo json_encode($response);
  }
else{ 
 
 $response["status"] = TRUE;
    $response["msg"] = "You have not placed any orders.";
 
echo json_encode($response);
}
    


}
 else {
    // required post params is missing
    $response["status"] = FALSE;
    $response["msg"] = "Required parameters customer id is missing!";
    echo json_encode($response);
}
?>