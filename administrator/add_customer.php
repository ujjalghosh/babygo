<?php
include "includes/session.php";
$customer_id = isset($_REQUEST['customer_id']) ? $_REQUEST['customer_id'] : 0;
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'add';
if ($_REQUEST['submit'] == 'Submit') {
	$customer_name = $_REQUEST['customer_name'];
	$customer_email = $_REQUEST['customer_email'];
	$customer_phone_number = $_REQUEST['customer_phone_number'];
	$customer_password = $_REQUEST['customer_password'];
	$Company_name = $_REQUEST['Company_name'];
	$customer_address=$_REQUEST['customer_address'];
	$category_id = $_REQUEST['category_id'];   
    
    $customer_telephone=$_REQUEST['customer_telephone'];
    $customer_city=$_REQUEST['customer_city'];
    $customer_state=$_REQUEST['customer_state'];
    $customer_pin=$_REQUEST['customer_pin'];
    $shipping_address=$_REQUEST['shipping_address'];
    $shipping_city=$_REQUEST['shipping_city'];
    $shipping_state=$_REQUEST['shipping_state'];
    $shipping_pin=$_REQUEST['shipping_pin'];
    $gst_no=$_REQUEST['gst_no'];
    $pan_no=$_REQUEST['pan_no'];

} else {
	$customer_name = '';
	$customer_email = '';
	$customer_phone_number = '';
	$customer_password = '';
	$Company_name = '';
	$category_id='';
	$customer_address='';
}
if ($_REQUEST['submit'] == 'Submit') {
	$name_value = array('customer_name' => rep($customer_name),'customer_category'=>rep($category_id), 'customer_email' => rep($customer_email), 'customer_phone_number' => rep($customer_phone_number), 'customer_password' => encode($customer_password), 'Company_name' => rep($Company_name),'gst_no' => rep($gst_no), 'customer_address'=>rep($customer_address),'customer_telephone'=>rep($customer_telephone),'customer_city'=>rep($customer_city),'customer_state'=>rep($customer_state),'customer_pin'=>rep($customer_pin),'shipping_address'=>rep($shipping_address),'shipping_city'=>rep($shipping_city),'shipping_state'=>rep($shipping_state),'shipping_pin'=>rep($shipping_pin),'pan_no'=>rep($pan_no));
	// customer Add //
	if ($action == "add") {
		$customer->customer_add($name_value, "customer added successfully. Please enter another.", "Sorry, nothing is added.", "Sorry, email id is already added. Please use another email id.");
	}
	// customer Edit //
	elseif ($action == "edit") {
		$customer->customer_edit($name_value, $customer_id, "customer updated successfully.", "Sorry, nothing is updated.", "Sorry, email id is already added. Please use another email id.");
	}
}
// Show Value When Try To Update customer //
elseif ($action == "edit") {
	$customer_array = $customer->customer_display($db->tbl_pre . "customer_tbl", array(), "WHERE customer_id=" . $customer_id . "");
}

include "includes/header.php";
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Manage customer
		</h1>
		<ol class="breadcrumb">
			<li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active"><?php echo $action == 'add' ? 'Add' : 'Edit'; ?> customer</li>
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
						<input type="hidden" name="customer_id" id="customer_id" value="<?php echo $customer_id; ?>" />
						<div class="box-body">
							<?php echo $_SESSION['customer_msg']; $_SESSION['customer_msg'] = ""; ?>

							<div class="form-group">
								<label class="col-sm-2 control-label">Name</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="customer_name" id="customer_name"  data-validation-engine="validate[required]" value="<?php echo repc($customer_array[0]['customer_name']); ?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Email Address</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="customer_email" id="customer_email"  data-validation-engine="validate[required,custom[email]]" value="<?php echo repc($customer_array[0]['customer_email']); ?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Phone Number</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="customer_phone_number" id="customer_phone_number"  data-validation-engine="validate[required]" value="<?php echo repc($customer_array[0]['customer_phone_number']); ?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Discount Category</label>
								<div class="col-sm-10">
									<select name="category_id" id="category_id" class="form-control select2" data-validation-engine="validate[required]"  >
<?php
$customer_category_array = $customer_category->customer_category_display($db->tbl_pre . "customer_category_tbl", array(), "WHERE category_status='Active'");
 
 ?>									
				 <option value="">-- Select Category --</option>
						<?php  for($l=0; $l<count($customer_category_array); $l++) {    ?>
	<option value="<?php echo $customer_category_array[$l]["category_id"]; ?>" <?php echo $customer_category_array[$l]['category_id'] == $customer_array[0]['customer_category'] ? 'selected' : ''; ?>><?php echo $customer_category_array[$l]["category_name"]; ?></option>
	<?php } ?>										  
					</select>



								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Password</label>
								<div class="col-sm-10">
									<input type="password" class="form-control" placeholder="Enter ..." name="customer_password" id="customer_password" data-validation-engine="validate[required]" value="<?php echo decode($customer_array[0]['customer_password']); ?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Confirm Password</label>
								<div class="col-sm-10">
									<input type="password" class="form-control" placeholder="Enter ..." name="customer_confirm_password" id="customer_confirm_password"  data-validation-engine="validate[required,equals[customer_password]]" value="<?php echo decode($customer_array[0]['customer_password']); ?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Company Name</label>
								<div class="col-sm-10">
									<textarea class="form-control " placeholder="Enter ..." name="Company_name" id="Company_name"><?php echo repc($customer_array[0]['Company_name']); ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Address</label>
								<div class="col-sm-10">
					<textarea class="form-control " placeholder="Enter ..." name="customer_address" id="customer_address"><?php echo repc($customer_array[0]['customer_address']); ?></textarea>							</div>
							</div> 
 
 

							<div class="form-group">
								<label class="col-sm-2 control-label">Telephone</label>
								<div class="col-sm-10">
						<input type="text" class="form-control" placeholder="Enter ..." name="customer_telephone" id="customer_telephone"   value="<?php echo repc($customer_array[0]['customer_telephone']); ?>" />  
									 
								</div>
							</div>

							 <div class="form-group">
								<label class="col-sm-2 control-label">City</label>
								<div class="col-sm-10">
						<input type="text" class="form-control" placeholder="Enter ..." name="customer_city" id="customer_city"   value="<?php echo repc($customer_array[0]['customer_city']); ?>" /> 									 
								</div>
							</div>

							  <div class="form-group">
								<label class="col-sm-2 control-label">State</label>
								<div class="col-sm-10">
					 <select name="customer_state" id="customer_state" class="form-control select2" data-validation-engine="validate[required]" >
                    <option value="">-- Select State --</option>
<?php $state_array = $customer->customer_display($db->tbl_pre . "state_list_tbl", array(), ""); 
for ($i=0; $i <count($state_array) ; $i++) { ?>

<option value="<?php echo $state_array[$i]['Code']; ?>" <?php echo $customer_array[0]["customer_state"] == $state_array[$i]['Code'] ? 'selected="selected"' : ''; ?> > <?php echo $state_array[$i]['Subdivision_name']; ?> </option>  

<?php } ?>
                 
 </select>
						 									 
								</div>
							</div>

							  <div class="form-group">
								<label class="col-sm-2 control-label">PIN</label>
								<div class="col-sm-10">
						<input type="text" class="form-control" placeholder="Enter ..." name="customer_pin" id="customer_pin"   value="<?php echo repc($customer_array[0]['customer_pin']); ?>" /> 									 
								</div>
							</div>

							     
 

							<ADDRESS> Shipping Address</ADDRESS>

							 <div class="form-group">
								<label class="col-sm-2 control-label">Shipping Address</label>
								<div class="col-sm-10">
						  	
								<textarea name="shipping_address" id="shipping_address" ><?php echo repc($customer_array[0]['shipping_address']); ?></textarea>

								</div>
							</div>

							 <div class="form-group">
								<label class="col-sm-2 control-label">Shipping City</label>
								<div class="col-sm-10">
						<input type="text" class="form-control" placeholder="Enter ..." name="shipping_city" id="shipping_city"   value="<?php echo repc($customer_array[0]['shipping_city']); ?>" />  							 
								</div>
							</div>

								 <div class="form-group">
								<label class="col-sm-2 control-label">Shipping State</label>
								<div class="col-sm-10">
					 <select name="shipping_state" id="shipping_state" class="form-control select2" data-validation-engine="validate[required]" >
                    <option value="">-- Select State --</option>
<?php $state_array = $customer->customer_display($db->tbl_pre . "state_list_tbl", array(), ""); 
for ($i=0; $i <count($state_array) ; $i++) { ?>

<option value="<?php echo $state_array[$i]['Code']; ?>" <?php echo $customer_array[0]["shipping_state"] == $state_array[$i]['Code'] ? 'selected="selected"' : ''; ?> > <?php echo $state_array[$i]['Subdivision_name']; ?> </option>  

<?php } ?>
                 
 </select>

						   							 
								</div>
							</div>

												 <div class="form-group">
								<label class="col-sm-2 control-label">Shipping PIN</label>
								<div class="col-sm-10">
						<input type="text" class="form-control" placeholder="Enter ..." name="shipping_pin" id="shipping_pin"   value="<?php echo repc($customer_array[0]['shipping_pin']); ?>" />  							 
								</div>
							</div>
							 
							 <div class="form-group">
								<label class="col-sm-2 control-label">GST NO</label>
								<div class="col-sm-10">
						<input type="text" class="form-control" placeholder="Enter ..." name="gst_no" id="gst_no"   value="<?php echo repc($customer_array[0]['gst_no']); ?>" />  
									 
								</div>
							</div>

							 <div class="form-group">
								<label class="col-sm-2 control-label">PAN NO</label>
								<div class="col-sm-10">
						<input type="text" class="form-control" placeholder="Enter ..." name="pan_no" id="pan_no"   value="<?php echo repc($customer_array[0]['pan_no']); ?>" />  
									 
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