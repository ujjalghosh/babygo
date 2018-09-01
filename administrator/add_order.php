<?php
include "includes/session.php";
$order_id = isset($_REQUEST['order_id']) ? $_REQUEST['order_id'] : 0;
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'add';
if ($_REQUEST['submit'] == 'Submit') {
	$billing_address = $_REQUEST['billing_address'];
	$shipping_address = $_REQUEST['shipping_address'];
	$total_bill_amount = $_REQUEST['total_bill_amount'];
	$customer_id = $_REQUEST['customer_id'];
	$generate_no = $_REQUEST['generate_no'];
	$preferred_courier_service = $_REQUEST['preferred_courier_service']=='other-cour'? $_REQUEST['other_corir'] : $_REQUEST['preferred_courier_service'];
} else {
	$shipping_address = '';
	$total_bill_amount = '';
	$customer_id = '';
	$billing_address = '';
	$generate_no = '';
	$preferred_courier_service ='';
}
if ($_REQUEST['submit'] == 'Submit') {
	
	$name_value = array('billing_address' => rep($billing_address), 'customer_id' => $customer_id, 'generate_no' => $generate_no, 'shipping_address' => rep($shipping_address), 'total_bill_amount' => $total_bill_amount,'preferred_courier_service'=>$preferred_courier_service);
	// Subscriber Add //
	if ($action == "add") {
//pricing->pricing_add($name_value, "Pricing added successfully. Please enter another.", "Sorry, nothing is added.", "Sorry, pricing is already added. Please use another pricing.");
	}
	// Subscriber Edit //
	elseif ($action == "edit") {
		$order->order_edit($name_value, $order_id, "Order updated successfully.", "Sorry, nothing is updated.", "Sorry, pricing is already added. Please use another Order.");
	}
}
// Show Value When Try To Update Subscriber //
elseif ($action == "edit") {
	$order_array = $order->order_display($db->tbl_pre . "order_master", array(), "WHERE order_id=" . $order_id . "");
	 
}

include "includes/header.php";
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Manage order
		</h1>
		<ol class="breadcrumb">
			<li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active"><?php echo $action == 'add' ? 'Add' : 'Edit'; ?> order</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<!-- left column -->
			<div class="col-md-12">
				<!-- general form elements -->
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title"><?php echo $action == 'add' ? 'Add' : 'Edit'; ?> order</h3>
					</div><!-- /.box-header -->
					<!-- form start -->
					<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
						<input type="hidden" name="action" id="action" value="<?php echo $action; ?>" />
						<input type="hidden" name="order_id" id="order_id" value="<?php echo $order_id; ?>" />
						<di vclass="box-body">
							<?php echo $_SESSION['order_msg']; $_SESSION['order_msg'] = ""; ?>
							
														<div class="form-group">
								<label class="col-sm-2 control-label">Order No</label>
								<div class="col-sm-10">
								<input class="form-control" type="text" readonly id="generate_no" name="generate_no" value="<?php echo $order_array[0]['generate_no']; ?>" />
									
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label">Customer</label>
								<div class="col-sm-10">
									<select name="customer_id" id="customer_id" class="form-control select2" data-validation-engine="validate[required]"  >
	<?php 
	$customer_array = $customer->customer_display($db->tbl_pre . "customer_tbl", array(), "WHERE customer_id=" . $order_array[0]["customer_id"] . "");
		for ($c=0; $c <count($customer_array) ; $c++) { ?>										 
	<option value="<?php echo $customer_array[$c]['customer_id']; ?>" <?php echo $customer_array[$c]['customer_id'] == $order_array[0]["customer_id"] ? 'selected="selected"' : ''; ?>><?php echo repc($customer_array[$c]['customer_name']); ?></option>
		<?php } ?>								 
									</select>
								</div>
							</div>

				<?php 
 if($order_array[0]["customer_id"]>0){
  $customer_array = $customer->customer_display($db->tbl_pre . "customer_tbl ct, " . $db->tbl_pre . "customer_category_tbl cct", array(), "WHERE  ct.customer_id='".$order_array[0]["customer_id"]."' and cct.category_id=ct.customer_category ");
  $discount_percent= $customer_array[0]["discount_persent"];
 }else{
    $discount_percent= 0;
 }
 if(count($customer_array)==0){
  $discount_percent= 0;  
 }
				?>
				<input type="hidden" name="discount_percent" id="discount_percent" value="<?php echo $discount_percent; ?>" />
							<div class="form-group">
								<label class="col-sm-2 control-label">Billing Address</label>
								<div class="col-sm-10">
								<textarea style="width:100%;" rows="5" name="billing_address"><?php echo $order_array[0]['billing_address']; ?></textarea>									 
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Shipping Address</label>
								<div class="col-sm-10">
								<textarea style="width:100%;" rows="5" name="shipping_address"><?php echo $order_array[0]['shipping_address']; ?></textarea>
									
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Preferred Courier Service</label>
								<div class="col-sm-10">
									<input type="radio" class="form-control" name="preferred_courier_service"  value="Safexpress" data-validation-engine="validate[required]" <?php echo $order_array[0]['preferred_courier_service'] == 'Safexpress' ? 'checked="checked"' : ''; ?> /> Safexpress
									<input type="radio" class="form-control" name="preferred_courier_service"  value="Gati" data-validation-engine="validate[required]" <?php echo $order_array[0]['preferred_courier_service'] == 'Gati' ? 'checked="checked"' : ''; ?> /> Gati
									<input type="radio" class="form-control" name="preferred_courier_service"  value="other-cour" data-validation-engine="validate[required]" <?php echo $order_array[0]['preferred_courier_service'] != 'Safexpress' && 'Gati' ? 'checked="checked"' : ''; ?> /> Others
									<br>
									 
					<input type="text" class="form-control" placeholder="Enter ..." name="other_corir" id="other_corir"  data-validation-engine="validate[required]" value="<?php echo repc($order_array[0]['preferred_courier_service']); ?>" />
					
								</div>
							</div>


							  <?php 
$orderchk_query = $db->query("select distinct product_id from " . $db->tbl_pre . "orders_tbl where generate_no ='" . $order_array[0]['generate_no']  . "' ", PDO::FETCH_BOTH);
$order_num = $db->total($orderchk_query);
    if ($order_num != 0) {?>
<input type="hidden" name="order_num" value="<?php echo $order_num; ?>" />
      <?php $orderchk_array = $db->result($orderchk_query);
       
for($k=0;$k<count($orderchk_array);$k++) {
$product_list= $Product->product_display($db->tbl_pre . "product_tbl", array(), "WHERE product_id ='".$orderchk_array[$k]["product_id"]."'  " );
		for ($i=0; $i <count($product_list) ; $i++) { 
							  ?>
					<div class="form-group">
							<div class="col-sm 4 control-label pull-left"> <img height="60" width="60" src="<?php echo SITE_URL.'images/product_list/'.$product_list[$i]["style_list_image"]; ?>">
							<br>  <?php echo $product_list[$i]["product_name"]; ?>          
					        <br>  <?php echo $product_list[$i]["style_no"]; ?></div>
							<div class="col-sm-8 pull-right">
							<div class="table-responsive">        
						  <table class="table">
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
<?php
$order_query = $db->query("select * from " . $db->tbl_pre . "orders_tbl where generate_no ='" . $order_array[0]['generate_no']  . "' and product_id='".$product_list[$i]["product_id"]."'   ", PDO::FETCH_BOTH);
 $order_array_details = $db->result($order_query);?>
<input type="hidden" name="num_product_id<?php echo $k; ?>" value="<?php echo count($order_array_details); ?>" />
              <?php for($d=0;$d<count($order_array_details);$d++) {
               $details = array();
 $pddetails=$Product->product_display($db->tbl_pre . "product_details_tbl pdt, " . $db->tbl_pre . "product_size_tbl sz ", array(), "WHERE pdt.product_id ='".$order_array_details[$d]["product_id"]."' and pdt.product_details_id='".$order_array_details[$d]["product_details_id"]."' and sz.product_size_id=pdt.size_id " );
?>

					      <tr>			
					        <td align="left">
					         <input type="hidden" id="product_id<?php echo $k.'_'.$d;?>" name="product_id<?php echo $k.'_'.$d;?>" value="<?php echo $order_array_details[$d]["product_id"]; ?>">
						    <input type="hidden" id="product_details_id_<?php echo $k.'_'.$d;?>" name="product_details_id_<?php echo $k.'_'.$d;?>" value="<?php echo $order_array_details[$d]["product_details_id"]; ?>">
						    <input type="hidden" name="style_set_qty_<?php echo $k.'_'.$d;?>" id="style_set_qty_<?php echo $k.'_'.$d;?>" value="<?php echo $pddetails[0]["style_set_qty"]; ?>">				
						    <input type="hidden" name="stock_in_hand_<?php echo $k.'_'.$d;?>" id="stock_in_hand<?php echo $k.'_'.$d;?>" value="<?php echo $pddetails[0]["stock_in_hand"]+$order_array_details[$d]["total_set"]; ?>">	
						    <input type="hidden" class="amount" readonly="true" id="amount_<?php echo $k.'_'.$d; ?>" name="amount_<?php echo $k.'_'.$d; ?>" value="0.00">
						    <input type="hidden" readonly="true" id="style_mrp_for_size<?php echo $k.'_'.$d; ?>" name="mrp_<?php echo $k.'_'.$d; ?>" value="<?php echo  $pddetails[0]["style_mrp_for_size"]; ?>">						    
						    <input type="hidden" readonly="true" id="piece<?php echo $k.'_'.$d; ?>" name="piece_<?php echo $k.'_'.$d; ?>"  value="<?php echo $pddetails[0]["style_set_qty"]; ?>">

						        <?php echo $pddetails[0]["size_description"]; ?></td>

						        <td> <input class="set_qty form-control" type="text" value="<?php echo $order_array_details[$d]["total_set"]; ?>" data-id="<?php echo $k.'_'.$d;?>" id="set_<?php echo $k.'_'.$d;?>" name="set_<?php echo $k.'_'.$d;?>"></td>

						        <td><span id="set_piece_<?php echo $k.'_'.$d; ?>"><?php echo $order_array_details[$d]["piece"]; ?></span></td>

						        <td><?php echo $order_array_details[$d]["mrp"]; ?></td>

						        <td align="right"> <span id="amt_<?php echo $k.'_'.$d; ?>"><?php echo $order_array_details[$d]["amount"]; ?></span> </td>

						      </tr>

          <?php } ?>

						    </tbody>
						  </table>

						  </div>									
								</div>
							</div>
<?php } } } ?>
  							
							<div class="form-group">
								<label class="col-sm-2 control-label">Total Amount</label>
								<div class="col-sm-10">
								<input class="form-control" type="text" readonly id="total_bill_amount" name="total_bill_amount" value="<?php echo $order_array[0]['total_bill_amount']; ?>" />
									
								</div>
							</div>


						</div><!-- /.box-body -->
						<div class="box-footer">
							<button type="submit" class="btn btn-primary" name="submit" value="Submit">Submit</button>
						</div>
					</form>
				</div><!-- /.box -->
			</div><!--/.col (left) -->
		</div>   <!-- /.row -->
	</section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php include "includes/footer.php";?>