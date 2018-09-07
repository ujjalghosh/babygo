<?php
include "../includes/settings.php";
include "../includes/class_call_one_file.php";
ob_start();
$product_array=array();
if(isset($_POST["page"])){
	$page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
	if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
}else{
	$page_number = 1;
}
//get current starting point of records
$position = (($page_number-1) * 4);

if (isset($_REQUEST['category_id'])) {
	$category_id =$_REQUEST['category_id'];
}else{	$category_id ='';}
    // receiving the post params
 
if (isset($_REQUEST['category_id'])) {
if(isset($_REQUEST['refine_by'])){
	$product_group_id=$_REQUEST['refine_by'];

 $sql_group = "(group_id LIKE '%,$product_group_id,%' OR group_id LIKE '$product_group_id,%' OR group_id LIKE '%,$product_group_id' OR group_id = '$product_group_id') ";

if (isset($_REQUEST['sort_by'])) {
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

$product_array = $Product->product_display($db->tbl_pre . "product_tbl", array(), "WHERE category_id=".$category_id." and  ".$sql_group." order by ".$order_by." limit ".$position.", 4 ");

//$product_totalnum = $Product->product_display($db->tbl_pre . "product_tbl", array(), "WHERE category_id=".$category_id." and  ".$sql_group." limit ".$position.", 4 ");

} else {
    $product_array = $Product->product_display($db->tbl_pre . "product_tbl", array(), "WHERE category_id=".$category_id." and  ".$sql_group." limit ".$position.", 4 ");
}
}

elseif ((isset($_REQUEST['sort_by'])) && !isset($_REQUEST['refine_by'])) {
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
    $product_array = $Product->product_display($db->tbl_pre . "product_tbl", array(), "WHERE category_id=".$category_id."  order by ".$order_by." limit ".$position.", 4 ");
}
else {
  $product_array = $Product->product_display($db->tbl_pre . "product_tbl", array(), "WHERE category_id=".$category_id."   order by product_id DESC limit ".$position.", 4 " );   
	}
}
else {
  $product_array = $Product->product_display($db->tbl_pre . "product_tbl", array(), "order by product_id DESC limit ".$position.", 4 " );   
	}

 


			   for ($i=0; $i <count($product_array) ; $i++) {  ?>

				<div class="col-md-3 col-sm-6">

					<div class="product-col">

						<div class="p-img">

						 <img src="<?php echo Site_URL;?>timthumb.php?src=<?php echo Site_URL;?>/images/product_list/<?php echo $product_array[$i]["style_list_image"]; ?>&h=401&w=300&q=100&zc=2" />					

							<div class="p-fav"><a href="<?php echo Site_URL.'product-details.php?prodcut_details='.$product_array[$i]["product_id"].'&category_id='.$product_array[$i]["category_id"]; ?>"><i class="fa fa-heart" aria-hidden="true"></i></a><a href="<?php echo Site_URL.'product-details.php?prodcut_details='.$product_array[$i]["product_id"].'&category_id='.$product_array[$i]["category_id"]; ?>"><i class="fa fa-shopping-bag" aria-hidden="true"></i></a></div> 

							</ul>

						</div>

						<div class="p-info">						
							<h4><?php echo $product_array[$i]["style_no"];  ?></h4>
							<p><?php echo $product_array[$i]["product_name"];?></p>
							 <a href="<?php echo Site_URL.'product-details.php?prodcut_details='.$product_array[$i]["product_id"].'&category_id='.$product_array[$i]["category_id"]; ?>" class="more">View Details</a> 

						</div>						

					</div>

				</div>

 <?php } ?>