<?php
$page_name = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title><?php echo Site_Title; ?> | Administrator</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.4 -->
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <!-- Font Awesome Icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
  <!-- Ionicons -->
  <link href="dist/css/ionicons.min.css" rel="stylesheet" type="text/css" />
  <!-- jvectormap -->
  <link href="plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
  <!-- Theme style -->
  <!-- Select2 -->
  <link href="plugins/select2/select2.min.css" rel="stylesheet" type="text/css" />
  <!-- DATA TABLES -->
  <link href="plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
  <link href="dist/css/jquery.filer.css" type="text/css" rel="stylesheet" />
  <link href="dist/css/themes/jquery.filer-dragdropbox-theme.css" type="text/css" rel="stylesheet" />
  <!-- Bootstrap Date Picker -->
  <link href="plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
  <link href="jquery.alerts.css" rel="stylesheet" type="text/css" />
  <link href="plugins/timepicker/bootstrap-timepicker.css" rel="stylesheet" type="text/css" />
  <!-- iCheck -->
  <link href="plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
  <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins
    folder instead of downloading all of them to reduce the load. -->
    <link href="dist/css/skins/skin-black.css" rel="stylesheet" type="text/css" />
    <!-- Validation CSS -->
    <link href="dist/css/validationEngine.jquery.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="dist/js/html5shiv.min.js"></script>
        <script src="dist/js/respond.min.js"></script>
        <![endif]-->
        <link href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="dist/css/jquery-ui.css">
        <link href="assets/css/email-editor.bundle.min.css" rel="stylesheet" />
        <link href="assets/css/colorpicker.css" rel="stylesheet" />
      </head>
      <body class="skin-black sidebar-mini">
       <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

         <!-- Modal content-->
         <div class="modal-content">
          <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal">&times;</button>
           <h4 class="modal-title">Send Message</h4>
         </div>
         <div class="modal-body">
           <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" id="action" value="msgsubmt" />
            <input type="hidden" name="user_id" id="user_id" />
            <div class="box-body">
             <div class="form-group">
              <label class="col-sm-2 control-label">Message</label>
              <div class="col-sm-10">
               <textarea class="form-control" placeholder="Enter ..." name="user_message" id="user_message"  data-validation-engine="validate[required]"></textarea>
             </div>
           </div>
         </div><!-- /.box-body -->
         <div class="box-footer">
           <button type="submit" class="btn btn-primary" name="submit" value="Submit">Submit</button>
         </div>
       </form>
     </div>
     <div class="modal-footer">
       <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
     </div>
   </div>

 </div>
</div>
<div class="wrapper">

  <header class="main-header">

   <!-- Logo -->
   <a href="index.php" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><img src="<?php echo SITE_URL; ?>administrator/timthumb.php?src=<?php echo SITE_URL; ?><?php echo Site_Logo; ?>&w=40&h=40&zc=3"></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><img src="<?php echo SITE_URL; ?>administrator/timthumb.php?src=<?php echo SITE_URL; ?><?php echo Site_Logo; ?>&w=140&h=118&zc=3"></span>
  </a>

  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
     <span class="sr-only">Toggle navigation</span>
   </a>
 </nav>
</header>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
 <!-- sidebar: style can be found in sidebar.less -->
 <section class="sidebar">
  <!-- sidebar menu: : style can be found in sidebar.less -->
  <ul class="sidebar-menu">
   <li class="header">MAIN NAVIGATION</li>
   <li class="treeview <?php echo $page_name == 'index.php' ? 'active' : ''; ?>">
    <a href="#">
     <i class="fa fa-dashboard"></i> <span>Dashboard</span> <i class="fa fa-angle-left pull-right"></i>
   </a>
   <ul class="treeview-menu">
     <li class="<?php echo $page_name == 'index.php' ? 'active' : ''; ?>"><a href="index.php"><i class="fa fa-circle-o"></i> Dashboard</a></li>
   </ul>
 </li>
 <li class="treeview <?php echo   $page_name == 'add_product_size.php' || $page_name == 'manage_product_size.php' || $page_name == 'add_product_color.php' || $page_name == 'manage_product_color.php' || $page_name == 'add_product_category.php' || $page_name == 'manage_product_category.php' || $page_name == 'add_product_group.php' || $page_name == 'manage_product_group.php' ? 'active' : ''; ?>">
  <a href="#">
    <i class="fa fa-location-arrow"></i>
    <span>Product Supporting Module</span>
    <i class="fa fa-angle-left pull-right"></i>
  </a>
  <ul class="treeview-menu">

    <li class="<?php echo $page_name == 'add_product_group.php' ? 'active' : ''; ?>"><a href="add_product_group.php"><i class="fa fa-circle-o"></i> Add Product Group</a></li>
    <li class="<?php echo $page_name == 'manage_product_group.php' ? 'active' : ''; ?>"><a href="manage_product_group.php"><i class="fa fa-circle-o"></i> Manage Product Group</a></li> 
    <li class="<?php echo $page_name == 'add_product_color.php' ? 'active' : ''; ?>"><a href="add_product_color.php"><i class="fa fa-circle-o"></i> Add Product Colour</a></li>
    <li class="<?php echo $page_name == 'manage_product_color.php' ? 'active' : ''; ?>"><a href="manage_product_color.php"><i class="fa fa-circle-o"></i> Manage Product Colour</a></li>
    <!-- ***** -->
    <li class="<?php echo $page_name == 'add_product_size.php' ? 'active' : ''; ?>"><a href="add_product_size.php"><i class="fa fa-circle-o"></i> Add Product Size</a></li>
    <li class="<?php echo $page_name == 'manage_product_size.php' ? 'active' : ''; ?>"><a href="manage_product_size.php"><i class="fa fa-circle-o"></i> Manage Product Size</a></li>

   <li class="<?php echo $page_name == 'add_product_category.php' ? 'active' : ''; ?>"><a href="add_product_category.php"><i class="fa fa-circle-o"></i> Add Product Category</a></li>
    <li class="<?php echo $page_name == 'manage_product_category.php' ? 'active' : ''; ?>"><a href="manage_product_category.php"><i class="fa fa-circle-o"></i> Manage Product Category</a></li>

  </ul>
</li> 


 <li class="treeview <?php echo $page_name == 'manage_product_stock.php' || $page_name == 'add_product.php' || $page_name == 'add_product_stock.php' || $page_name == 'manage_product.php' || $page_name == 'add_product_image.php' || $page_name == 'manage_product_image.php' || $page_name == 'import_product_csv.php'  ? 'active' : ''; ?>">
  <a href="#">
   <i class="fa fa-location-arrow"></i>
   <span>Product Module</span>
   <i class="fa fa-angle-left pull-right"></i>
 </a>
 <ul class="treeview-menu">
   <li class="<?php echo $page_name == 'add_product.php' ? 'active' : ''; ?>"><a href="add_product.php"><i class="fa fa-circle-o"></i> Add Product</a></li>
    <li class="<?php echo $page_name == 'manage_product.php' ? 'active' : ''; ?>"><a href="manage_product.php"><i class="fa fa-circle-o"></i> Manage Product</a></li>
 
 
 <li class="<?php echo $page_name == 'add_product_stock.php' ? 'active' : ''; ?>"><a href="add_product_stock.php"><i class="fa fa-circle-o"></i>Add product stock</a></li>

 <li class="<?php echo $page_name == 'manage_product_stock.php' ? 'active' : ''; ?>"><a href="manage_product_stock.php"><i class="fa fa-circle-o"></i> Manage product stock </a></li>
 </ul>
  
</li>


 <li class="treeview <?php echo $page_name == 'manage_order.php' || $page_name == 'add_order.php' ? 'active' : ''; ?>">
  <a href="#">
   <i class="fa fa-location-arrow"></i>
   <span>Order Module</span>
   <i class="fa fa-angle-left pull-right"></i>
 </a>
 <ul class="treeview-menu">
   <!-- <li class="<?php echo $page_name == 'order.php' ? 'active' : ''; ?>"><a href="order.php"><i class="fa fa-circle-o"></i> Add Customer</a></li> -->
   <!-- <li class="<?php echo $page_name == 'manage_order.php' ? 'active' : ''; ?>"><a href="manage_order.php"><i class="fa fa-circle-o"></i> Manage Order</a></li> -->
 </ul>
  
</li>

 <li class="treeview <?php echo $page_name == 'manage_invoice.php' || $page_name == 'add_invoice.php' ? 'active' : ''; ?>">
  <a href="#">
   <i class="fa fa-location-arrow"></i>
   <span>Ordrer's Invoice </span>
   <i class="fa fa-angle-left pull-right"></i>
 </a>
 <ul class="treeview-menu">
   <li class="<?php echo $page_name == 'add_invoice.php' ? 'active' : ''; ?>"><a href="add_invoice.php"><i class="fa fa-circle-o"></i> Add Invoice</a></li>
  <!--  <li class="<?php echo $page_name == 'manage_invoice.php' ? 'active' : ''; ?>"><a href="manage_invoice.php"><i class="fa fa-circle-o"></i> Manage Invoice</a></li> -->
 </ul>
  
</li>


 <li class="treeview <?php echo $page_name == 'manage_customer.php' || $page_name == 'add_customer.php' ? 'active' : ''; ?>">
  <a href="#">
   <i class="fa fa-location-arrow"></i>
   <span>Customer Module</span>
   <i class="fa fa-angle-left pull-right"></i>
 </a>
 <ul class="treeview-menu">
   <li class="<?php echo $page_name == 'add_customer.php' ? 'active' : ''; ?>"><a href="add_customer.php"><i class="fa fa-circle-o"></i> Add Customer</a></li>
   <li class="<?php echo $page_name == 'manage_customer.php' ? 'active' : ''; ?>"><a href="manage_customer.php"><i class="fa fa-circle-o"></i> Manage Customer</a></li>
 </ul>
  
</li>

 <li class="treeview <?php echo $page_name == 'manage_customer_category.php' || $page_name == 'add_customer_category.php' ? 'active' : ''; ?>">
  <a href="#">
   <i class="fa fa-location-arrow"></i>
   <span>Customer Category Module</span>
   <i class="fa fa-angle-left pull-right"></i>
 </a>
<ul class="treeview-menu">
   <li class="<?php echo $page_name == 'add_customer_category.php' ? 'active' : ''; ?>"><a href="add_customer_category.php"><i class="fa fa-circle-o"></i> Add Customer Category</a></li>
   <li class="<?php echo $page_name == 'manage_customer_category.php' ? 'active' : ''; ?>"><a href="manage_customer_category.php"><i class="fa fa-circle-o"></i> Manage Customer Category</a></li>
 </ul>
  
</li>
 
<li class="treeview <?php echo $page_name == 'manage_notification.php' || $page_name == 'add_notification.php' ? 'active' : ''; ?>">
  <a href="#">
   <i class="fa fa-location-arrow"></i>
   <span>Notification Module</span>
   <i class="fa fa-angle-left pull-right"></i>
 </a>
<ul class="treeview-menu">
   <li class="<?php echo $page_name == 'add_notification.php' ? 'active' : ''; ?>"><a href="add_notification.php"><i class="fa fa-circle-o"></i> Add Notification</a></li>
   <li class="<?php echo $page_name == 'manage_notification.php' ? 'active' : ''; ?>"><a href="manage_notification.php"><i class="fa fa-circle-o"></i> Manage Notification</a></li>
 </ul>
  
</li>


 
 
<li class="treeview <?php echo $page_name == 'general_settings.php' || $page_name == 'change_username.php' || $page_name == 'change_password.php' ? 'active' : ''; ?>">
  <a href="#">
   <i class="fa fa-share"></i> <span>Admin Settings Module</span>
   <i class="fa fa-angle-left pull-right"></i>
 </a>
 <ul class="treeview-menu">
   <?php if ($_SESSION['admin_id'] == 1) {?>
   <li class="<?php echo $page_name == 'general_settings.php' ? 'active' : ''; ?>"><a href="general_settings.php"><i class="fa fa-circle-o"></i> Manage Settings</a></li>
   <li class="<?php echo $page_name == 'change_username.php' || $page_name == 'change_password.php' ? 'active' : ''; ?>">
    <a href="#"><i class="fa fa-circle-o"></i> Admin Login <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu <?php echo $page_name == 'change_username.php' || $page_name == 'change_password.php' ? 'menu-open' : ''; ?>">
     <li class="<?php echo $page_name == 'change_username.php' ? 'active' : ''; ?>"><a href="change_username.php"><i class="fa fa-circle-o"></i> Change Username</a></li>
     <li class="<?php echo $page_name == 'change_password.php' ? 'active' : ''; ?>"><a href="change_password.php"><i class="fa fa-circle-o"></i> Change Password </a></li>
   </ul>
 </li>
 <?php }?>
 <li><a href="logout.php"><i class="fa fa-circle-o"></i> Logout</a></li>
</ul>
</li>
</ul>
</section>
<!-- /.sidebar -->
</aside>