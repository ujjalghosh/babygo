<?php include 'header.php';
if( $_SESSION['customer_id']=='')  {
header('Location: '.Site_url.'');
exit();
}
$customer_array = $customer->customer_display($db->tbl_pre . "customer_tbl", array(), "WHERE customer_id=" . $_SESSION['customer_id'] . "");

 ?>

	<div class="main-con purple-bg">
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<div class="profile-pic-con">
						<div class="profile-pic"><img src="images/profile-pic.png"></div>
						<p>Welcome Mr. <?php echo $customer_array[0]["Company_name"]; ?></p>
					</div>
				</div>
				<div class="col-md-7 col-md-offset-1">
					<div class="i-box-wrap order-history">
					<?php   $order_list_array = $order->order_display($db->tbl_pre . "order_master", array(), "WHERE customer_id=" . $customer_id . "");
				if (count($order_list_array)>0) {
						
 for ($i=0; $i <count($order_list_array) ; $i++) { 
						?>
						<div class="i-box">
							<div class="row">
								<div class="ibox-row">
									<div class="col-sm-5"><label>Order Number</label></div>
									<div class="col-sm-7"><a href="order-invoice.php?order_no=<?php echo encode($order_list_array[$i]["generate_no"]); ?>"><div class="line text-yellow"> <?php echo $order_list_array[$i]["generate_no"]; ?></div></a></div>
								</div>
								<div class="ibox-row">
									<div class="col-sm-5"><label>Order Date</label></div>
									<div class="col-sm-7"><div class="line"><?php $date=date_create($order_list_array[$i]["order_Date"]); echo date_format($date,"d.m.Y"); ?></div></div>
								</div>
								<div class="ibox-row">
									<div class="col-sm-5"><label>Amount</label></div>
									<div class="col-sm-7"><div class="line"><?php echo $order_list_array[$i]["total_bill_amount"]; ?>/-</div></div>
								</div>
								<div class="ibox-row">
									<div class="col-sm-5"><label>Status</label></div>
									<div class="col-sm-7">
										<div class="line">
											<ul>
												<li><span class="opt <?php echo $order_list_array[$i]["order_status"] == 'Delivered' ? 'active' :''; ?> "></span> Completed</li>
												<li><span class="opt <?php echo $order_list_array[$i]["order_status"] == 'Ordered' ? 'active' :''; ?>"></span> Incomplete</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php } } else{ ?>
<h2> You have not placed any orders.</h2>
					<?php }  ?>							
					</div>	<!-- i-box-wrap end -->				
				</div>
			</div>
		</div>
	</div>

<?php include 'footer.php'; ?>
