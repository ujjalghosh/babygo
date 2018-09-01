<?php
include "includes/session.php";
$pricing_id = isset($_REQUEST['pricing_id']) ? $_REQUEST['pricing_id'] : 0;
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'add';
if ($_REQUEST['submit'] == 'Submit') {
	$pricing_unit = $_REQUEST['pricing_unit'];
	$pricing_square_footage = $_REQUEST['pricing_square_footage'];
	$pricing_amount = $_REQUEST['pricing_amount'];
	$pricing_type = $_REQUEST['pricing_type'];
} else {
	$pricing_square_footage = '';
	$pricing_amount = '';
	$pricing_type = '';
	$pricing_unit = '';
}
if ($_REQUEST['submit'] == 'Submit') {
	$name_value = array('pricing_unit' => rep($pricing_unit), 'pricing_type' => $pricing_type, 'pricing_square_footage' => rep($pricing_square_footage), 'pricing_amount' => rep($pricing_amount));
	// Subscriber Add //
	if ($action == "add") {
		$pricing->pricing_add($name_value, "Pricing added successfully. Please enter another.", "Sorry, nothing is added.", "Sorry, pricing is already added. Please use another pricing.");
	}
	// Subscriber Edit //
	elseif ($action == "edit") {
		$pricing->pricing_edit($name_value, $pricing_id, "Pricing updated successfully.", "Sorry, nothing is updated.", "Sorry, pricing is already added. Please use another pricing.");
	}
}
// Show Value When Try To Update Subscriber //
elseif ($action == "edit") {
	$pricing_array = $pricing->pricing_display($db->tbl_pre . "pricing_tbl", array(), "WHERE pricing_id=" . $pricing_id . "");
}

include "includes/header.php";
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Manage Pricing
		</h1>
		<ol class="breadcrumb">
			<li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active"><?php echo $action == 'add' ? 'Add' : 'Edit'; ?> Pricing</li>
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
						<h3 class="box-title"><?php echo $action == 'add' ? 'Add' : 'Edit'; ?> Pricing</h3>
					</div><!-- /.box-header -->
					<!-- form start -->
					<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
						<input type="hidden" name="action" id="action" value="<?php echo $action; ?>" />
						<input type="hidden" name="pricing_id" id="pricing_id" value="<?php echo $pricing_id; ?>" />
						<di vclass="box-body">
							<?php echo $_SESSION['pricing_msg'];
$_SESSION['pricing_msg'] = ""; ?>
							<div class="form-group">
								<label class="col-sm-2 control-label">Pricing Type</label>
								<div class="col-sm-10">
									<select name="pricing_type" id="pricing_type" class="form-control select2" data-validation-engine="validate[required]" onchange="change_pricing_type(this.value)">
										<option value="">-- Select Type --</option>
										<option value="Single Family" <?php echo $pricing_array[0]['pricing_type'] == 'Single Family' ? 'selected="selected"' : ''; ?>>Single Family</option>
										<option value="Multi Family" <?php echo $pricing_array[0]['pricing_type'] == 'Multi Family' ? 'selected="selected"' : ''; ?>>Multi Family</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Pricing Unit</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="pricing_unit" id="pricing_unit"  data-validation-engine="validate[required]" value="<?php echo $pricing_array[0]['pricing_unit']; ?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Square Footage</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="pricing_square_footage" id="pricing_square_footage"  data-validation-engine="validate[required]" value="<?php echo $pricing_array[0]['pricing_square_footage']; ?>" <?php echo $pricing_array[0]['pricing_type'] == 'Multi Family' ? 'disabled="disabled"' : ''; ?> />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Amount</label>
								<div class="col-sm-10">
									<div class="col-sm-10 input-group">
										<span class="input-group-addon"><i class="fa fa-dollar"></i></span>
										<input type="text" class="form-control" placeholder="Enter ..." name="pricing_amount" id="pricing_amount" value="<?php echo $pricing_array[0]['pricing_amount']; ?>" data-validation-engine="validate[required,custom[number]]" />
									</div>
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