<?php
include "includes/session.php";
$product_color_id = isset($_REQUEST['product_color_id']) ? $_REQUEST['product_color_id'] : 0;
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'add';
if ($_REQUEST['submit'] == 'Submit') {
	$product_color_name = $_REQUEST['product_color_name'];
 
} else {
	$product_color_name = '';
}
if ($_REQUEST['submit'] == 'Submit') {
	$name_value = array('product_color_name' => rep($product_color_name) );
	// Product_color Add //
	if ($action == "add") {
		$Product_color->Product_color_add($name_value, "Product color added successfully. Please enter another.", "Sorry, nothing is added.", "Sorry, Product type name is already added. Please use another name.");
	}
	// Product_color Edit //
	elseif ($action == "edit") {
		$Product_color->Product_color_edit($name_value, $product_color_id, "Product color updated successfully.", "Sorry, nothing is updated.", "Sorry, Product type is already added. Please use another name.");
	}
}
// Show Value When Try To Update Product_color //
elseif ($action == "edit") {
	$Product_color_array = $Product_color->Product_color_display($db->tbl_pre . "product_color_tbl", array(), "WHERE product_color_id=" . $product_color_id . "");	
}
include "includes/header.php";
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Manage Product Colour
		</h1>
		<ol class="breadcrumb">
			<li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active"><?php echo $action == 'add' ? 'Add' : 'Edit'; ?> Product Colour</li>
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
						<h3 class="box-title"><?php echo $action == 'add' ? 'Add' : 'Edit'; ?> Product Colour</h3>
					</div><!-- /.box-header -->
					<!-- form start -->
					<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
						<input type="hidden" name="action" id="action" value="<?php echo $action; ?>" />
						<input type="hidden" name="product_color_id" id="product_color_id" value="<?php echo $product_color_id; ?>" />
						<div class="box-body">
							<?php echo $_SESSION['Product_color_msg'];
							$_SESSION['Product_color_msg'] = ""; ?>

							<div class="form-group">
								<label class="col-sm-2 control-label">Color Name</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="product_color_name" id="product_color_name"  data-validation-engine="validate[required]" value="<?php echo $Product_color_array[0]['product_color_name']; ?>" />
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