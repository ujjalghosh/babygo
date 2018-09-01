<?php include 'header.php'; 
if (isset($_REQUEST['s'])) {
	$search_term=$_REQUEST['s'];
}else{
	$search_term='';
}

if (isset($_REQUEST['category_id'])) {
	$category_id =$_REQUEST['category_id'];
$refine_by_array  = $product_group->product_group_display($db->tbl_pre . "product_group_tbl", array(), "WHERE product_category_id=" . $category_id . "");
$response["refine_by"]  = array();
}else{	$category_id ='';}
    // receiving the post params

if (isset($_REQUEST['category_id'])) {
if(isset($_REQUEST['refine_by'])){
	$product_group_id=$_REQUEST['refine_by'];
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

$product_array = $Product->product_display($db->tbl_pre . "product_tbl", array(), "WHERE category_id=".$category_id." and  group_id ='".$product_group_id."' order by ".$order_by." ");

$product_totalnum = $Product->product_display($db->tbl_pre . "product_tbl", array(), "WHERE category_id=".$category_id." and  group_id ='".$product_group_id."' ");

} else {
    $product_array = $Product->product_display($db->tbl_pre . "product_tbl", array(), "WHERE category_id=".$category_id." and  group_id ='".$product_group_id."' ");
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
    $product_array = $Product->product_display($db->tbl_pre . "product_tbl", array(), "WHERE category_id=".$category_id."  order by ".$order_by." ");
}
else {
    $product_array = $Product->product_display($db->tbl_pre . "product_tbl", array(), "WHERE category_id=".$category_id." " );  
}
}
else {
  $product_array = $Product->product_display($db->tbl_pre . "product_tbl", array(), "WHERE style_no like '%".$search_term."%' or product_name like '%".$search_term."%' " );   
	}

?>

 <form method="post" id="product_search">
 	<input type="hidden" name="product_search" value="<?php echo $search_term; ?>">
<?php if(isset($_REQUEST['category_id'])){ ?>
	<input type="hidden" name="category_id" value="<?php echo $category_id; ?>">
	<?php } if(isset($_REQUEST['sort_by'])){ ?>
<input type="hidden" name="refine_by" value="<?php echo $_REQUEST['sort_by']; ?>">
	<?php } if(isset($_REQUEST['refine_by'])){ ?>
<input type="hidden" name="refine_by" value="<?php echo $_REQUEST['refine_by']; ?>">
	<?php } ?>
</form> 

	<div class="main-con">

		<div class="container">

			<div class="filter-wrap">

				<div class="row">

					<div class="col-md-6 col-sm-7 col-xs-12">

						<div class="filter-con">

							<ul class="filter-list">

								<li>

									<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-sort" aria-hidden="true"></i> Sort</a>

									<ul class="dropdown-menu">									

										<li><a href="<?php echo Site_URL.'search.php?category_id='.$category_id.'&s='.$search_term; ?>"> Sort by</a></li>

										<li><a href="<?php echo Site_URL.'search.php?sort_by=Popularity&category_id='.$category_id.'&s='.$search_term; ?>">Popularity</a></li>

										<li><a href="<?php echo Site_URL.'search.php?sort_by=New&category_id='.$category_id.'&s='.$search_term; ?>">New</a></li>

										<li><a href="<?php echo Site_URL.'search.php?sort_by=Hot Selling&category_id='.$category_id.'&s='.$search_term; ?>">Hot Selling</a></li>

									</ul>

								</li>

								<li class="purple-drop">

									<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-filter" aria-hidden="true"></i> Refine</a>

									<ul class="dropdown-menu">

										<li>Refine by</li>

										<?php if(count($refine_by_array)>0){

  										for ($i=0; $i <count($refine_by_array) ; $i++) { ?>

										<li><a href="<?php echo Site_URL.'search.php?refine_by='.$refine_by_array[$i]["product_group_id"].'&category_id='.$category_id.'&s='.$search_term; ?>"><?php echo $refine_by_array[$i]["product_group_name"]; ?></a></li>

										<?php } } ?>

									</ul>

								</li>

							</ul>

							<ul class="filter-btn">

								<li><a href="<?php echo Site_URL; ?>wishlist.php"><i class="fa fa-heart" aria-hidden="true"></i></a></li>

								<li><a href="<?php echo Site_URL; ?>shopping-bag.php"><i class="fa fa-shopping-bag" aria-hidden="true"></i></a></li>

							</ul>

						</div>

					</div>

					<div class="col-md-6 col-sm-5 col-xs-12">

						<div class="pagination-con pagination">

							<span>Page:</span>

						<!-- 	<ul class="pagination">
							    <li class="active"><a href="#">1</a></li>
							    <li><a href="#">2</a></li>
							    <li><a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
						  	</ul> -->

						</div>

					</div>

				</div>

			</div>

			<div class="product-row" id="results">


			</div>

		</div>

	</div>



<?php include 'footer.php'; ?>