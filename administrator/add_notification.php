<?php
include "includes/session.php";
$notification_id = isset($_REQUEST['notification_id']) ? $_REQUEST['notification_id'] : 0;
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'add';
if ($_REQUEST['submit'] == 'Submit') {
	
	 $from_date =  date('Y-m-d',strtotime($_REQUEST['from_date']));
	 $to_date =   date('Y-m-d',strtotime($_REQUEST['to_date']));

	$notfication_title = $_REQUEST['notfication_title'];
	$notification_message = $_REQUEST['notification_message'];
	$notfication_image=$_REQUEST['notfication_image'];
	$customer_id = $_REQUEST['customer_id'];
} else {
	$from_date = '';
	$to_date = '';
	$notfication_title = '';
	$notification_message = '';
	$customer_id='';
	$notfication_image='';
}
if ($_REQUEST['submit'] == 'Submit') {
	$name_value = array('from_date' => rep($from_date),'customer_id'=>rep($customer_id), 'to_date' => rep($to_date), 'notfication_title' => rep($notfication_title) , 'notification_message' => rep($notification_message) );
	// customer Add //
	if ($action == "add") {
		$notification->notification_add($name_value, "Notification added successfully. Please enter another.", "Sorry, nothing is added.", "Sorry, Notification is already added. Please use another Notification.");
	}
	// customer Edit //
	elseif ($action == "edit") {
		$notification->notification_edit($name_value, $notification_id, "Notification updated successfully.", "Sorry, nothing is updated.", "Sorry, Notification  is already added. Please use another Notification.");
	}
}
// Show Value When Try To Update customer //
elseif ($action == "edit") {
	$notification_array = $notification->notification_display($db->tbl_pre . "notification_tbl", array(), "WHERE notification_id=" . $notification_id . "");
}

include "includes/header.php";
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Manage Notification
		</h1>
		<ol class="breadcrumb">
			<li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active"><?php echo $action == 'add' ? 'Add' : 'Edit'; ?> Notification</li>
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
						<h3 class="box-title"><?php echo $action == 'add' ? 'Add' : 'Edit'; ?> customer</h3>
					</div><!-- /.box-header -->
					<!-- form start -->
					<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
						<input type="hidden" name="action" id="action" value="<?php echo $action; ?>" />
						<input type="hidden" name="notification_id" id="notification_id" value="<?php echo $notification_id; ?>" />
						<div class="box-body">
							<?php echo $_SESSION['notification_msg'];
$_SESSION['notification_msg'] = ""; ?>

							<div class="form-group">
								<label class="col-sm-2 control-label">Starting Date</label>
								<div class="col-sm-10" >
									<input type="text"  class="form-control datepicker" placeholder="Enter ..." name="from_date" id="from_date"  data-validation-engine="validate[required]" value="<?php  echo $action == 'edit' ? date('d-m-Y',strtotime($notification_array[0]['from_date'])) : date('d-m-Y');  ?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">End Date</label>
								<div class="col-sm-10" >
									<input type="text"  class="form-control datepicker" placeholder="Enter ..." name="to_date" id="to_date"  data-validation-engine="validate[required]" value="<?php echo  $action == 'edit' ? date('d-m-Y',strtotime($notification_array[0]['to_date'])): date('d-m-Y');  ?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Notification Title</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="notfication_title" id="notfication_title"  data-validation-engine="validate[required]" value="<?php echo repc($notification_array[0]['notfication_title']); ?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Customer</label>
								<div class="col-sm-10">
									<select name="customer_id" id="customer_id" class="form-control select2"   >
<?php
$customer_array = $customer->customer_display($db->tbl_pre . "customer_tbl", array(), "WHERE customer_status='Active'");
 
 ?>									
				 <option value="">-- Select Customer (If required) --</option>
						<?php  for($l=0; $l<count($customer_array); $l++) {    ?>
	<option value="<?php echo $customer_array[$l]["customer_id"]; ?>" <?php echo $customer_array[$l]['customer_id'] == $notification_array[0]['customer_id'] ? 'selected' : ''; ?>><?php echo $customer_array[$l]["customer_name"]; ?></option>
	<?php } ?>										  
					</select>



								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label">Notification essage</label>
								<div class="col-sm-10">
									<textarea class="form-control " placeholder="Enter ..." name="notification_message" id="notification_message"><?php echo repc($notification_array[0]['notification_message']); ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Notification Image</label>
								<div class="col-sm-10">
								<?php if (($action == 'edit') && !empty($notification_array[0]['notfication_image'])) {  ?>

					<img src="<?php echo SITE_URL ?>images/notification/<?php echo repc($notification_array[0]['notfication_image']); ?>" height="130" width="150">
					<?php } ?>

					<input type="file" name="notfication_image">						

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