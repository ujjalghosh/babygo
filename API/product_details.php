<?php
include('common_connect.php'); 
// json response array
$response = array("status" => TRUE);
 

if( isset($_REQUEST['product_id']) && isset($_REQUEST['customer_id'])  ){
 
    // receiving the post params
    $product_id    = $_REQUEST['product_id'];
    $customer_id = $_REQUEST['customer_id'];
    
    $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
    if($page==1){
         $frm=0;
    }
    else{
    $page=$page*10;
    $frm=$page-10;
    }

if( isset($_REQUEST['product_id']) && isset($_REQUEST['customer_id'])  ){
 if($customer_id>0){
  $customer_array = $customer->customer_display($db->tbl_pre . "customer_tbl ct, " . $db->tbl_pre . "customer_category_tbl cct", array(), "WHERE  ct.customer_id='".$customer_id."' and cct.category_id=ct.customer_category ");
  $response["discount_percent"]= $customer_array[0]["discount_persent"];
 }else{
    $response["discount_percent"]= 0;
 }
 if(count($customer_array)==0){
  $response["discount_percent"]= 0;  
 }
 

$product = $Product->product_display($db->tbl_pre . "product_tbl", array(), "WHERE product_id ='".$product_id."'  " );
$group_id = $product[0]['group_id'];
$response["style_no"]= $product[0]["style_no"];
$response["product_name"]= $product[0]["product_name"];
$response["product_description"]= strip_tags($product[0]["style_decription"]);
$num_of_view=$product[0]["num_of_view"]+1;
$name_value = array( 'num_of_view' => rep($num_of_view) );

$order_confirm = $db->update('product_tbl', $name_value, "product_id='" . $product_id . "'   ");


$details=$Product->product_display($db->tbl_pre . "product_details_tbl pdt, " . $db->tbl_pre . "product_size_tbl sz ", array(), "WHERE pdt.product_id ='".$product_id."' and sz.product_size_id=pdt.size_id " );
//echo json_encode($details);
    $response["product"]["details"] = array();

        for ($i=0; $i <count($details) ; $i++) { 
        $product = array();
        $product["product_details_id"] = $details[$i]["product_details_id"];
        $product["product_id"] = $details[$i]["product_id"];
        $product["style_set_qty"] = $details[$i]["style_set_qty"];
        $product["style_mrp_for_size"] = $details[$i]["style_mrp_for_size"];
        $product["stock_in_hand"] = $details[$i]["stock_in_hand"];
        $product["size_id"] = $details[$i]["size_id"];
        $product["size_description"] = $details[$i]["size_description"];
        // push single product into final response array
        array_push($response["product"]["details"], $product);
    }



$related=$Product->product_display($db->tbl_pre . "product_tbl", array(), "WHERE group_id ='".$group_id."' and product_status='Active' " );

$response["product"]["related"] = array();


        for ($i=0; $i <count($related) ; $i++) { 
        $product = array();
        
        $product["product_id"] = $related[$i]["product_id"];
        $product["product_name"] = $related[$i]["product_name"];
        $product["style_decription"] = strip_tags($related[$i]["style_decription"]);
        $product["style_list_image"] = SITE_URL.'images/product_list/'.$related[$i]["style_list_image"];
        
        // push single product into final response array
        array_push($response["product"]["related"], $product);
    }
  $other_color= $Product->product_display($db->tbl_pre . "color_image_tbl", array(), "WHERE product_id ='".$product_id."' " );
 $response["product"]["other_color"] = array();

            for ($i=0; $i <count($other_color) ; $i++) { 
        $product = array();
        
        $product["color_image_id"]  = $other_color[$i]["color_image_id"];
        $product["product_id"]      = $other_color[$i]["product_id"];
        $product["color_id"]        = $other_color[$i]["color_id"];
        $product["extra_text"]      = strip_tags($other_color[$i]["extra_text"]);
        $product["listing_image"]   = SITE_URL.'images/product_list/other_color/'.$other_color[$i]["listing_image"];
        
        // push single product into final response array
        array_push($response["product"]["other_color"], $product);
    }


 
 
$images=$Product->product_display($db->tbl_pre . "product_images_tbl", array(), "WHERE product_id  ='".$product_id."' " );
    $response["product"]["images"] = array();

             for ($i=0; $i <count($images) ; $i++) { 
        $product = array();
        
        $product["image_id"]  = $images[$i]["image_id"];
        $product["product_id"]      = $images[$i]["product_id"]; 
        $product["style_color_image"]   = SITE_URL.'images/product_list/set_images/'.$images[$i]["style_color_image"];
        
        // push single product into final response array
        array_push($response["product"]["images"], $product);
    }


$product_totalnum = $Product->product_display($db->tbl_pre . "product_tbl", array(), "WHERE product_id ='".$product_id."' " );
 




}

    $response["status"] = TRUE;
    $response["msg"] = "This is your product Details";

 
echo json_encode($response);
}
 else {
    // required post params is missing
    $response["status"] = FALSE;
    $response["msg"] = "Required parameters product id is missing!";
    echo json_encode($response);
}
?>