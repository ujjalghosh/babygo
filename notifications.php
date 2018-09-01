<?php include 'header.php';
if ($customer_id>0) {
$notification_array = $notification->notification_display($db->tbl_pre . "notification_tbl", array(), "WHERE customer_id IN(" . $customer_id . ",0) and notification_status='Active' and from_date <='".date("Y-m-d")."' AND `to_date` >= '".date("Y-m-d")."'  ");
}else{
  $notification_array = $notification->notification_display($db->tbl_pre . "notification_tbl", array(), "WHERE customer_id=" . $customer_id . " and notification_status='Active' and  from_date>=".date("Y-m-d")." AND `to_date` >= '".date("Y-m-d")."'  ");
}
 ?>

	<div class="main-con purple-bg">
		<div class="container">
			<div class="offer-wrap">
			<?php if ( count($notification_array)>0) {	
for ($i=0; $i <count($notification_array) ; $i++) {  ?>
				<div class="offer-con">
					<img src="<?php echo Site_URL;?>timthumb.php?src=<?php echo SITE_URL.'images/notification/'. $notification_array[$i]["notfication_image"]; ?>&h=203&w=152&zc=1">
					<h4><?php echo $notification_array[$i]["notfication_title"]; ?></h4>
					<p><?php echo $notification_array[$i]["notification_message"]; ?></p>
				</div>
				<?php } ?>
				<?php } else { ?>
				<div class="offer-con">				 
					 
					<p>No product found</p>
				</div>
				<?php }  ?>
			</div>
		</div>
	</div>

<?php include 'footer.php'; ?>
