<?php include 'header.php'; 
if( $_SESSION['customer_id']=='')  {
header('Location: '.Site_url.'');
exit();
}
 $customer_id=$_SESSION['customer_id'];
$orderchk_query = $db->query("select distinct product_id from " . $db->tbl_pre . "orders_tbl where customer_id='" . $customer_id . "' and order_status='Wishlist' order by  `trans_id` DESC ", PDO::FETCH_BOTH);
$order_num = $db->total($orderchk_query);

?>
<input type="hidden" id="customer_id" value="<?php echo $_SESSION['customer_id']; ?>">
	<div class="main-con">
		<div class="container">
			<div class="filter-wrap">
				<div class="row">
					<div class="col-md-6 col-sm-7 col-xs-12">
					</div>
					<div class="col-md-6 col-sm-5 col-xs-12">
						<div class="pagination-con">
							 
						</div>
					</div>
				</div>
			</div>
			<div class="sec-title"><h2>YOUR WISHLIST[<?php echo $order_num; ?>]</h2></div>
			<div class="wishlist-con">	
			<div class="wishlist-row">	
						<?php  
		     if ($order_num != 0) {		
      $orderchk_array = $db->result($orderchk_query);
      if (count($orderchk_array)>0) {     	 
      
      		for($k=0;$k<count($orderchk_array);$k++) {
	$product_list= $Product->product_display($db->tbl_pre . "product_tbl", array(), "WHERE product_id ='".$orderchk_array[$k]["product_id"]."'  " );
	for ($i=0; $i <count($product_list) ; $i++) { 

$order_query = $db->query("select * from " . $db->tbl_pre . "orders_tbl where customer_id='" . $customer_id . "' and order_status='Wishlist' and product_id='".$product_list[$i]["product_id"]."' ", PDO::FETCH_BOTH);
 $order_array = $db->result($order_query);
 
      	?>
					<div class="wishlist-col mHeight">
						<div class="img-con"><img src="<?php echo Site_URL;?>timthumb.php?src=<?php echo Site_URL;?>/images/product_list/<?php echo $product_list[$i]["style_list_image"]; ?>&h=203&w=152&zc=1" /></div>
						<div class="dtls">
							<h4><?php echo $product_list[$i]["style_no"]; ?> | <?php echo $product_list[$i]["product_name"]; ?></h4>
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

<?php    for($d=0;$d<count($order_array);$d++) {  
 $pddetails=$Product->product_display($db->tbl_pre . "product_details_tbl pdt, " . $db->tbl_pre . "product_size_tbl sz ", array(), "WHERE pdt.product_id ='".$order_array[$d]["product_id"]."' and pdt.product_details_id='".$order_array[$d]["product_details_id"]."' and sz.product_size_id=pdt.size_id " );
							    	?>
							      <tr>
							<input type="hidden" id="product_details_id_<?php echo $d;?>" name="product_details_id_<?php echo $d;?>" value="<?php echo $pddetails[0]["product_details_id"]; ?>">
						    <input type="hidden" name="style_set_qty_<?php echo $d;?>" id="style_set_qty_<?php echo $d;?>" value="<?php echo $pddetails[0]["style_set_qty"]; ?>">				
						    <input type="hidden" name="stock_in_hand_<?php echo $d;?>" id="stock_in_hand<?php echo $d;?>" value="<?php echo $pddetails[0]["stock_in_hand"]; ?>">	
						    <input type="hidden" readonly="true" id="amount_<?php echo $d; ?>" name="amount_<?php echo $d; ?>" value="0.00">
						    <input type="hidden" readonly="true" id="style_mrp_for_size<?php echo $d; ?>" name="mrp_<?php echo $d; ?>" value="<?php echo $pddetails[0]["style_mrp_for_size"]; ?>">						    
						    <input type="hidden" readonly="true" id="piece<?php echo $d; ?>" name="piece_<?php echo $d; ?>"  value="<?php echo $pddetails[0]["style_set_qty"]; ?>">

							        <td align="left"><?php echo $pddetails[0]["size_description"]; ?></td>
							        <td> <input class="set_qty" type="text" value="<?php echo $order_array[$d]["total_set"] ?>" name=""></td>
							        <td><?php echo $order_array[$d]["piece"] ?></td>
							        <td><?php echo $order_array[$d]["mrp"] ?></td>
							        <td align="right"><?php echo $order_array[$d]["amount"] ?></td>
							      </tr>

								<?php } ?>

							    </tbody>
							</table>
							<div class="btn-grp">
								<button class="gray-btn remove-wishlist" data-id="<?php echo $product_list[$i]["product_id"] ?>" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i> Remove</button>
								<button class="yellow-btn move-bag" data-id="<?php echo $product_list[$i]["product_id"] ?>" type="submit"><i class="fa fa-shopping-bag" aria-hidden="true"></i> Move to Bag</button>
							</div>
						</div>
					</div>

				
<?php
//echo $k % 2==0? '</div> <div class="wishlist-row">' : '';
 } } } } else {
	echo ' <h2> No items found in your wishlist, </h2>';
	} ?>
			</div>
		</div>
	</div>
</div>
<?php include 'footer.php'; ?>
