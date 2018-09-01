<?php
include "includes/session.php";
$url = basename(__FILE__) . "?" . (isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : 'cc=cc');
$_SESSION['appointment_manage_url'] = $url;
// Manage Delete //
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
	$appointment->appointment_delete('manage_appointment.php');
}

include "includes/header.php";
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Manage Appointment
		</h1>
		<ol class="breadcrumb">
			<li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Manage Appointment</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-primary">
					<div class="box-body">
						<?php echo $_SESSION['appointment_msg'];
$_SESSION['appointment_msg'] = ""; ?>
					</div>
					<div class="box-body table-responsive">
						<table class="table table-bordered table-hover" id="example">
							<thead>
								<tr>
									<th>ID</th>
									<th>Customer Name</th>
									<th>Email Address</th>
									<th>Date</th>
									<th>Price</th>
									<th>Story Price</th>
									<th>Total Price</th>
									<th>Appointment Status</th>
									<th>Option</th>
								</tr>
							</thead>
							<tbody>
								<?php
$appointment_list_array = $appointment->appointment_display($db->tbl_pre . "appointment_tbl", array());
for ($sa = 0; $sa < count($appointment_list_array); $sa++) {
	?>
									<tr>
										<td><?php echo repc($appointment_list_array[$sa]['appointment_id']); ?></td>
										<td><?php echo repc($appointment_list_array[$sa]['customer_first_name']); ?> <?php echo repc($appointment_list_array[$sa]['customer_last_name']); ?></td>
										<td><?php echo repc($appointment_list_array[$sa]['customer_email_address']); ?></td>
										<td><?php echo repc($appointment_list_array[$sa]['appointment_date']); ?></td>
										<td><?php echo '$' . number_format($appointment_list_array[$sa]['appointment_price'], 2); ?></td>
										<td><?php echo '$' . number_format($appointment_list_array[$sa]['appointment_story_price'], 2); ?></td>
										<td><?php echo '$' . number_format($appointment_list_array[$sa]['appointment_total_price'], 2); ?></td>
										<td><?php echo repc($appointment_list_array[$sa]['appointment_status']); ?></td>
										<td><a href="add_appointment.php?appointment_id=<?php echo $appointment_list_array[$sa]['appointment_id']; ?>&action=edit" title="Edit"><i class="fa fa-fw fa-edit"></i></a><a href="javascript:del('<?php echo $appointment_list_array[$sa]['appointment_id']; ?>','manage_appointment.php','Appointment')" title="Delete"><i class="fa fa-fw fa-close"></i></a></td>
									</tr>
									<?php
}
?>
							</tbody>
						</table>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div>
		</div>
	</section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php include "includes/footer.php";?>