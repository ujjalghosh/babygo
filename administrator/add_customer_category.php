<?php
include "includes/session.php";
$category_id = isset($_REQUEST['category_id']) ? $_REQUEST['category_id'] : 0;
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'add';
if ($_REQUEST['submit'] == 'Submit') {
	$category_name = $_REQUEST['category_name']; 
	$discount_persent = $_REQUEST['discount_persent'];
	 
} else {
	$category_name = ''; 
	$discount_persent = ''; 
}
if ($_REQUEST['submit'] == 'Submit') {
	$name_value = array('category_name' => rep($category_name),  'discount_persent' => rep($discount_persent) );
	// customer Add //
	if ($action == "add") {
		$customer_category->customer_category_add($name_value, "customer Category added successfully. Please enter another.", "Sorry, nothing is added.", "Sorry, Category is already added. Please use another email id.");
	}
	// customer Edit //
	elseif ($action == "edit") {
		$customer_category->customer_category_edit($name_value, $category_id, "customer Category updated successfully.", "Sorry, nothing is updated.", "Sorry, customer Category is already added. Please use another customer Category.");
	}
}
// Show Value When Try To Update customer //
elseif ($action == "edit") {
	$customer_array = $customer_category->customer_category_display($db->tbl_pre . "customer_category_tbl", array(), "WHERE category_id=" . $category_id . "");
}

include "includes/header.php";
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Manage customer Category
		</h1>
		<ol class="breadcrumb">
			<li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active"><?php echo $action == 'add' ? 'Add' : 'Edit'; ?> Customer Category</li>
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
						<h3 class="box-title"><?php echo $action == 'add' ? 'Add' : 'Edit'; ?> Customer Category</h3>
					</div><!-- /.box-header -->
					<!-- form start -->
					<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
						<input type="hidden" name="action" id="action" value="<?php echo $action; ?>" />
						<input type="hidden" name="category_id" id="category_id" value="<?php echo $category_id; ?>" />
						<div class="box-body">
							<?php echo $_SESSION['customer_category_msg'];
$_SESSION['customer_category_msg'] = ""; ?>

							<div class="form-group">
								<label class="col-sm-2 control-label">Category Name</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="category_name" id="category_name"  data-validation-engine="validate[required]" value="<?php echo repc($customer_array[0]['category_name']); ?>" />
								</div>
							</div>
 
							<div class="form-group">
								<label class="col-sm-2 control-label">Discount Persent</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="discount_persent" id="discount_persent"  data-validation-engine="validate[required]" value="<?php echo repc($customer_array[0]['discount_persent']); ?>" />
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