<?php
include "includes/session.php";
$appointment_id = isset($_REQUEST['appointment_id']) ? $_REQUEST['appointment_id'] : 0;
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'add';
if ($_REQUEST['submit'] == 'Submit') {
	$appointment_slot_id = $_REQUEST['appointment_slot_id'];
	$appointment_date = $_REQUEST['appointment_date'];
	$customer_first_name = $_REQUEST['customer_first_name'];
	$customer_last_name = $_REQUEST['customer_last_name'];
	$customer_address = $_REQUEST['customer_address'];
	$customer_city = $_REQUEST['customer_city'];
	$customer_email_address = $_REQUEST['customer_email_address'];
	$zip_code_id = $_REQUEST['zip_code_id'];
	$customer_phone_number = $_REQUEST['customer_phone_number'];
	$customer_phone_number_for = $_REQUEST['customer_phone_number_for'];
	$customer_unit_number = $_REQUEST['customer_unit_number'];
	$customer_address_type = $_REQUEST['customer_address_type'];
	$pricing_id = $_REQUEST['pricing_id'];
	$appointment_story_price = $_REQUEST['appointment_story_price'];
	$franchise_note = $_REQUEST['franchise_note'];
	$customer_note = $_REQUEST['customer_note'];
	$administrator_note = $_REQUEST['administrator_note'];
	$appointment_status = $_REQUEST['appointment_status'];
} else {
	$appointment_slot_id = '';
	$appointment_date = '';
	$customer_first_name = '';
	$customer_last_name = '';
	$customer_address = '';
	$customer_city = '';
	$customer_email_address = '';
	$zip_code_id = '';
	$customer_phone_number = '';
	$customer_phone_number_for = '';
	$customer_unit_number = '';
	$customer_address_type = '';
	$pricing_id = '';
	$franchise_note = '';
	$customer_note = '';
	$administrator_note = '';
	$appointment_story_price = '';
	$appointment_status = '';
}
if ($_REQUEST['submit'] == 'Submit') {
	$name_value = array('appointment_slot_id' => rep($appointment_slot_id), 'appointment_date' => rep($appointment_date), 'customer_first_name' => rep($customer_first_name), 'customer_last_name' => rep($customer_last_name), 'customer_address' => rep($customer_address), 'customer_city' => rep($customer_city), 'customer_email_address' => rep($customer_email_address), 'zip_code_id' => rep($zip_code_id), 'customer_phone_number' => rep($customer_phone_number), 'customer_phone_number_for' => rep($customer_phone_number_for), 'customer_unit_number' => rep($customer_unit_number), 'customer_address_type' => rep($customer_address_type), 'pricing_id' => rep($pricing_id), 'franchise_note' => rep($franchise_note), 'customer_note' => rep($customer_note), 'administrator_note' => rep($administrator_note), 'appointment_story_price' => rep($appointment_story_price), 'appointment_status' => rep($appointment_status));
	// Appointment Add //
	if ($action == "add") {
		$appointment->appointment_add($name_value, "Appointment added successfully. Please enter another.", "Sorry, nothing is added.", "Sorry, appointment is already added. Please use another details.");
	}
	// Appointment Edit //
	elseif ($action == "edit") {
		$appointment->appointment_edit($name_value, $appointment_id, "Appointment updated successfully.", "Sorry, nothing is updated.", "Sorry, email is already added. Please use another email.");
	}
}
// Show Value When Try To Update Appointment //
elseif ($action == "edit") {
	$appointment_array = $appointment->appointment_display($db->tbl_pre . "appointment_tbl", array(), "WHERE appointment_id=" . $appointment_id . "");
	$slot_array = $slot->slot_display($db->tbl_pre . "slot_tbl", array(), "WHERE slot_id=" . $appointment_array[0]['appointment_slot_id'] . "");
	$slot_type = $slot_array[0]['slot_type'];
}

include "includes/header.php";
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Manage Appointment
		</h1>
		<ol class="breadcrumb">
			<li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active"><?php echo $action == 'add' ? 'Add' : 'Edit'; ?> Appointment</li>
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
						<h3 class="box-title"><?php echo $action == 'add' ? 'Add' : 'Edit'; ?> Appointment</h3>
					</div><!-- /.box-header -->
					<!-- form start -->
					<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
						<input type="hidden" name="action" id="action" value="<?php echo $action; ?>" />
						<input type="hidden" name="appointment_id" id="appointment_id" value="<?php echo $appointment_id; ?>" />
						<div class="box-body">
							<?php echo $_SESSION['appointment_msg'];
$_SESSION['appointment_msg'] = ""; ?>
							<div class="form-group">
								<label class="col-sm-2 control-label">Zip Code</label>
								<div class="col-sm-10">
									<select name="zip_code_id" id="zip_code_id" class="form-control select2" data-validation-engine="validate[required]" onchange="display_slot(document.getElementById('slot_type').value,document.getElementById('appointment_date').value,this.value)">
										<option value="">-- Select Zip Code --</option>
										<?php
$zip_code_array = $zip_code->zip_code_display($db->tbl_pre . "zip_code_tbl", array(), "WHERE zip_code_status='Active'");
for ($row = 0; $row < count($zip_code_array); $row++) {
	$dropdown_select = $appointment_array[0]['zip_code_id'] == $zip_code_array[$row]['zip_code_id'] ? 'selected="selected"' : '';
	echo '<option value="' . $zip_code_array[$row]['zip_code_id'] . '" ' . $dropdown_select . '>' . $zip_code_array[$row]['zip_code_value'] . '</option>';
}
?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Appointment Date</label>
								<div class="col-sm-10">
									<input type="text" class="form-control datepicker" placeholder="Enter ..." name="appointment_date" id="appointment_date"  data-validation-engine="validate[required]" value="<?php echo $appointment_array[0]['appointment_date']; ?>" onblur="display_slot(document.getElementById('slot_type').value,this.value,document.getElementById('zip_code_id').value)" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Slot Type</label>
								<div class="col-sm-10">
									<select name="slot_type" id="slot_type" class="form-control select2" data-validation-engine="validate[required]" onchange="display_slot(this.value,document.getElementById('appointment_date').value,document.getElementById('zip_code_id').value)">
										<option value="">-- Select Slot Type --</option>
										<option value="Morning" <?php echo $slot_type == 'Morning' ? 'selected="selected"' : ''; ?>>Morning</option>
										<option value="Afternoon" <?php echo $slot_type == 'Afternoon' ? 'selected="selected"' : ''; ?>>Afternoon</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Available Slot</label>
								<div class="col-sm-10" id="appsloid">
									<select name="appointment_slot_id" id="appointment_slot_id" class="form-control select2" data-validation-engine="validate[required]">
										<option value="">-- Select Slot --</option>
										<?php
$slot_array = $slot->slot_display($db->tbl_pre . "slot_tbl", array());
for ($row = 0; $row < count($slot_array); $row++) {
	$dropdown_select = $appointment_array[0]['appointment_slot_id'] == $slot_array[$row]['slot_id'] ? 'selected="selected"' : '';
	echo '<option value="' . $slot_array[$row]['slot_id'] . '" ' . $dropdown_select . '>' . $slot_array[$row]['slot_start_hour'] . '.' . $slot_array[$row]['slot_start_minute'] . ' - ' . $slot_array[$row]['slot_end_hour'] . '.' . $slot_array[$row]['slot_end_minute'] . '</option>';
}
?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Customer First Name</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="customer_first_name" id="customer_first_name"  data-validation-engine="validate[required]" value="<?php echo $appointment_array[0]['customer_first_name']; ?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Customer Last Name</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="customer_last_name" id="customer_last_name"  data-validation-engine="validate[required]" value="<?php echo $appointment_array[0]['customer_last_name']; ?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Customer Email Address</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="customer_email_address" id="customer_email_address"  data-validation-engine="validate[required,custom[email]]" value="<?php echo $appointment_array[0]['customer_email_address']; ?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Customer Phone Number For</label>
								<div class="col-sm-10">
									<select name="customer_phone_number_for" id="customer_phone_number_for" class="form-control select2" data-validation-engine="validate[required]">
										<option value="">-- Select Type --</option>
										<option value="Home" <?php echo $appointment_array[0]['customer_phone_number_for'] == 'Home' ? 'selected="selected"' : ''; ?>>Home</option>
										<option value="Work" <?php echo $appointment_array[0]['customer_phone_number_for'] == 'Work' ? 'selected="selected"' : ''; ?>>Work</option>
										<option value="Mobile" <?php echo $appointment_array[0]['customer_phone_number_for'] == 'Mobile' ? 'selected="selected"' : ''; ?>>Mobile</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Customer Phone Number</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="customer_phone_number" id="customer_phone_number"  data-validation-engine="validate[required]" value="<?php echo $appointment_array[0]['customer_phone_number']; ?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Customer Address</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="customer_address" id="customer_address"  data-validation-engine="validate[required]" value="<?php echo $appointment_array[0]['customer_address']; ?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Customer City</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="customer_city" id="customer_city"  data-validation-engine="validate[required]" value="<?php echo $appointment_array[0]['customer_city']; ?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Appt. No</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="customer_unit_number" id="customer_unit_number"  data-validation-engine="validate[required,custom[integer]]" value="<?php echo $appointment_array[0]['customer_unit_number']; ?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Customer Address Type</label>
								<div class="col-sm-10">
									<select name="customer_address_type" id="customer_address_type" class="form-control select2" data-validation-engine="validate[required]" onchange="display_appointment_price(this.value)">
										<option value="">-- Select Address Type --</option>
										<option value="Single Family" <?php echo $appointment_array[0]['customer_address_type'] == 'Single Family' ? 'selected="selected"' : ''; ?>>Single Family</option>
										<option value="Multi Family" <?php echo $appointment_array[0]['customer_address_type'] == 'Multi Family' ? 'selected="selected"' : ''; ?>>Multi Family</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Number Of Units</label>
								<div class="col-sm-10" id="appuniid">
									<select name="pricing_id" id="pricing_id" class="form-control select2" data-validation-engine="validate[required]">
										<option value="">-- Select Unit --</option>
										<?php
$pricing_array = $pricing->pricing_display($db->tbl_pre . "pricing_tbl", array());
for ($pa = 0; $pa < count($pricing_array); $pa++) {
	if ($pricing_array[$pa]['pricing_square_footage'] != 0) {
		$prisqufot = 'Square Footage up to ' . $pricing_array[$pa]['pricing_square_footage'] . ' - ';
	} else {
		$prisqufot = '';
	}
	$dropdown_select = $appointment_array[0]['pricing_id'] == $pricing_array[$pa]['pricing_id'] ? 'selected="selected"' : '';
	echo '<option value="' . $pricing_array[$pa]['pricing_id'] . '" ' . $dropdown_select . '>' . $pricing_array[$pa]['pricing_unit'] . ' (' . $prisqufot . '$' . $pricing_array[$pa]['pricing_amount'] . ')</option>';
}
?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">How Many Stories</label>
								<div class="col-sm-10">
									<select name="appointment_story_price" id="appointment_story_price" class="form-control select2" data-validation-engine="validate[required]">
										<option value="">-- Select Story --</option>
										<option value="0" <?php echo $appointment_array[0]['appointment_story_price'] == 0 ? 'selected="selected"' : ''; ?>>1 Story Unit</option>
										<option value="<?php echo Story_2_Unit_Price; ?>" <?php echo $appointment_array[0]['appointment_story_price'] == Story_2_Unit_Price ? 'selected="selected"' : ''; ?>>2 Story Unit</option>
										<option value="<?php echo Story_3_Unit_Price; ?>" <?php echo $appointment_array[0]['appointment_story_price'] == Story_3_Unit_Price ? 'selected="selected"' : ''; ?>>3 Story Unit</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Status</label>
								<div class="col-sm-10">
									<select name="appointment_status" id="appointment_status" class="form-control select2" data-validation-engine="validate[required]">
										<option value="">-- Select Type --</option>
										<option value="Booked" <?php echo $appointment_array[0]['appointment_status'] == 'Booked' ? 'selected="selected"' : ''; ?>>Booked</option>
										<option value="Pending" <?php echo $appointment_array[0]['appointment_status'] == 'Pending' ? 'selected="selected"' : ''; ?>>Pending</option>
										<option value="Cancel" <?php echo $appointment_array[0]['appointment_status'] == 'Cancel' ? 'selected="selected"' : ''; ?>>Cancel</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Franchise Note</label>
								<div class="col-sm-10">
									<textarea class="form-control" placeholder="Enter ..." name="franchise_note" id="franchise_note"  data-validation-engine="validate[]"><?php echo repc($appointment_array[0]['franchise_note']); ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Customer Note</label>
								<div class="col-sm-10">
									<textarea class="form-control" placeholder="Enter ..." name="customer_note" id="customer_note"  data-validation-engine="validate[]"><?php echo repc($appointment_array[0]['customer_note']); ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Admin Note</label>
								<div class="col-sm-10">
									<textarea class="form-control" placeholder="Enter ..." name="administrator_note" id="administrator_note"  data-validation-engine="validate[]"><?php echo repc($appointment_array[0]['administrator_note']); ?></textarea>
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