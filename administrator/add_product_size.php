<?php
include "includes/session.php";
$product_size_id = isset($_REQUEST['product_size_id']) ? $_REQUEST['product_size_id'] : 0;
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'add';
if ($_REQUEST['submit'] == 'Submit') {
	$size_description = $_REQUEST['size_description'];
 
} else {
	$size_description = '';
}
if ($_REQUEST['submit'] == 'Submit') {
	$name_value = array('size_description' => rep($size_description) );
	// Product_size Add //
	if ($action == "add") {
		$Product_size->Product_size_add($name_value, "Product type added successfully. Please enter another.", "Sorry, nothing is added.", "Sorry, Product type name is already added. Please use another name.");
	}
	// Product_size Edit //
	elseif ($action == "edit") {
		$Product_size->Product_size_edit($name_value, $product_size_id, "Product_size updated successfully.", "Sorry, nothing is updated.", "Sorry, Product type is already added. Please use another name.");
	}
}
// Show Value When Try To Update Product_size //
elseif ($action == "edit") {
	$Product_size_array = $Product_size->Product_size_display($db->tbl_pre . "product_size_tbl", array(), "WHERE product_size_id=" . $product_size_id . "");	
}
include "includes/header.php";
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Manage Product Size
		</h1>
		<ol class="breadcrumb">
			<li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active"><?php echo $action == 'add' ? 'Add' : 'Edit'; ?> Product Size</li>
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
						<h3 class="box-title"><?php echo $action == 'add' ? 'Add' : 'Edit'; ?> Product Size</h3>
					</div><!-- /.box-header -->
					<!-- form start -->
					<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
						<input type="hidden" name="action" id="action" value="<?php echo $action; ?>" />
						<input type="hidden" name="product_size_id" id="product_size_id" value="<?php echo $product_size_id; ?>" />
						<div class="box-body">
							<?php echo $_SESSION['Product_size_msg'];
							$_SESSION['Product_size_msg'] = ""; ?>

							<div class="form-group">
								<label class="col-sm-2 control-label">Size Name</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="size_description" id="size_description"  data-validation-engine="validate[required]" value="<?php echo $Product_size_array[0]['size_description']; ?>" />
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