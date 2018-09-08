<?php include 'header.php';
if( $_SESSION['customer_id']=='')  {
header('Location: '.Site_url.'');
}

if (isset($_REQUEST['Submit'])) {	
 	$customer_id =$_SESSION['customer_id'];
    $customer_name = $_REQUEST['customer_name'];
    $customer_email = $_REQUEST['customer_email'];
    $customer_phone_number = $_REQUEST['customer_phone_number'];
    $Company_name = $_REQUEST['Company_name'];
    $customer_address=$_REQUEST['customer_address'];
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

  // $name_value = array('customer_name' => rep($customer_name), 'customer_phone_number' => rep($customer_phone_number), 'shipping_address' => rep($shipping_address), 'Company_name' => $Company_name, 'Company_name' => rep($Company_name), 'customer_address'=>rep($customer_address),'vat_no'=>rep($vat_no),'cst_no'=>rep($cst_no),'pan_no'=>rep($pan_no));

    $name_value = array('customer_name' => rep($customer_name), 'customer_email' => rep($customer_email), 'customer_phone_number' => rep($customer_phone_number), 'Company_name' => rep($Company_name), 'customer_address'=>rep($customer_address), 'customer_telephone'=>rep($customer_telephone), 'customer_city'=>rep($customer_city), 'customer_state'=>rep($customer_state), 'customer_pin'=>rep($customer_pin), 'shipping_address'=>rep($shipping_address), 'shipping_city'=>rep($shipping_city), 'shipping_state'=>rep($shipping_state), 'shipping_pin'=>rep($shipping_pin), 'gst_no'=>rep($gst_no), 'pan_no'=>rep($pan_no));

$customer->customer_edit($name_value, $customer_id, "Your profile updated successfully.", "Sorry, nothing is updated.", "Sorry, email id is already added. Please use another email id.");
}

$customer_array = $customer->customer_display($db->tbl_pre . "customer_tbl", array(), "WHERE customer_id=" . $_SESSION['customer_id'] . "");

 ?>



	<div class="main-con purple-bg">

		<div class="container">

			<div class="row">

				<div class="col-md-4">

					<div class="profile-pic-con">

						<div class="profile-pic"><img src="images/profile-pic.png"></div>

						<p>Welcome Mr. <?php echo $customer_array[0]["customer_name"];?></p>

					</div>

				</div>

				<div class="col-md-7 col-md-offset-1">

					<div class="i-box-wrap prof-edit">
				<?php echo $_SESSION['customer_msg']; $_SESSION['customer_msg'] = ""; ?>
						<form action="" method="post">
			<input type="hidden" name="customer_id" value="<?php echo $_SESSION['customer_id']; ?>">
						<div class="i-box">

							<div class="ibox-row">

								<label>Company Number</label>

								<input type="text" name="Company_name" value="<?php echo $customer_array[0]["Company_name"]; ?>">

							</div>

							<div class="ibox-row">

								<label>Name</label>

								<input type="text" name="customer_name" value="<?php echo $customer_array[0]["customer_name"]; ?>">

							</div>

							<div class="ibox-row half">

								<label>Telephone</label>

								<input type="text" name="customer_telephone" value="<?php echo $customer_array[0]["customer_telephone"]; ?>">

							</div>

							<div class="ibox-row half mob">

								<label>Mobile</label>

								<input type="text" name="customer_phone_number" value="<?php echo $customer_array[0]["customer_phone_number"]; ?>">

							</div>

							<div class="ibox-row">

								<label>Email</label>

								<input type="email" name="customer_email" readonly="true" value="<?php echo $customer_array[0]["customer_email"]; ?>">

							</div>

							<div class="ibox-row">

								<label>Billing Address</label>

								<textarea name="customer_address" class="notes"><?php echo $customer_array[0]["customer_address"]; ?></textarea>

								<!-- <input type="text" name="customer_address" value="<?php echo $customer_array[0]["customer_address"]; ?>"> -->

							</div>

							<div class="ibox-row"> 
							<label>City</label> 
							<input type="text" name="customer_city" value="<?php echo $customer_array[0]["customer_city"]; ?>"> 
						    </div>

							 <div class="ibox-row">

								<label>State</label> 
								 

  <select name="customer_state" id="customer_state" class="form-control select2" data-validation-engine="validate[required]" >
                    <option value="">-- Select State --</option>
<?php $state_array = $customer->customer_display($db->tbl_pre . "state_list_tbl", array(), ""); 
for ($i=0; $i <count($state_array) ; $i++) { ?>

<option value="<?php echo $state_array[$i]['Code']; ?>" <?php echo $customer_array[0]["customer_state"] == $state_array[$i]['Code'] ? 'selected="selected"' : ''; ?> > <?php echo $state_array[$i]['Subdivision_name']; ?> </option>  

<?php } ?>
                 
 </select>

							</div>
														 <div class="ibox-row">

								<label>PIN</label>

								<input type="text" name="customer_pin" value="<?php echo $customer_array[0]["customer_pin"]; ?>">

							</div>

					<!-- 		<div class="ibox-row">
					
						<label class="hidden-xs">&nbsp;</label>
					
						<input type="text" name="">
					
					</div> -->

							<div class="ibox-row">

								<label>Shipping Address</label>

								<textarea name="shipping_address" class="notes"><?php echo $customer_array[0]["shipping_address"]; ?></textarea>

								<!-- <input type="text" name="shipping_address" value="<?php echo $customer_array[0]["shipping_address"]; ?>"> -->

							</div>

		

							<div class="ibox-row"> 
							<label>City</label> 
							<input type="text" name="shipping_city" value="<?php echo $customer_array[0]["shipping_city"]; ?>"> 
						    </div>

							 <div class="ibox-row">

								<label>State</label> 

							 <select name="shipping_state" id="shipping_state" class="form-control select2" data-validation-engine="validate[required]" >
                    <option value="">-- Select State --</option>
<?php $state_array = $customer->customer_display($db->tbl_pre . "state_list_tbl", array(), ""); 
for ($i=0; $i <count($state_array) ; $i++) { ?>

<option value="<?php echo $state_array[$i]['Code']; ?>" <?php echo $customer_array[0]["shipping_state"] == $state_array[$i]['Code'] ? 'selected="selected"' : ''; ?> > <?php echo $state_array[$i]['Subdivision_name']; ?> </option>  

<?php } ?>
                 
 </select>

							</div>
														 <div class="ibox-row">

								<label>PIN</label>

								<input type="text" name="shipping_pin" value="<?php echo $customer_array[0]["shipping_pin"]; ?>">

							</div>

							<div class="ibox-row">

								<label>GST No.</label>

								<input type="text" name="gst_no" value="<?php echo $customer_array[0]["gst_no"]; ?>">

							</div>

<!-- 							<div class="ibox-row">

	<label>CST No.</label>

	<input type="text" name="cst_no" value="<?php echo $customer_array[0]["cst_no"]; ?>"> 

</div> -->

							<div class="ibox-row">

								<label>PAN No.</label>

								<input type="text" name="pan_no" value="<?php echo $customer_array[0]["pan_no"]; ?>"> 

							</div>

							<div class="ibox-row">

								<input class="border-btn" type="submit" value="Submit" name="Submit">

							</div>

						</div>

						<button class="border-btn fill" type="button" name="" onclick="window.location.href='<?php echo Site_URL; ?>sign-out.php'">Sign Out</button>

						</form>

					</div>	<!-- i-box-wrap end -->				

				</div>

			</div>

		</div>

	</div>



<?php include 'footer.php'; ?>

