<?php
include('common_connect.php');
// json response array
$response = array("error" => FALSE);
if (isset($_POST['customer_id']) && isset($_POST['new_customer_password']) ) {
 // receiving the post params
 
    $customer_id = $_REQUEST['customer_id'];
    $customer_password = $_REQUEST['new_customer_password'];


    $name_value = array( 'customer_password' => encode($customer_password) );
        // check if user is already existed
$user = $customer->password_change($name_value, $customer_id, "Password successfully updated. Please use new password to login. ", "Sorry, nothing is added.", "Sorry, email id is already added. Please use another email id.");
 
 echo json_encode($user);
	} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (customer_id or  password) is missing!";
    echo json_encode($response);
}

?>
