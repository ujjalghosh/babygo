<?php
include "includes/session.php";
$category_id = isset($_REQUEST['category_id']) ? $_REQUEST['category_id'] : 0;
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'add';
if ($_REQUEST['submit'] == 'Submit') {
 
	$category_name = $_REQUEST['category_name'];
 
} else {
	$category_name = '';
}
if ($_REQUEST['submit'] == 'Submit') {
	$name_value = array(  'category_name' => rep($category_name) );
	// Product_type Add //
	if ($action == "add") {
		$product_category->product_category_add($name_value, "Product Category added successfully. Please enter another.", "Sorry, nothing is added.", "Sorry, Product type name is already added. Please use another name.");
	}
	// Product_type Edit //
	elseif ($action == "edit") {
		$product_category->Product_category_edit($name_value, $category_id, "Product_type updated successfully.", "Sorry, nothing is updated.", "Sorry, Product type is already added. Please use another name.");
	}
}
// Show Value When Try To Update Product_type //
elseif ($action == "edit") {
	$product_category_array = $product_category->Product_category_display($db->tbl_pre . "category_tbl", array(), "WHERE category_id=" . $category_id . "");
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
						<input type="hidden" name="category_id" id="category_id" value="<?php echo $category_id; ?>" />
						<div class="box-body">
							<?php echo $_SESSION['product_category_msg'];
							$_SESSION['product_category_msg'] = ""; ?>
 

							<div class="form-group">
								<label class="col-sm-2 control-label">Name</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="category_name" id="category_name"  data-validation-engine="validate[required]" value="<?php echo $product_category_array[0]['category_name']; ?>" />
								</div>
							</div>
							<div class="form-group">
						  <label class="col-sm-2 control-label">Image</label>
						  <div class="col-sm-10">
						  <input type="file" name="category_image" id="category_image" <?php echo $course_array[0]['category_image'] == '' ? 'data-validation-engine="validate[required]"' : ''; ?> />
						              
						    
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