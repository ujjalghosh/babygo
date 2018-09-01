<?php
include "includes/session.php";
$return_url = (isset($_REQUEST['return_url']) && $_REQUEST['return_url'] != "") ? $_REQUEST['return_url'] : "login.php";
if (isset($_REQUEST['submit'])) {
	$old_password = $_REQUEST['old_password'];
	$sql = $db->query("SELECT * FROM " . $db->tbl_pre . "administrator_tbl WHERE administrator_id='1'", PDO::FETCH_BOTH);
	$row = $db->result($sql);
	if (decode($row[0]['administrator_password']) != $_REQUEST['old_password']) {
		$object = $db->result($sql);
		$_SESSION['admin_msg'] = messagedisplay("Sorry, Your Old password does not match!", 2);
		header('Location: ' . basename(__FILE__));
		exit();
	} else {
		$sql1 = $db->update("administrator_tbl", array('administrator_password' => encode($_REQUEST['new_password'])), "administrator_id='1'");
		$_SESSION['admin_msg'] = messagedisplay("Password has been successfully changed.", 1);
		header('location: ' . $return_url);
		exit();
	}
}
include "includes/header.php";
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Manage Password
		</h1>
		<ol class="breadcrumb">
			<li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Manage Password</li>
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
						<h3 class="box-title">Edit Password</h3>
					</div><!-- /.box-header -->
					<!-- form start -->
					<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
						<input type="hidden" name="action" id="action" value="<?php echo $action; ?>" />
						<div class="box-body">
							<?php echo $_SESSION['admin_msg'];
$_SESSION['admin_msg'] = ""; ?>
							<div class="form-group">
								<label class="col-sm-2 control-label">Old Password</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="old_password" id="old_password" data-validation-engine="validate[required]" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">New Password</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="new_password" id="new_password" data-validation-engine="validate[required]" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Retype New Password</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="retype_new_password" id="retype_new_password" data-validation-engine="validate[required,equals[new_password]]" />
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
<?php include "includes/footer.php";?>