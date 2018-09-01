<?php
include "includes/session.php";
$color_image_id = isset($_REQUEST['color_image_id']) ? $_REQUEST['color_image_id'] : 0;
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'add';
if ($_REQUEST['submit'] == 'Submit') {
	 
	$product_id = $_REQUEST['product_id'];
	$color_id = $_REQUEST['color_id']; 
} else {
	 
	$product_id = '';
	$color_id = ''; 
}
if ($_REQUEST['submit'] == 'Submit') {
	$name_value = array( 'product_id' => rep($product_id), 'color_id' => rep($color_id));
	// Product Add //
	if ($action == "add") {
		$product_image->product_image_add($name_value, "Product added successfully. Please enter another.", "Sorry, nothing is added.", "Sorry, email id is already added. Please use another email id.");
	}
	// Product Edit //
	elseif ($action == "edit") {
		$product_image->Product_edit($name_value, $color_image_id, "Product updated successfully.", "Sorry, nothing is updated.", "Sorry, email id is already added. Please use another email id.");
	}
}
// Show Value When Try To Update Product //product_image_idPrimary
elseif ($action == "edit") {
	$Product_array = $product_image->product_image_display($db->tbl_pre . "product_image_tbl", array(), "WHERE color_image_id=" . $color_image_id . "");
}

include "includes/header.php";
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Manage Product Style Image
		</h1>
		<ol class="breadcrumb">
			<li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active"><?php echo $action == 'add' ? 'Add' : 'Edit'; ?> Product Style Image</li>
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
						<h3 class="box-title"><?php echo $action == 'add' ? 'Add' : 'Edit'; ?> Product Style Image</h3>
					</div><!-- /.box-header -->
					<!-- form start -->
					<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
						<input type="hidden" name="action" id="action" value="<?php echo $action; ?>" />
						<input type="hidden" name="product_image_id" id="product_image_id" value="<?php echo $product_image_id; ?>" />
						<div class="box-body">
							<?php echo $_SESSION['product_image_msg'];
							$_SESSION['product_image_msg'] = ""; ?>
 
 
							<div class="form-group">
								<label class="col-sm-2 control-label">Style No</label>
								<div class="col-sm-10">
									<select name="product_id" id="product_id" class="form-control select2" data-validation-engine="validate[required]"  >
<?php
$Product_array = $Product->Product_display($db->tbl_pre . "product_tbl", array(), "WHERE product_status='Active'"); ?>									
				 <option value="">-- Select Product St --</option>
						<?php  for($l=0; $l<count($Product_array); $l++) {    ?>
	<option value="<?php echo $Product_array[$l]["product_id"]; ?>" <?php echo $Product_size_array[0]['product_id']==$Product_array[0]['product_id'] ? 'selected' : ''; ?>><?php echo $Product_array[$l]["style_no"]; ?></option>
	<?php } ?>										  
					</select>



								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label">Colour</label>
								<div class="col-sm-10">
									<select name="color_id" id="color_id" class="form-control select2" data-validation-engine="validate[required]"  >
<?php 
$Product_color_array = $Product_color->Product_color_display($db->tbl_pre . "product_color_tbl", array(), "WHERE  product_color_status='Active'");	?>

 			 <option value="">-- Select Product St --</option>
						<?php  for($l=0; $l<count($Product_color_array); $l++) {    ?>
	<option value="<?php echo $Product_color_array[$l]["product_color_id"]; ?>" <?php echo $Product_size_array[0]['color_id']==$Product_color_array[0]['product_color_id'] ? 'selected' : ''; ?>><?php echo $Product_color_array[$l]["product_color_name"]; ?></option>
	<?php } ?>										  
					</select>



								</div>
							</div>

 
							<div class="form-group">
								<label class="col-sm-2 control-label">Listing Image</label>
								<div class="col-sm-10">
									<input type="file" class="form-control  " placeholder="Enter ..." name="listing_image" id="listing_image"  data-validation-engine="validate[required]"  />
								</div>
							</div>
 
 							<div class="form-group">
								<label class="col-sm-2 control-label">Main Image from different angle</label>
								<div class="col-sm-10">
									<input type="file" class="form-control  " placeholder="Enter ..." name="style_color_image[]" id="style_color_image" multiple="multiple" data-validation-engine="validate[required]"  />
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
  