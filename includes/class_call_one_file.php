<?php
$form = new Homesmiles_Form;
$pagination = new PaginationClass;
$mailsend = new PHPMailer;
 
$Product = new babygo_product();
$Product_size = new babygo_product_size();
$Product_color = new babygo_product_color();
$product_category = new babygo_product_category();
$product_group = new babygo_product_group();
$customer_category= new babygo_customer_category();
$product_details= new babygo_product_details();
$product_image= new babygo_product_image();
$order=new babygo_product_order();
$notification=new babygo_notification();
$customer = new babygo_customer();
$template = new message_template();
$purchase = new babygo_product_purchase();
?>