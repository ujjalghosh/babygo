<?php
include "includes/session.php";
$product_details_id = isset($_REQUEST['product_details_id']) ? $_REQUEST['product_details_id'] : 0;
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'add';
if ($_REQUEST['submit'] == 'Submit') {
	 
	$product_id = $_REQUEST['product_id'];
	$size_id = $_REQUEST['size_id'];
	$style_set_qty = $_REQUEST['style_set_qty']; 
	$style_mrp_for_size = $_REQUEST['style_mrp_for_size'];
	$stock_in_hand =$_REQUEST['stock_in_hand']; 
	$tally_item_name =$_REQUEST['tally_item_name']; 
} else {
	 
	$product_id = '';
	$size_id = '';
	$style_set_qty=''; 
	$style_mrp_for_size = '';
	$stock_in_hand =''; 
	$tally_item_name ='';
}
if ($_REQUEST['submit'] == 'Submit') {
	$name_value = array( 'product_id' => rep($product_id), 'style_set_qty'=> rep($style_set_qty), 'style_mrp_for_size' => rep($style_mrp_for_size), 'stock_in_hand'=>rep($stock_in_hand),'size_id' => rep($size_id),'tally_item_name' => rep($tally_item_name));
	// Product Add //
	if ($action == "add") {
		$product_details->product_details_add($name_value, "Product Style added successfully. Please enter another.", "Sorry, nothing is added.", "Sorry, email id is already added. Please use another email id.");
	}
	// Product Edit //
	elseif ($action == "edit") {
		 
		$product_details->product_details_edit($name_value, $product_details_id, "Product Style Updated successfully.", "Sorry, nothing is updated.", "Sorry, email id is already added. Please use another email id.");

	}
}
// Show Value When Try To Update Product //product_details_idPrimary
elseif ($action == "edit") {
	$Product_details_array = $product_details->product_details_display($db->tbl_pre . "product_details_tbl", array(), "WHERE product_details_id=" . $product_details_id . "");
	//print_r($Product_details_array);
}

include "includes/header.php";
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Manage Product Style
		</h1>
		<ol class="breadcrumb">
			<li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active"><?php echo $action == 'add' ? 'Add' : 'Edit'; ?> Product Style</li>
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
						<h3 class="box-title"><?php echo $action == 'add' ? 'Add' : 'Edit'; ?> Product Style</h3>
					</div><!-- /.box-header -->
					<!-- form start -->
					<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
						<input type="hidden" name="action" id="action" value="<?php echo $action; ?>" />
						<input type="hidden" name="product_details_id" id="product_details_id" value="<?php echo $product_details_id; ?>" />
						<div class="box-body">
							<?php echo $_SESSION['product_style_msg'];
							$_SESSION['product_style_msg'] = ""; ?>
 
 
							<div class="form-group">
								<label class="col-sm-2 control-label">Style No</label>
								<div class="col-sm-10">
									<select name="product_id" id="product_id" class="form-control select2" data-validation-engine="validate[required]"  >
<?php
$Product_array = $Product->Product_display($db->tbl_pre . "product_tbl", array(), ""); ?>									
				 <option value="">-- Select Product Style --</option>
						<?php  for($l=0; $l<count($Product_array); $l++) {    ?>
	<option value="<?php echo $Product_array[$l]["product_id"]; ?>" <?php echo $Product_details_array[0]['product_id']==$Product_array[$l]['product_id'] ? 'selected' : ''; ?>><?php echo $Product_array[$l]["style_no"]; ?></option>
	<?php } ?>										  
					</select>



								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Size</label>
								<div class="col-sm-10">
<select name="size_id" id="size_id" class="form-control select2" data-validation-engine="validate[required]"  >

<?php
$Product_size_array = $Product_size->Product_size_display($db->tbl_pre . "product_size_tbl", array(), "WHERE size_status='Active'");
	?>								
			<option value="">-- Select Product Group --</option>
				<?php  for($l=0; $l<count($Product_size_array); $l++) {    ?>
	<option value="<?php echo $Product_size_array[$l]["product_size_id"]; ?>" <?php echo $Product_size_array[$l]['product_size_id']==$Product_details_array[0]['size_id'] ? 'selected' : ''; ?>><?php echo $Product_size_array[$l]["size_description"]; ?></option>
	<?php } ?>
<?php// } ?>
</select>

								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Style Set Qty</label>
								<div class="col-sm-10">
									<input type="text" class="form-control  " placeholder="Enter ..." name="style_set_qty" id="style_set_qty"  data-validation-engine="validate[required]" value="<?php echo repc($Product_details_array[0]['style_set_qty']); ?>" />
								</div>
							</div>
 
							<div class="form-group">
								<label class="col-sm-2 control-label">MRP For Size</label>
								<div class="col-sm-10">
									<input type="text" class="form-control  " placeholder="Enter ..." name="style_mrp_for_size" id="style_mrp_for_size"  data-validation-engine="validate[required]" value="<?php echo repc($Product_details_array[0]['style_mrp_for_size']); ?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Stock In Hand (Set) </label>
								<div class="col-sm-10">
									<input type="text" class="form-control " placeholder="Enter ..."  name="stock_in_hand" id="stock_in_hand"  data-validation-engine="validate[required]" value="<?php echo repc($Product_details_array[0]['stock_in_hand']); ?>" />
								</div>
							</div>
 
  								<div class="form-group">
								<label class="col-sm-2 control-label">Tally Item Name </label>
								<div class="col-sm-10">
									<input type="text" class="form-control " placeholder="Enter ..." name="tally_item_name" id="tally_item_name" value="<?php echo repc($Product_details_array[0]['tally_item_name']); ?>" />
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
<script type="text/javascript">

</script>
  