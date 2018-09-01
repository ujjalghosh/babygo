<?php

include('common_connect.php'); 

// json response array

$response = array("status" => TRUE);

 

if (isset($_REQUEST['category_id'])) {

 

    // receiving the post params

    $category_id    = $_REQUEST['category_id'];

$refine_by_array  = $product_group->product_group_display($db->tbl_pre . "product_group_tbl", array(), "WHERE product_category_id=" . $category_id . "");
$response["refine_by"]  = array();
if(count($refine_by_array)>0){
  for ($i=0; $i <count($refine_by_array) ; $i++) { 
$refine = array();

        $refine["product_group_id"]        = $refine_by_array[$i]["product_group_id"];
        $refine["product_group_name"]      = strip_tags($refine_by_array[$i]["product_group_name"]);
 
        array_push($response["refine_by"], $refine); 
}
  }

$response["sort_by"]=array("Popularity","New","Hot Selling");
 


    $product_group_id = $_REQUEST['refine_by'];

    $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;

    if($page==1){

         $frm=0;

    }

    else{

    $page=$page*10;

    $frm=$page-10;

    }

 

if( isset($_REQUEST['category_id']) ){
if( $_REQUEST['refine_by']>0){

if (!empty($_REQUEST['sort_by'])) {
    $orderby=$_REQUEST['sort_by'];
    if ($orderby=="Popularity") {
        $order_by="num_of_view DESC";
    }
        elseif ($orderby=="New") {
        $order_by="product_id DESC";
    }
        elseif ($orderby=="Hot Selling") {
        $order_by="num_of_sell DESC";
    }
    $product_array = $Product->product_display($db->tbl_pre . "product_tbl", array(), "WHERE category_id ='".$category_id."' and  group_id ='".$product_group_id."' order by ".$order_by." limit ".$frm.",10");
$product_totalnum = $Product->product_display($db->tbl_pre . "product_tbl", array(), "WHERE category_id ='".$category_id."' and  group_id ='".$product_group_id."' ");
}else{
    $product_array = $Product->product_display($db->tbl_pre . "product_tbl", array(), "WHERE category_id ='".$category_id."' and  group_id ='".$product_group_id."' limit ".$frm.",10");
$product_totalnum = $Product->product_display($db->tbl_pre . "product_tbl", array(), "WHERE category_id ='".$category_id."' and  group_id ='".$product_group_id."' ");
}

}
elseif ((!empty($_REQUEST['sort_by'])) && ($_REQUEST['refine_by']==0)) {
    $orderby=$_REQUEST['sort_by'];
    if ($orderby=="Popularity") {
        $order_by="num_of_view DESC";
    }
        elseif ($orderby=="New") {
        $order_by="product_id DESC";
    }
        elseif ($orderby=="Hot Selling") {
        $order_by="num_of_sell DESC";
    }
    $product_array = $Product->product_display($db->tbl_pre . "product_tbl", array(), "WHERE category_id ='".$category_id."'  order by ".$order_by." limit ".$frm.",10");
$product_totalnum = $Product->product_display($db->tbl_pre . "product_tbl", array(), "WHERE category_id ='".$category_id."'  ");
}
else {
    $product_array = $Product->product_display($db->tbl_pre . "product_tbl", array(), "WHERE category_id ='".$category_id."' limit ".$frm." , 10" );
    $product_totalnum = $Product->product_display($db->tbl_pre . "product_tbl", array(), "WHERE category_id ='".$category_id."'  ");
}


 $response["product"]  = array();



            for ($i=0; $i <count($product_array) ; $i++) { 

        $product = array();

        

        $product["product_id"]  = $product_array[$i]["product_id"];

        $product["style_no"]      = $product_array[$i]["style_no"];

        $product["category_id"]      = $product_array[$i]["category_id"];

        $product["category_id"]        = $product_array[$i]["category_id"];

        $product["product_group_id"]        = $product_array[$i]["group_id"];



        $product["product_name"]      = $product_array[$i]["product_name"];

        $product["style_set_qty_mapping"]      = $product_array[$i]["style_set_qty_mapping"];

        $product["style_color_qty"]        = $product_array[$i]["style_color_qty"];

        $product["style_list_image"]        = $product_array[$i]["style_list_image"];

        $product["style_decription"]      = strip_tags($product_array[$i]["style_decription"]);

        

        // push single product into final response array

        array_push($response["product"], $product);

    }
 

//$product_totalnum = $Product->product_display($db->tbl_pre . "product_tbl", array(), "WHERE category_id ='".$category_id."' " );

$response["product_totl"]=count($product_totalnum);



}



    $response["status"] = TRUE;

    $response["msg"] = "This is your product list";



 

echo json_encode($response);

}

 else {

    // required post params is missing

    $response["status"] = FALSE;

    $response["msg"] = "Required parameters category is missing!";

    echo json_encode($response);

}

?>