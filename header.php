<?php 
include "includes/settings.php";
include "includes/class_call_one_file.php";
ob_start();
if($_SESSION['customer_id']!=''){ $customer_id = $_SESSION['customer_id']; } else{$customer_id=0;}

if ($customer_id>0) {
$notification_array = $notification->notification_display($db->tbl_pre . "notification_tbl", array(), "WHERE customer_id IN(" . $customer_id . ",0) and notification_status='Active' and from_date <='".date("Y-m-d")."' AND `to_date` >= '".date("Y-m-d")."' limit 3 ");
}else{
  $notification_array = $notification->notification_display($db->tbl_pre . "notification_tbl", array(), "WHERE customer_id=" . $customer_id . " and notification_status='Active' and  from_date>=".date("Y-m-d")." AND `to_date` >= '".date("Y-m-d")."' limit 3 ");
}
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Baby Go- noveau wear for kids</title>

  <!-- Fonts -->
  <link rel="stylesheet" href="css/font-awesome.css">
  <!-- Bootstrap -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <!-- Owl Stylesheets -->
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">
  <!-- Slick Stylesheets -->
  <link rel="stylesheet" href="css/slick.css">
  <link rel="stylesheet" href="css/slick-theme.css">
  <!-- Maginific Popup -->
  <link rel="stylesheet" type="text/css" href="css/magnific-popup.min.css">
  <!-- Custom Scroll -->
  <link rel="stylesheet" type="text/css" href="css/jquery.mCustomScrollbar.css">
  <!-- Custom CSS -->
  <link href="style.css" rel="stylesheet">
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.bootpag.min.js"></script>
</head>
<body oncontextmenu="return false;">
	<header>
		<div class="container">
			<div class="logo-div text-center"><a href="<?php echo Site_URL; ?>"><img src="images/logo.png" alt="Dream Me"></a></div>
			<div class="user-name">
				<p>Welcome, <?php echo $_SESSION['customer_id']!='' ? $_SESSION['customer_name'] : 'User' ?></p>
			</div>
		</div>
	</header>

	<div class="menu-wrap shadow">
		<div class="container">
			<div class="row">				
				<div class="col-sm-7 col-sm-push-5">
					<div class="right-links">
						<ul>
							<li class="search">
								<a href="" class="search-btn visible-xs"><i class="fa fa-search" aria-hidden="true"></i></a>
								<form class="header-search" method="post" action="search.php">
									<input name="s" id="search-fld" value="" placeholder="Search" type="text">
									<input class="visible-xs" value="Search" type="submit">
								</form>
							</li>
							<li class="offer-li">
								<a href="#" data-tooltip="tooltip" data-placement="bottom" title="Notification"  class="dropdown-toggle count-info" data-toggle="dropdown"><i class="fa fa-bell" aria-hidden="true"></i></a>
								<ul class="dropdown-menu dropdown-notification">
<?php if ( count($notification_array)>0) {	
for ($i=0; $i <count($notification_array) ; $i++) {  ?>

									<li>
										<div class="offer-con <?php echo $i==1 ? 'inactive' : ''; ?>">
											<img src="<?php echo Site_URL;?>timthumb.php?src=<?php echo Site_URL.'images/notification/'. $notification_array[$i]["notfication_image"]; ?>&h=203&w=152&zc=1">
											<h4><?php echo $notification_array[$i]["notfication_title"]; ?></h4>
											<p><?php echo $notification_array[$i]["notification_message"]; ?></p>
										</div>
									</li>

							<?php } ?>

									<li class="view-all">
			                            <div class="text-center">
			                                <a href="<?php echo Site_URL.'notifications.php'; ?>">
			                                    See All Offers <i class="fa fa-angle-right"></i>
			                                </a>
			                            </div>
			                        </li>
							<?php } else { ?>
									<li>
										<div class="offer-con">		
											<p>No offer available now.</p>
										</div>
									</li>
							<?php }  ?>
									
								</ul>
							</li>
							<li><a href="<?php echo Site_URL; ?>contact.php" data-tooltip="tooltip" data-placement="bottom" title="Contact"><i class="fa fa-phone" aria-hidden="true"></i></a></li>
							
							<?php if($_SESSION['customer_id']!=''){
								echo '<li><a href="'.Site_URL.'shopping-bag.php" data-tooltip="tooltip" data-placement="bottom" title="" data-original-title="Bag"><i aria-hidden="true" class="fa fa-shopping-bag"></i></a></li> <li><a href="'.Site_URL.'account-setting.php" data-tooltip="tooltip" data-placement="bottom" title="Profile"><i class="fa fa-user" aria-hidden="true"></i></a></li>';
							echo '<li><a class="login" href="sign-out.php">Sign Out</a></li>';
							} else{
							echo '<li><a class="login" href="sign-in.php">Sign In</a></li>';
							}?>

						</ul>
					</div>
				</div>
				<div class="col-sm-5 col-sm-pull-7">
					<div class="main-menu">
						<div id="nav-icon">
						  <span></span>
						  <span></span>
						  <span></span>
						</div>
						<ul>
							<!-- <li><a href="<?php echo Site_URL; ?>product.php?category_id=3">Infants</a></li> -->
							<li><a href="<?php echo Site_URL; ?>product.php?category_id=1">Boys</a></li>
							<li><a href="<?php echo Site_URL; ?>product.php?category_id=2">Girls</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>