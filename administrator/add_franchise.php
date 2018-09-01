<?php
include "includes/session.php";
$franchise_id = isset($_REQUEST['franchise_id']) ? $_REQUEST['franchise_id'] : 0;
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'add';
if ($_REQUEST['submit'] == 'Submit') {
	$franchise_name = $_REQUEST['franchise_name'];
	$franchise_email = $_REQUEST['franchise_email'];
	$franchise_phone_number = $_REQUEST['franchise_phone_number'];
	$franchise_password = $_REQUEST['franchise_password'];
	$franchise_description = $_REQUEST['franchise_description'];
	$franchise_address=$_REQUEST['franchise_address'];
} else {
	$franchise_name = '';
	$franchise_email = '';
	$franchise_phone_number = '';
	$franchise_password = '';
	$franchise_description = '';
	$franchise_address='';
}
if ($_REQUEST['submit'] == 'Submit') {
	$name_value = array('franchise_name' => rep($franchise_name), 'franchise_email' => rep($franchise_email), 'franchise_phone_number' => rep($franchise_phone_number), 'franchise_password' => encode($franchise_password), 'franchise_description' => rep($franchise_description), 'franchise_address'=>rep($franchise_address));
	// Franchise Add //
	if ($action == "add") {
		$franchise->franchise_add($name_value, "Franchise added successfully. Please enter another.", "Sorry, nothing is added.", "Sorry, email id is already added. Please use another email id.");
	}
	// Franchise Edit //
	elseif ($action == "edit") {
		$franchise->franchise_edit($name_value, $franchise_id, "Franchise updated successfully.", "Sorry, nothing is updated.", "Sorry, email id is already added. Please use another email id.");
	}
}
// Show Value When Try To Update Franchise //
elseif ($action == "edit") {
	$franchise_array = $franchise->franchise_display($db->tbl_pre . "franchise_tbl", array(), "WHERE franchise_id=" . $franchise_id . "");
}

include "includes/header.php";
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Manage Franchise
		</h1>
		<ol class="breadcrumb">
			<li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active"><?php echo $action == 'add' ? 'Add' : 'Edit'; ?> Franchise</li>
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
						<h3 class="box-title"><?php echo $action == 'add' ? 'Add' : 'Edit'; ?> Franchise</h3>
					</div><!-- /.box-header -->
					<!-- form start -->
					<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
						<input type="hidden" name="action" id="action" value="<?php echo $action; ?>" />
						<input type="hidden" name="franchise_id" id="franchise_id" value="<?php echo $franchise_id; ?>" />
						<div class="box-body">
							<?php echo $_SESSION['franchise_msg'];
$_SESSION['franchise_msg'] = ""; ?>

							<div class="form-group">
								<label class="col-sm-2 control-label">Name</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="franchise_name" id="franchise_name"  data-validation-engine="validate[required]" value="<?php echo repc($franchise_array[0]['franchise_name']); ?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Email Address</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="franchise_email" id="franchise_email"  data-validation-engine="validate[required,custom[email]]" value="<?php echo repc($franchise_array[0]['franchise_email']); ?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Phone Number</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="franchise_phone_number" id="franchise_phone_number"  data-validation-engine="validate[required]" value="<?php echo repc($franchise_array[0]['franchise_phone_number']); ?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Password</label>
								<div class="col-sm-10">
									<input type="password" class="form-control" placeholder="Enter ..." name="franchise_password" id="franchise_password" data-validation-engine="validate[required,custom[password]]" value="<?php echo decode($franchise_array[0]['franchise_password']); ?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Confirm Password</label>
								<div class="col-sm-10">
									<input type="password" class="form-control" placeholder="Enter ..." name="franchise_confirm_password" id="franchise_confirm_password"  data-validation-engine="validate[required,equals[franchise_password]]" value="<?php echo decode($franchise_array[0]['franchise_password']); ?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Short Description</label>
								<div class="col-sm-10">
									<textarea class="form-control ckeditor" placeholder="Enter ..." name="franchise_description" id="franchise_description"><?php echo repc($franchise_array[0]['franchise_description']); ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Address</label>
								<div class="col-sm-10">
					<textarea class="form-control ckeditor" placeholder="Enter ..." name="franchise_address" id="franchise_address"><?php echo repc($franchise_array[0]['franchise_address']); ?></textarea>							</div>
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