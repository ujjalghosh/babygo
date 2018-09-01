<?php
include "includes/session.php";
$slot_id = isset($_REQUEST['slot_id']) ? $_REQUEST['slot_id'] : 0;
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'add';
if ($_REQUEST['submit'] == 'Submit') {
	$slot_type = $_REQUEST['slot_type'];
	$slot_start_hour = $_REQUEST['slot_start_hour'];
	$slot_start_minute = $_REQUEST['slot_start_minute'];
	$slot_end_hour = $_REQUEST['slot_end_hour'];
	$slot_end_minute = $_REQUEST['slot_end_minute'];
} else {
	$slot_start_hour = '';
	$slot_end_hour = '';
	$slot_start_minute = '';
	$slot_type = '';
	$slot_end_minute = '';
}
if ($_REQUEST['submit'] == 'Submit') {
	$name_value = array('slot_type' => $slot_type, 'slot_end_minute' => rep($slot_end_minute), 'slot_start_hour' => rep($slot_start_hour), 'slot_start_minute' => rep($slot_start_minute), 'slot_end_hour' => rep($slot_end_hour));
	// Slot Add //
	if ($action == "add") {
		$slot->slot_add($name_value, "Slot added successfully. Please enter another.", "Sorry, nothing is added.", "Sorry, slot is already added. Please add another slot.");
	}
	// Slot Edit //
	elseif ($action == "edit") {
		$slot->slot_edit($name_value, $slot_id, "Slot updated successfully.", "Sorry, nothing is updated.", "Sorry, slot is already added. Please add another slot.");
	}
}
// Show Value When Try To Update Slot //
elseif ($action == "edit") {
	$slot_array = $slot->slot_display($db->tbl_pre . "slot_tbl", array(), "WHERE slot_id=" . $slot_id . "");
}

include "includes/header.php";
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Manage Slot
		</h1>
		<ol class="breadcrumb">
			<li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active"><?php echo $action == 'add' ? 'Add' : 'Edit'; ?> Slot</li>
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
						<h3 class="box-title"><?php echo $action == 'add' ? 'Add' : 'Edit'; ?> Slot</h3>
					</div><!-- /.box-header -->
					<!-- form start -->
					<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
						<input type="hidden" name="action" id="action" value="<?php echo $action; ?>" />
						<input type="hidden" name="slot_id" id="slot_id" value="<?php echo $slot_id; ?>" />
						<div class="box-body">
							<?php echo $_SESSION['slot_msg'];
$_SESSION['slot_msg'] = ""; ?>
							<div class="form-group">
								<label class="col-sm-2 control-label">Slot Type</label>
								<div class="col-sm-10">
									<select name="slot_type" id="slot_type" class="form-control select2" data-validation-engine="validate[required]">
										<option value="">-- Select Type --</option>
										<option value="Morning" <?php echo $slot_array[0]['slot_type'] == 'Morning' ? 'selected="selected"' : ''; ?>>Morning</option>
										<option value="Afternoon" <?php echo $slot_array[0]['slot_type'] == 'Afternoon' ? 'selected="selected"' : ''; ?>>Afternoon</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Start Hour</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="slot_start_hour" id="slot_start_hour"  data-validation-engine="validate[required,custom[integer]]" value="<?php echo $slot_array[0]['slot_start_hour']; ?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Start Minute</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="slot_start_minute" id="slot_start_minute" data-validation-engine="validate[required,custom[integer]]" value="<?php echo $slot_array[0]['slot_start_minute']; ?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">End Hour</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="slot_end_hour" id="slot_end_hour"  data-validation-engine="validate[required,custom[integer]]" value="<?php echo $slot_array[0]['slot_end_hour']; ?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">End Minute</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="slot_end_minute" id="slot_end_minute"  data-validation-engine="validate[required,custom[integer]]" value="<?php echo $slot_array[0]['slot_end_minute']; ?>" />
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<div class="bal-editor-demo">
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