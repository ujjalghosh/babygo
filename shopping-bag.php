<?php include 'header.php'; 

if( $_SESSION['customer_id']=='')  {
header('Location: '.Site_URL.'');
exit();
}
 $customer_id=$_SESSION['customer_id'];
$orderchk_query = $db->query("select distinct product_id from " . $db->tbl_pre . "orders_tbl where customer_id='" . $customer_id . "' and order_status='Cart' order by  `trans_id` DESC ", PDO::FETCH_BOTH);
$order_num = $db->total($orderchk_query);
    


?>
	<form method="post" id="place_order">	

<input type="hidden" id="customer_id" name="customer_id" value="<?php echo $_SESSION['customer_id']; ?>">
<input type="hidden" id="total_cart" name="total_cart" value="<?php echo $order_num; ?>">

	<div class="main-con">
		<div class="container">
			<div class="filter-wrap">
				<div class="row">
					<div class="col-md-6 col-sm-7 col-xs-12">
					</div>
					<div class="col-md-6 col-sm-5 col-xs-12">
						<div class="pagination-con pagination">							
							
						</div>
					</div>
				</div>
			</div>
			<div class="sec-title"><h2>YOUR SHOPPING BAG[<?php echo $order_num; ?>]</h2></div>
			<div class="wishlist-con">	
					
		<div class="wishlist-row">
		<?php  
		$total_bill_amount=0;
		     if ($order_num != 0) {		
      $orderchk_array = $db->result($orderchk_query);
      if (count($orderchk_array)>0) {


  $customer_array = $customer->customer_display($db->tbl_pre . "customer_tbl ct, " . $db->tbl_pre . "customer_category_tbl cct", array(), "WHERE  ct.customer_id='".$customer_id."' and cct.category_id=ct.customer_category "); 
  $discount_percent= $customer_array[0]["discount_persent"];
?>
<input type="hidden" name="discount_percent" id="discount_percent" value="<?php echo $discount_percent; ?>">

<?php
	for($k=0;$k<count($orderchk_array);$k++) {
	$product_list= $Product->product_display($db->tbl_pre . "product_tbl", array(), "WHERE product_id ='".$orderchk_array[$k]["product_id"]."'  " );
	for ($i=0; $i <count($product_list) ; $i++) { 

$order_query = $db->query("select * from " . $db->tbl_pre . "orders_tbl where customer_id='" . $customer_id . "' and order_status='Cart' and product_id='".$product_list[$i]["product_id"]."' order by product_details_id asc", PDO::FETCH_BOTH);
 $order_array = $db->result($order_query);

      	?>

      	<input type="hidden" id="product_id" name="product_id_<?php echo $k;?>" value="<?php echo $orderchk_array[$k]["product_id"]; ?>">
      	<input type="hidden" id="product_id" name="product_item_<?php echo $orderchk_array[$k]["product_id"];?>" value="<?php echo count($order_array); ?>">
      	

					<div class="wishlist-col mHeight" >

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
							      	<?php 
$total=0;
$total= $pddetails[0]["style_mrp_for_size"]*$order_array[$d]["total_set"]*$pddetails[0]["style_set_qty"];
$dis=$total*$discount_percent/100;
$total=$total-$dis;
 ?>
							<input type="hidden" id="product_details_id_<?php echo $d;?>" name="<?php echo $orderchk_array[$k]["product_id"];?>_product_details_id_<?php echo $d;?>" value="<?php echo $pddetails[0]["product_details_id"]; ?>">
						    <input type="hidden" name="<?php echo $orderchk_array[$k]["product_id"];?>_style_set_qty_<?php echo $d;?>" id="style_set_qty_<?php echo $d;?>" value="<?php echo $pddetails[0]["style_set_qty"]; ?>">				
						    <input type="hidden" name="<?php echo $orderchk_array[$k]["product_id"];?>_stock_in_hand_<?php echo $d;?>" id="stock_in_hand<?php echo $d;?>" value="<?php echo $pddetails[0]["stock_in_hand"]; ?>">	
						    <input type="hidden" readonly="true" id="amount_<?php echo $d; ?>" name="<?php echo $orderchk_array[$k]["product_id"];?>_amount_<?php echo $d; ?>" value="<?php echo  $total; ?>">
						    <input type="hidden" readonly="true" id="style_mrp_for_size<?php echo $d; ?>" name="<?php echo $orderchk_array[$k]["product_id"];?>_mrp_<?php echo $d; ?>" value="<?php echo $pddetails[0]["style_mrp_for_size"]; ?>">						    
						    <input type="hidden" readonly="true" id="piece<?php echo $d; ?>" name="<?php echo $orderchk_array[$k]["product_id"];?>_piece_<?php echo $d; ?>"  value="<?php echo $pddetails[0]["style_set_qty"]; ?>">

							        <td align="left"><?php echo $pddetails[0]["size_description"]; ?></td>
							        <td> <input class="set_qty" data-id="<?php echo $d;?>" data-pid="<?php echo $orderchk_array[$k]["product_id"];?>" type="text" value="<?php echo $order_array[$d]["total_set"] ?>" name="<?php echo $orderchk_array[$k]["product_id"];?>_set_<?php echo $d; ?>"></td>
							        <td><?php echo $pddetails[0]["style_set_qty"]*$order_array[$d]["total_set"] ?></td>

							        <td><?php echo $pddetails[0]["style_mrp_for_size"]; ?></td>
							        <td align="right"><?php echo $total; ?></td>
							        <?php  $total_bill_amount= $total_bill_amount + $total; ?>
							      </tr>

								<?php } ?>

							    </tbody>
							</table>
							<div class="btn-grp">
								<button class="gray-btn remove-bag" data-id="<?php echo $product_list[$i]["product_id"] ?>" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i> Remove</button>
								<button class="yellow-btn move-Wishlist" data-id="<?php echo $product_list[$i]["product_id"] ?>" type="submit"><i class="fa fa-shopping-bag" aria-hidden="true"></i> Move to Wishlist</button>
							</div>
						</div>
					</div>
<?php } } } } else {
	echo ' <h2> No items found in your cart. </h2>';
	} ?>

		
				</div>				
			</div>
			<div class="spacer"></div>
			<div class="i-box dark bill-info">
				<div class="ibox-row">
					<label>Total Bill Amount (Taxes extra)</label>
					<input type="text" name="total_bill_amount" id="total_bill_amount" readonly="" value="<?php echo $total_bill_amount; ?>">
				</div>
<?php 
   $customer_array = $customer->customer_display($db->tbl_pre . "customer_tbl ct "  , array(), "WHERE  ct.customer_id='".$customer_id."'   "); 

   $shipping_address = strip_tags($customer_array[0]["shipping_address"]);
   $customer_address = strip_tags($customer_array[0]["customer_address"]); ?>

				<div class="ibox-row">
					<label>Billing Address</label>
					<div class="input-holder">
						<input type="text" name="billing_address" readonly="" value="<?php echo strip_tags($customer_address);?>">
						<a class="edit" href="#"><i class="fa fa-pencil" aria-hidden="true"></i></a>
					</div>					
				</div>
				 <div class="ibox-row">
					<label>Billing City</label>
					<div class="input-holder">
						<input type="text" name="billing_city" readonly="" value="<?php echo $customer_array[0]["customer_city"]; ?>"> 
					</div>					
				</div>
								<div class="ibox-row">
					<label>Billing State</label>
					<div class="input-holder">
						  <select name="billing_state" id="billing_state" class="form-control select2" data-validation-engine="validate[required]" >
                    <option value="">-- Select State --</option>
<?php $state_array = $customer->customer_display($db->tbl_pre . "state_list_tbl", array(), ""); 
for ($i=0; $i <count($state_array) ; $i++) { ?>

<option value="<?php echo $state_array[$i]['Code']; ?>" <?php echo $customer_array[0]["customer_state"] == $state_array[$i]['Code'] ? 'selected="selected"' : ''; ?> > <?php echo $state_array[$i]['Subdivision_name']; ?> </option>  

<?php } ?>
                 
 </select> 
					</div>					
				</div>
				 <div class="ibox-row">
					<label>Billing PIN</label>
					<div class="input-holder">
						<input type="text" name="billing_pin" readonly="" value="<?php echo $customer_array[0]["customer_pin"];?>"> 
					</div>					
				</div>
				<div class="ibox-row">
					<label>Shipping Address</label>
					<div class="input-holder">
						<input type="text" name="shipping_address"  value="<?php echo strip_tags($shipping_address);?>">
						<a class="edit" href="#"><i class="fa fa-pencil" aria-hidden="true"></i></a>
					</div>
				</div>
				 <div class="ibox-row">
					<label>Shipping City</label>
					<div class="input-holder">
						<input type="text" name="shipping_city" readonly="" value="<?php echo $customer_array[0]["shipping_city"];;?>"> 
					</div>					
				</div>
								<div class="ibox-row">
					<label>Shipping State</label>
					<div class="input-holder">
						  <select name="shipping_state" id="shipping_state" class="form-control select2" data-validation-engine="validate[required]" >
                    <option value="">-- Select State --</option>
<?php $state_array = $customer->customer_display($db->tbl_pre . "state_list_tbl", array(), ""); 
for ($i=0; $i <count($state_array) ; $i++) { ?>

<option value="<?php echo $state_array[$i]['Code']; ?>" <?php echo $customer_array[0]["shipping_state"] == $state_array[$i]['Code'] ? 'selected="selected"' : ''; ?> > <?php echo $state_array[$i]['Subdivision_name']; ?> </option>  

<?php } ?>
                 
 </select> 
					</div>					
				</div>
				 <div class="ibox-row">
					<label>Shipping PIN</label>
					<div class="input-holder">
						<input type="text" name="shipping_pin" readonly="" value="<?php echo $customer_array[0]["shipping_pin"];?>"> 
					</div>					
				</div>
				
			</div>
			<div class="order-con">
				<div class="courier-con">
					<h5>Please specify :</h5>
					<ul>
 
						<li>
							 <label for="other-opt">Remarks</label>
							<input id="other-inp" type="text" name="remarks">
						</li>
					</ul>
				</div>
				<input type="submit" name="submit" id="order_submit" value="Order">								
			</div>
		</div>

	</div>
</form>
<?php include 'footer.php'; ?>
