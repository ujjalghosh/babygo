<?php
include('common_connect.php'); 
// json response array
$response = array("status" => FALSE);
 
if (isset($_POST['customer_email']) && isset($_POST['customer_password'])) {
 
    // receiving the post params
    $customer_email    = $_POST['customer_email'];
    $customer_password = $_POST['customer_password'];
   
    // get the user by email and password
   // $customer_array = $customer->customer_display($db->tbl_pre . "customer_tbl", array(), "WHERE customer_email=" . $customer_email . "");
    $customer_array = $customer->customer_display($db->tbl_pre . "customer_tbl", array(), "WHERE   customer_email='".$customer_email."'");
 
    if (count($customer_array)==1 ){
        // use is found
        if($customer_array[0]["customer_status"]=='Active'){
            if ($customer_password == decode($customer_array[0]['customer_password'])) {
        $response["status"] = FALSE;
        $response["msg"] = "You are successfully login to your account";
        $response["customer_id"]                    = $customer_array[0]["customer_id"];
        $response["user"]["customer_name"]          = $customer_array[0]["customer_name"];
        $response["user"]["customer_email"]         = $customer_array[0]["customer_email"];
        $response["user"]["customer_phone_number"]  = $customer_array[0]["customer_phone_number"];
        $response["user"]["Company_name"]           = $customer_array[0]["Company_name"];
        $response["user"]["customer_address"]       = $customer_array[0]["customer_address"];
        $response["user"]["customer_creation_date"] = $customer_array[0]["customer_creation_date"];
        $response["user"]["customer_category"]        = $customer_array[0]["customer_category"];
        echo json_encode($response);
            }
            else{
             $response["status"] = TRUE;
            $response["msg"] = "Incorrect Password !";
            echo json_encode($response);
        }
        }
        else{
             $response["status"] = TRUE;
            $response["msg"] = "Account is not activated..Contact to site admin !";
            echo json_encode($response);
        }
    } else {
        // user is not found with the credentials
        $response["status"] = TRUE;
        $response["msg"] = "Login credentials are wrong. Please try again with correct email!";
        echo json_encode($response);
    }
} else {
    // required post params is missing
    $response["status"] = TRUE;
    $response["msg"] = "Required parameters email or password is missing!";
    echo json_encode($response);
}
?>