<?php
include "includes/session.php";
$url = basename(__FILE__) . "?" . (isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : 'cc=cc');
$_SESSION['company_manage_url'] = $url;
// Manage Delete //
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
	$customer->customer_delete('manage_customer.php');
} 
// Manage Status //
if (isset($_GET['action']) && $_GET['action'] == 'status') {
	$customer->customer_status_update('manage_customer.php');
}
include "includes/header.php";
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Manage Invoice
		</h1>
		<ol class="breadcrumb">
			<li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Manage Invoice  </li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-primary">
					<div class="box-body">
						<?php echo $_SESSION['invoice_msg'];
$_SESSION['invoice_msg'] = ""; ?>
					</div>
					<div class="box-body table-responsive">
						<table class="table table-bordered table-hover" id="example">
							<thead>
								<tr>
									<th>ID</th>
									<th>Order No</th>
									<th>Customer Name</th>									
									<th>Invoice Date</th>																
									<th>Invoice number</th>
									<th>consignment_number</th>
									<th>shipped</th>
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