<?php
include('common_connect.php'); 
// json response array
$response = array("status" => FALSE);
 
 
 
    $response["category"] = $product_category->Product_category_display($db->tbl_pre . "category_tbl", array(), "WHERE   category_status='Active'");
 
    if (count($response["category"])>0 ){
        // use is found
        //print_r($customer_array);
 
             $response["status"] = FALSE;
            $response["msg"] = "This is category list";
            echo json_encode($response);
} else {
    // required post params is missing
    $response["status"] = TRUE;
    $response["msg"] = "Required parameters email or password is missing!";
    echo json_encode($response);
}
?>