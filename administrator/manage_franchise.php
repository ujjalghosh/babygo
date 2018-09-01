<?php
include "includes/session.php";
$url = basename(__FILE__) . "?" . (isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : 'cc=cc');
$_SESSION['franchise_manage_url'] = $url;
// Manage Delete //
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
	$franchise->franchise_delete('manage_franchise.php');
}
// Manage Status //
if (isset($_GET['action']) && $_GET['action'] == 'status') {
	$franchise->franchise_status_update('manage_franchise.php');
}
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'msgsubmt') {
	$franchise_array = array('franchise_message' => rep($_REQUEST['franchise_message']), 'franchise_message_status' => '1');
	$franchise_update = $db->update('franchise_tbl', $franchise_array, "franchise_id='" . $_REQUEST['franchise_id'] . "'");
	$_SESSION['franchise_msg'] = messagedisplay('Message sent successfully', 1);
	header('location: manage_franchise.php');
	exit();
}
include "includes/header.php";
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Manage Franchise
		</h1>
		<ol class="breadcrumb">
			<li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Manage Franchise</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-primary">
					<div class="box-body">
						<?php echo $_SESSION['franchise_msg'];
$_SESSION['franchise_msg'] = ""; ?>
					</div>
					<div class="box-body table-responsive">
						<table class="table table-bordered table-hover" id="example">
							<thead>
								<tr>
									<th>ID</th>
									<th>Name</th>
									<th>Email</th>
									<th>Password</th>
									<th>Status</th>
									<th>Option</th>
								</tr>
							</thead>
						</table>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div>
		</div>
	</section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php include "includes/footer.php";?>