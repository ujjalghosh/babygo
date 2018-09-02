<?php include 'header.php';
if( $_SESSION['customer_id']=='')  {
header('Location: '.Site_url.'');
}

if (isset($_REQUEST['Submit'])) {	
 	$customer_id =$_SESSION['customer_id'];
    $customer_name = $_REQUEST['customer_name']; 
    $customer_phone_number = $_REQUEST['customer_phone_number']; 
    $Company_name = $_REQUEST['Company_name'];
    $customer_address=$_REQUEST['customer_address'];
    $shipping_address = $_REQUEST['shipping_address'];
    $vat_no = $_REQUEST['vat_no'];
    $cst_no = $_REQUEST['cst_no'];
    $pan_no=$_REQUEST['pan_no'];

    $name_value = array('customer_name' => rep($customer_name), 'customer_phone_number' => rep($customer_phone_number), 'shipping_address' => rep($shipping_address), 'Company_name' => $Company_name, 'Company_name' => rep($Company_name), 'customer_address'=>rep($customer_address),'vat_no'=>rep($vat_no),'cst_no'=>rep($cst_no),'pan_no'=>rep($pan_no));

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

								<input type="text" name="customer_phone_number" value="<?php echo $customer_array[0]["customer_phone_number"]; ?>">

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

								<input type="text" name="customer_address" value="<?php echo $customer_array[0]["customer_address"]; ?>">

							</div>

							<div class="ibox-row">

								<label class="hidden-xs">&nbsp;</label>

								<input type="text" name="">

							</div>

							<div class="ibox-row">

								<label>Shipping Address</label>

								<input type="text" name="shipping_address" value="<?php echo $customer_array[0]["shipping_address"]; ?>">

							</div>

							<div class="ibox-row">

								<label class="hidden-xs">&nbsp;</label>

								<input type="text" name="">

							</div>

							<div class="ibox-row">

								<label>GST No.</label>

								<input type="text" name="vat_no" value="<?php echo $customer_array[0]["vat_no"]; ?>">

							</div>

							<div class="ibox-row">

								<label>CST No.</label>

								<input type="text" name="cst_no" value="<?php echo $customer_array[0]["cst_no"]; ?>"> 

							</div>

							<div class="ibox-row">

								<label>PAN No.</label>

								<input type="text" name="pan_no" value="<?php echo $customer_array[0]["pan_no"]; ?>"> 

							</div>

							<div class="ibox-row">

								<input class="border-btn" type="submit" value="Submit" name="Submit">

							</div>

						</div>

						<button class="border-btn fill" type="button" name="">Sign Out</button>

						</form>

					</div>	<!-- i-box-wrap end -->				

				</div>

			</div>

		</div>

	</div>



<?php include 'footer.php'; ?>

