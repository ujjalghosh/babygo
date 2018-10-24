<?php
include "includes/session.php";
$url = basename(__FILE__) . "?" . (isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : 'cc=cc');
$_SESSION['product_size_manage_url'] = $url;
// Manage Delete //
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
	$purchase->purchase_delete('manage_purchase_bill.php');
}
// Manage Status //
if (isset($_GET['action']) && $_GET['action'] == 'status') {
	$Product_size->Product_size_status_update('manage_purchase_bill.php');
}
include "includes/header.php";
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			  Product Stoke
		</h1>
		<ol class="breadcrumb">
			<li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">  Product Stoke  </li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-primary">
					<div class="box-body">
						<?php echo $_SESSION['purchase_msg']; $_SESSION['purchase_msg'] = ""; ?>
					
  </div>
					<div class="box-body table-responsive">
						<table class="table table-bordered table-hover" id="example">
							<thead>
								<tr>
								    <th>Id</th>
								    <th>Bill No.</th>
									<th>Date</th>  
									<th>Narration</th>
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