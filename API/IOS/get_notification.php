<?php
include('common_connect.php'); 
// json response array
$response = array("status" => TRUE);
 
 

 
if(isset($_REQUEST['customer_id'])) {
 
$customer_id=$_POST['customer_id'];
if ($customer_id>0) {
$notification_array = $notification->notification_display($db->tbl_pre . "notification_tbl", array(), "WHERE customer_id IN(" . $customer_id . ",0) and notification_status='Active' ");
}else{
  $notification_array = $notification->notification_display($db->tbl_pre . "notification_tbl", array(), "WHERE customer_id=" . $customer_id . "");
}
  if (count($notification_array)>0) {
      

       $response["notification"]  = array();

        for ($i=0; $i <count($notification_array) ; $i++) { 
        $notification = array();
        $notification["notfication_title"] = $notification_array[$i]["notfication_title"];
        $notification["notification_message"] = $notification_array[$i]["notification_message"];
        if(!empty($notification_array[$i]["notfication_image"])){
        $notification["notfication_image"] = SITE_URL.'images/notification/'. $notification_array[$i]["notfication_image"];
         }else{
          $notification["notfication_image"] = "";
         }
        // push single product into final response array
        array_push($response["notification"], $notification);
    }
 $response["status"] = FALSE;
    $response["msg"] = "Notification list";
 
echo json_encode($response);
  }
else{ 
 
 $response["status"] = TRUE;
    $response["msg"] = "No notification available";
 
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