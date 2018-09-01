<?php
include('common_connect.php');
// json response array
$response = array("status" => FALSE);



 if (isset($_POST['customer_id']) && isset($_POST['customer_name']) && isset($_POST['customer_phone_number']) && isset($_POST['Company_name'])&& isset($_POST['billing_address'])&& isset($_POST['shipping_address'])&& isset($_POST['vat_no'])&& isset($_POST['cst_no'])&& isset($_POST['pan_no'])) {
 // receiving the post params
 $customer_id =$_POST['customer_id'];
    $customer_name = $_REQUEST['customer_name'];
 
    $customer_phone_number = $_REQUEST['customer_phone_number'];
 
    $Company_name = $_REQUEST['Company_name'];
    $customer_address=$_REQUEST['billing_address'];
        $shipping_address = $_REQUEST['shipping_address'];
    $vat_no = $_REQUEST['vat_no'];
    $cst_no = $_REQUEST['cst_no'];
    $pan_no=$_REQUEST['pan_no'];


    $name_value = array('customer_name' => rep($customer_name), 'customer_phone_number' => rep($customer_phone_number), 'shipping_address' => rep($shipping_address), 'Company_name' => $Company_name, 'Company_name' => rep($Company_name), 'customer_address'=>rep($customer_address),'vat_no'=>rep($vat_no),'cst_no'=>rep($cst_no),'pan_no'=>rep($pan_no));
        // check if user is already existed
$user = $customer->customer_profile_update($name_value,$customer_id, "your profile Update successfully. ", "Sorry, nothing is added.", "Sorry, email id is already added. Please use another email id.");

 
 echo json_encode($user);
	} 
    elseif (isset($_POST['customer_id'])){
$customer_id=$_POST['customer_id'];
  $customer_array = $customer->customer_display($db->tbl_pre . "customer_tbl", array(), "WHERE customer_id=" . $customer_id . "");


                $response["status"]               = TRUE;
                $response["msg"] = "Your Pofile Information";
                $response["customer_id"]                    = $customer_array[0]["customer_id"];
                $response["user"]["customer_name"]          = $customer_array[0]["customer_name"];
                $response["user"]["customer_email"]         = $customer_array[0]["customer_email"];
                $response["user"]["customer_phone_number"]  = $customer_array[0]["customer_phone_number"];
                $response["user"]["Company_name"]           = $customer_array[0]["Company_name"];
                $response["user"]["billing_address"]        = strip_tags($customer_array[0]["customer_address"]);
                $response["user"]["shipping_address"]       = strip_tags($customer_array[0]["shipping_address"]);
                $response["user"]["vat_no"]                 = $customer_array[0]["vat_no"];
                $response["user"]["cst_no"]                 = $customer_array[0]["cst_no"];
                $response["user"]["pan_no"]                 = $customer_array[0]["pan_no"];

 echo json_encode($response);

}
 else {
    $response["status"] = FALSE;
    $response["msg"] = "Required parameters is missing!";
    echo json_encode($response);
}

?>
