<?php 
include("includes/settings.php");
include("includes/class_call_one_file.php");
check_login();
$user_array=$user->user_display($db->tbl_pre."user_tbl",array(),"where user_email='".$_SESSION['user_email_address']."'");
$order_array=$order->order_display($db->tbl_pre."order_tbl",array(),"where user_id='".$user_array[0]['user_id']."' and order_status='Pending'");
$order_id=$order_array[0]['order_id'];
$order_details_image_array=$order->order_display($db->tbl_pre."order_image_tbl",array(),"where order_id='".$order_id."'");
$order_details_video_array=$order->order_display($db->tbl_pre."order_video_tbl",array(),"where order_id='".$order_id."'");
$order_details_album_array=$order->order_display($db->tbl_pre."order_album_tbl",array(),"where order_id='".$order_id."'");
$total_cart_item=count($order_details_image_array)+count($order_details_video_array)+count($order_details_album_array);
?>