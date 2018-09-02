<?php include 'header.php';
$generate_no=decode($_GET['order_no']);
$order_list_array = $order->order_display($db->tbl_pre . "order_master", array(), "WHERE generate_no='" . $generate_no . "'");
			//	if (count($order_list_array)>0) {
 ?>

	<div class="main-con purple-bg">
		<div class="container">
			<div class="row">
			<?php if (count($order_list_array)>0) { ?>
				<div class="col-md-8 col-md-offset-2">
					<div class="i-box">
						<div class="row">
							<div class="ibox-row">
								<div class="col-sm-5"><label>Order Number</label></div>
								<div class="col-sm-7"><div class="line text-yellow"><?php echo $order_list_array[0]["generate_no"]; ?></div></div>
							</div>
							<div class="ibox-row">
								<div class="col-sm-5"><label>Order Date</label></div>
								<div class="col-sm-7"><div class="line"><?php $date=date_create($order_list_array[0]["order_Date"]); echo date_format($date,"d.m.Y"); ?></div></div>
							</div>
							<div class="ibox-row">
								<div class="col-sm-5"><label>Amount</label></div>
								<div class="col-sm-7"><div class="line"><?php echo amount_format_in($order_list_array[0]["total_bill_amount"]); ?>/-</div></div>
							</div>
							<div class="ibox-row">
								<div class="col-sm-5"><label>Status</label></div>
								<div class="col-sm-7">
									<div class="line">
										<ul>
											<li><span class="opt <?php echo $order_list_array[0]["order_status"] == 'Delivered' ? 'active' :''; ?> "></span> Completed</li>
											<li><span class="opt <?php echo $order_list_array[0]["order_status"] == 'Ordered' ? 'active' :''; ?>"></span> Incomplete</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>															
				</div>
				<div class="spacer"></div>
				<?php $order_invoice= $order->order_display($db->tbl_pre . "invoice_tbl", array(), "WHERE generate_no ='" . $generate_no  . "' " );
				 if(count($order_invoice)>0){ ?>
				<div class="i-box-wrap">
				<?php for($oi=0;$oi<count($order_invoice);$oi++) { ?>
					<div class="col-md-6">					
						<div class="i-box">
							<div class="row">
								<div class="ibox-row">
									<div class="col-sm-12"><label class="text-yellow">Invoice 1</label></div>
								</div>
								<div class="ibox-row">
									<div class="col-sm-5"><label>Invoice Date</label></div>
									<div class="col-sm-7"><div class="line"><?php echo date_format($date,"d.m.Y");  ?></div></div>
								</div>
								<div class="ibox-row">
									<div class="col-sm-5"><label>Invoice Number</label></div>
									<div class="col-sm-7"><div class="line"><?php echo $order_invoice[$oi]["invoice_number"]; ?></div></div>
								</div>
								<div class="ibox-row">
									<div class="col-sm-5"><label>Shipped Through</label></div>
									<div class="col-sm-7"><div class="line"><?php echo $order_invoice[$oi]["shipped_through"]; ?></div></div>
								</div>
								<div class="ibox-row">
									<div class="col-sm-5"><label>Consignment Number</label></div>
									<div class="col-sm-7"><div class="line"><?php echo $order_invoice[$oi]["consignment_number"]; ?></div></div>
								</div>
							</div>
						</div>
					</div>
				 <?php }  ?>
 
				</div>
				<?php } } ?>
			</div>
		</div>
	</div>

<?php include 'footer.php'; ?>
