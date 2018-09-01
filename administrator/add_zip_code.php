<?php
include "includes/session.php";
$zip_code_id = isset($_REQUEST['zip_code_id']) ? $_REQUEST['zip_code_id'] : 0;
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'add';
if ($_REQUEST['submit'] == 'Submit') {
	$zip_code_value = $_REQUEST['zip_code_value'];
	$location_id = $_REQUEST['location_id'];
} else {
	$zip_code_value = '';
	$location_id = '';
}
if ($_REQUEST['submit'] == 'Submit') {
	$name_value = array('zip_code_value' => rep($zip_code_value), 'location_id' => rep($location_id));
	// Zip code Add //
	if ($action == "add") {
		$zip_code->zip_code_add($name_value, "Zip code added successfully. Please enter another.", "Sorry, nothing is added.", "Sorry, name is already added. Please use another name.");
	}
	// Zip code Edit //
	elseif ($action == "edit") {
		$zip_code->zip_code_edit($name_value, $zip_code_id, "Zip code updated successfully.", "Sorry, nothing is updated.", "Sorry, name is already added. Please use another name.");
	}
}
// Show Value When Try To Update Zip code //
elseif ($action == "edit") {
	$zip_code_array = $zip_code->zip_code_display($db->tbl_pre . "zip_code_tbl", array(), "WHERE zip_code_id=" . $zip_code_id . "");
}
//echo $box_image_total_count;
include "includes/header.php";
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Manage Zip Code
		</h1>
		<ol class="breadcrumb">
			<li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active"><?php echo $action == 'add' ? 'Add' : 'Edit'; ?> Zip Code</li>
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
						<h3 class="box-title"><?php echo $action == 'add' ? 'Add' : 'Edit'; ?> Zip code</h3>
					</div><!-- /.box-header -->
					<!-- form start -->
					<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
						<input type="hidden" name="action" id="action" value="<?php echo $action; ?>" />
						<input type="hidden" name="zip_code_id" id="zip_code_id" value="<?php echo $zip_code_id; ?>" />
						<div class="box-body">
							<?php echo $_SESSION['zip_code_msg'];
$_SESSION['zip_code_msg'] = ""; ?>
							<div class="form-group">
								<label class="col-sm-2 control-label">Location</label>
								<div class="col-sm-10">
									<select name="location_id" id="location_id" class="form-control select2" data-validation-engine="validate[required]">
										<option value="">-- Select Location --</option>
										<?php
$location_array = $location->location_display($db->tbl_pre . "location_tbl", array(), "WHERE location_status='Active'", '', 'location_name asc');
for ($row = 0; $row < count($location_array); $row++) {
	$dropdown_select = $zip_code_array[0]['location_id'] == $location_array[$row]['location_id'] ? 'selected="selected"' : '';
	echo '<option value="' . $location_array[$row]['location_id'] . '" ' . $dropdown_select . '>' . $location_array[$row]['location_name'] . '</option>';
}
?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Value</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="zip_code_value" id="zip_code_value"  data-validation-engine="validate[required]" value="<?php echo repc($zip_code_array[0]['zip_code_value']); ?>" />
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