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

    $name_value = array('customer_name' => rep($customer_name), 'customer_email' => rep($customer_email), 'customer_phone_number' => rep($customer_phone_number), 'customer_password' => encode($customer_password), 'Company_name' => rep($Company_name), 'customer_address'=>rep($customer_address));
        // check if user is already existed
$user = $customer->customer_register($name_value, "customer added successfully. Please enter another.", "Sorry, nothing is added.", "Sorry, email id is already added. Please use another email id.");
 
 echo json_encode($user);
	} else {
    $response["status"] = TRUE;
    $response["msg"] = "Required parameters (name, email or password) is missing!";
    echo json_encode($response);
}

?>
