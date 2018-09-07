<?php
include('common_connect.php');
// json response array
$response = array("status" => FALSE);
if (isset($_POST['customer_name']) && isset($_POST['customer_email']) && isset($_POST['customer_password'])) {
 // receiving the post params
 
    $customer_name = $_REQUEST['customer_name'];
    $customer_email = $_REQUEST['customer_email'];
    $customer_phone_number = $_REQUEST['customer_phone_number'];
    $customer_password = $_REQUEST['customer_password'];
    $Company_name = $_REQUEST['Company_name'];
    $customer_address=$_REQUEST['customer_address'];

    $customer_telephone=$_REQUEST['customer_telephone'];
    $customer_city=$_REQUEST['customer_city'];
    $customer_state=$_REQUEST['customer_state'];
    $customer_pin=$_REQUEST['customer_pin'];
    $shipping_address=$_REQUEST['shipping_address'];
    $shipping_city=$_REQUEST['shipping_city'];
    $shipping_state=$_REQUEST['shipping_state'];
    $shipping_pin=$_REQUEST['shipping_pin'];
    $gst_no=$_REQUEST['gst_no'];
    $pan_no=$_REQUEST['pan_no'];

    $name_value = array('customer_name' => rep($customer_name), 'customer_email' => rep($customer_email), 'customer_phone_number' => rep($customer_phone_number), 'customer_password' => encode($customer_password), 'Company_name' => rep($Company_name), 'customer_address'=>rep($customer_address), 'customer_telephone'=>rep($customer_telephone), 'customer_city'=>rep($customer_city), 'customer_state'=>rep($customer_state), 'customer_pin'=>rep($customer_pin), 'shipping_address'=>rep($shipping_address), 'shipping_city'=>rep($shipping_city), 'shipping_state'=>rep($shipping_state), 'shipping_pin'=>rep($shipping_pin), 'gst_no'=>rep($gst_no), 'pan_no'=>rep($pan_no));
        // check if user is already existed
$user = $customer->customer_register($name_value, "You are successfully registered with us, Your account will be activated after verification .", "Sorry, nothing is added.", "Sorry, email id is already registered. Please use another email id.");
 
 echo json_encode($user);
	} else {
    $response["status"] = TRUE;
    $response["msg"] = "Required parameters (name, email or password) is missing!";
    echo json_encode($response);
}

?>
