<?php include 'header.php'; 
if( $_SESSION['customer_id']=='' || $_SESSION['order_no']=='')  {
header('Location: '.Site_URL.'');
exit();
}

?>

	<div class="main-con">
		<div class="container">
			<div class="spacer"></div>
			<div class="thanks-wrap">
				<p>Thank you for your order. We will get back to you shortly</p>
				<p>Order ID:<?php echo $_SESSION['order_no']; $_SESSION['order_no']=''; ?></p>
			</div>
			<div class="spacer"></div>
		</div>
	</div>

<?php include 'footer.php'; ?>
