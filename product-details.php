<?php include 'header.php';

ob_start();

if( isset($_REQUEST['prodcut_details']) && ($_SESSION['customer_id']!='') ) {

	$product_id=$_REQUEST['prodcut_details'];

//if(isset($_REQUEST['product_id']) && isset($_SESSION["myusername"])) {

$images=$Product->product_display($db->tbl_pre . "product_images_tbl", array(), "WHERE product_id  ='".$product_id."' " );

    $response["product"]["images"] = array();

$product = $Product->product_display($db->tbl_pre . "product_tbl", array(), "WHERE product_id ='".$product_id."'  " );
  $group_id = $product[0]['group_id']; 
$num_of_view=$product[0]["num_of_view"]+1;
$name_value = array( 'num_of_view' => rep($num_of_view) );

$order_confirm = $db->update('product_tbl', $name_value, "product_id='" . $product_id . "'   ");
$related=$Product->product_display($db->tbl_pre . "product_tbl", array(), "WHERE group_id IN(".$group_id.") and product_status='Active' " );

$details=$Product->product_display($db->tbl_pre . "product_details_tbl pdt, " . $db->tbl_pre . "product_size_tbl sz ", array(), "WHERE pdt.product_id ='".$product_id."' and sz.product_size_id=pdt.size_id " );
//print_r($details);
 $other_color= $Product->product_display($db->tbl_pre . "color_image_tbl", array(), "WHERE product_id ='".$product_id."' " );

} else {
exit(header('location: sign-in.php'));
}

 if($_SESSION['customer_id']>0){
  $customer_array = $customer->customer_display($db->tbl_pre . "customer_tbl ct, " . $db->tbl_pre . "customer_category_tbl cct", array(), "WHERE  ct.customer_id='".$_SESSION['customer_id']."' and cct.category_id=ct.customer_category ");
  $discount_percent= $customer_array[0]["discount_persent"];
 }else{
    $discount_percent= 0;
 }
 if(count($customer_array)==0){
  $discount_percent= 0;  
 }

 ?>
<input type="hidden" name="discount_percent" id="discount_percent" value="<?php echo $discount_percent; ?>">
	<div class="main-con">
		<div class="container">
			<div class="filter-wrap">
				<div class="row">
					<div class="col-md-6 col-sm-7 col-xs-12">
						<div class="filter-con">
							<ul class="filter-btn">
								<li><a href="wishlist.php"><i class="fa fa-heart" aria-hidden="true"></i></a></li>
								<li><a href="shopping-bag.php"><i class="fa fa-shopping-bag" aria-hidden="true"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<div class="p-derails-wrap">
				<div class="col-md-4">
					<div class="product-dtls-slider">
						<div class="slider slider-for">
						 <?php for ($i=0; $i <count($images) ; $i++) {  ?>
							<a href="images/product_list/set_images/<?php echo $images[$i]["style_color_image"]; ?>"><img src="images/product_list/set_images/<?php echo $images[$i]["style_color_image"]; ?>"></a>
						 <?php	} ?>
							</div>

						<!-- <div class="slider slider-nav">
						 <?php for ($i=0; $i <count($images) ; $i++) {  ?>
							<div><img src="images/product_list/set_images/<?php echo $images[$i]["style_color_image"]; ?>"></div>
							 <?php	} ?>
						</div> -->
						<?php if (count($other_color)>0) { ?>
						<h4>Other colour available</h4>
						<div class="slider-nav owl-carousel owl-theme">
						<?php  for ($y=0; $y <count($other_color) ; $y++) { ?>
							<div class="owl-slide"><a href="#"><img src="<?php echo SITE_URL.'images/product_list/other_color/'.$other_color[$y]["listing_image"];?>"></a></div>
							<?php } ?>
						</div>
						<?php } ?>
					</div>
				</div>

				<div class="col-md-7 col-md-offset-1">
					<div class="product-inner">
						<div class="title">
							<h1><?php echo $product[0]["style_no"]; ?></h1>
							<p><?php echo $product[0]["product_name"];; ?><span><?php echo strip_tags($product[0]["style_decription"]); ?></span></p>
						</div>

						<form method="post"  id="order_details">
						<input type="hidden" name="item" value="<?php echo count($details); ?>">
						<input type="hidden" name="product_id" value="<?php echo $product_id; ?>">

						<table class="table p-tbl">
						    <thead>
						      <tr>
						        <th>Size</th>
						        <th>Set</th>
						        <th>Pcs</th>
						        <th>MRP</th>
						        <th>AMT</th>
						      </tr>
						    </thead>
						    <tbody>
						    <?php for ($i=0; $i <count($details) ; $i++) {  ?>
						      <tr>			

						        <td align="left">
						    <input type="hidden" id="product_details_id_<?php echo $i;?>" name="product_details_id_<?php echo $i;?>" value="<?php echo $details[$i]["product_details_id"]; ?>">
						    <input type="hidden" name="style_set_qty_<?php echo $i;?>" id="style_set_qty_<?php echo $i;?>" value="<?php echo $details[$i]["style_set_qty"]; ?>">				
						    <input type="hidden" name="stock_in_hand_<?php echo $i;?>" id="stock_in_hand<?php echo $i;?>" value="<?php echo $details[$i]["stock_in_hand"]; ?>">	
						    <input type="hidden" readonly="true" id="amount_<?php echo $i; ?>" name="amount_<?php echo $i; ?>" value="0.00">
						    <input type="hidden" readonly="true" id="style_mrp_for_size<?php echo $i; ?>" name="mrp_<?php echo $i; ?>" value="<?php echo $details[$i]["style_mrp_for_size"]; ?>">						    
						    <input type="hidden" readonly="true" id="piece<?php echo $i; ?>" name="piece_<?php echo $i; ?>"  value="<?php echo $details[$i]["style_set_qty"]; ?>">

						        <?php echo $details[$i]["size_description"]; ?></td>

						        <td> <input class="set_qty" type="text" value="0" data-id="<?php echo $i;?>" id="set_<?php echo $i;?>" name="set_<?php echo $i;?>"></td>

						        <td><span id="set_piece_<?php echo $i; ?>"><?php echo $details[$i]["style_set_qty"]; ?></span></td>

						        <td><?php echo amount_format_in($details[$i]["style_mrp_for_size"]); ?></td>

						        <td align="right"> <span id="amt_<?php echo $i; ?>">0.00</span> </td>

						      </tr>

 				<?php } ?>

						    </tbody>

						</table>

						<div class="btn-grp clearfix">
							<button class="purple-btn" id="add_to_wish_list" type="button"><i class="fa fa-heart" aria-hidden="true"></i> Wishlist</button>
							<button class="yellow-btn" id="add_to_bag" type="submit"><i class="fa fa-shopping-bag" aria-hidden="true"></i> Add to Bag</button>

						</div>

						</form>



						<div class="similar-product">
							<div class="title"><h3>Similar Product</h3></div>					

							<div id="" class="owl-carousel sp-slider owl-theme">

					<?php

					//print_r($related);

					 for ($r=0; $r <count($related) ; $r++) {  ?>

								<div class="owl-slide">

									<a href="<?php echo SITE_URL.'product-details.php?prodcut_details='.$related[$r]["product_id"].'&category_id='.$related[$r]['category_id']?>"><img src="<?php echo Site_URL;?>timthumb.php?src=<?php echo SITE_URL.'images/product_list/'.$related[$r]["style_list_image"]; ?>&h=203&w=152&zc=1">

									<p><?php echo $related[$r]["style_no"] ?></p></a>

								</div>					

					<?php } ?>

								



							</div>
						</div>


					</div>
				</div>
			</div>
		</div>
	</div>

<?php include 'footer.php'; ?>
