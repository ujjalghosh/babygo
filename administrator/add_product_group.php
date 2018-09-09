<?php
include "includes/session.php";
$product_group_id = isset($_REQUEST['product_group_id']) ? $_REQUEST['product_group_id'] : 0;
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'add';
if ($_REQUEST['submit'] == 'Submit') {
	$product_category_id	= $_REQUEST['product_category_id'];
	$product_group_name = $_REQUEST['product_group_name'];
	$product_hsn = $_REQUEST['product_hsn'];
 
} else {
	$product_group_name = '';
}
if ($_REQUEST['submit'] == 'Submit') {
	$name_value = array('product_category_id'=>rep($product_category_id), 'product_group_name' => rep($product_group_name), 'product_hsn' => rep($product_hsn) );
	// product_group Add //
	if ($action == "add") {
		$product_group->product_group_add($name_value, "Product group added successfully. Please enter another.", "Sorry, nothing is added.", "Sorry, Product group name is already added. Please use another name.");
	}
	// product_group Edit //
	elseif ($action == "edit") {
		$product_group->product_group_edit($name_value, $product_group_id, "product_group updated successfully.", "Sorry, nothing is updated.", "Sorry, Product group is already added. Please use another name.");
	}
}
// Show Value When Try To Update product_group //
elseif ($action == "edit") {
	$product_group_array = $product_group->product_group_display($db->tbl_pre . "product_group_tbl", array(), "WHERE product_group_id=" . $product_group_id . "");
}
include "includes/header.php";
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Manage Product Type
		</h1>
		<ol class="breadcrumb">
			<li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active"><?php echo $action == 'add' ? 'Add' : 'Edit'; ?> Product Type</li>
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
						<h3 class="box-title"><?php echo $action == 'add' ? 'Add' : 'Edit'; ?> Product Type</h3>
					</div><!-- /.box-header -->
					<!-- form start -->
					<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
						<input type="hidden" name="action" id="action" value="<?php echo $action; ?>" />
						<input type="hidden" name="product_group_id" id="product_group_id" value="<?php echo $product_group_id; ?>" />
						<div class="box-body">
							<?php echo $_SESSION['Product_group_msg'];
							$_SESSION['Product_group_msg'] = ""; ?>
							<div class="form-group">
								<label class="col-sm-2 control-label">Group For</label>
								<div class="col-sm-10">
									<select name="product_category_id" id="product_category_id" class="form-control select2" data-validation-engine="validate[required]"  >
<?php
$product_category_array = $product_category->Product_category_display($db->tbl_pre . "category_tbl", array(), "WHERE category_status='Active'");
?>									
										<option value="">-- Select Product Type --</option>
						<?php  for($l=0; $l<count($product_category_array); $l++) {    ?>
	<option value="<?php echo $product_category_array[$l]["category_id"]; ?>" <?php echo $product_group_array[0]['product_category_id']==$product_category_array[$l]["category_id"] ? 'selected' : ''; ?>><?php echo $product_category_array[$l]["category_name"]; ?></option>
	<?php } ?>

										  
									</select>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label">Name</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="product_group_name" id="product_group_name"  data-validation-engine="validate[required]" value="<?php echo $product_group_array[0]['product_group_name']; ?>" />
								</div>
							</div>


							<div class="form-group">
								<label class="col-sm-2 control-label">HSN</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="product_hsn" id="product_hsn"  data-validation-engine="validate[required]" value="<?php echo $product_group_array[0]['product_hsn']; ?>" />
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