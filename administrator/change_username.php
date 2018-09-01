<?php
include ("includes/session.php");
$return_url = (isset($_REQUEST['return_url']) && $_REQUEST['return_url'] != "") ? $_REQUEST['return_url'] : "login.php";
if (isset($_REQUEST['submit'])) {
	$old_username = $_REQUEST['old_username'];
	$sql = $db -> query("select * from ".$db->tbl_pre."administrator_tbl where administrator_username='" . $old_username . "'");
	$num = $db -> total($sql);
	if ($num == 0) {
		$_SESSION['admin_msg'] = messagedisplay("Sorry, Your Old username does not match!", 2);
		header('Location: ' . basename(__FILE__));
		exit();
	} else {
		$sql1 = $db -> update("administrator_tbl", array('administrator_username' => ($_REQUEST['new_username'])), "administrator_id=1");
		$_SESSION['admin_msg'] = messagedisplay("Username has been successfully changed.", 1);
		header('location: ' . $return_url);
		exit();
	}
}
include ("includes/header.php");
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Manage User Name
		</h1>
		<ol class="breadcrumb">
			<li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Manage User Name</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<!-- left column -->
			<div class="col-md-12">
				<!-- general form elements -->
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Edit User Name</h3>
					</div><!-- /.box-header -->
					<!-- form start -->
					<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
						<input type="hidden" name="action" id="action" value="<?php echo $action; ?>" />
						<div class="box-body">
							<?php echo $_SESSION['admin_msg'];
							$_SESSION['admin_msg'] = ""; ?>
							<div class="form-group">
								<label class="col-sm-2 control-label">Old User Name</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="old_username" id="old_username" data-validation-engine="validate[required]" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">New User Name</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="new_username" id="new_username" data-validation-engine="validate[required]" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Retype New user Name</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="retype_new_username" id="retype_new_username" data-validation-engine="validate[required,equals[new_username]]" />
								</div>
							</div>
						</div><!-- /.box-body -->
						<div class="box-footer">
							<button type="submit" class="btn btn-primary" name="submit" value="Submit">Submit</button>
						</div>
					</form>
				</div><!-- /.box -->
			</div><!--/.col (left) -->
		</div>   <!-- /.row -->
	</section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php include ("includes/footer.php"); ?>