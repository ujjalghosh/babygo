<?php
include "includes/session.php";
$url = basename(__FILE__) . "?" . (isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : 'cc=cc');
$_SESSION['sequence_manage_url'] = $url;
// Manage Delete //
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
	$sequence->sequence_delete('manage_sequence.php');
}

include "includes/header.php";
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Manage Sequence
		</h1>
		<ol class="breadcrumb">
			<li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Manage Sequence</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-primary">
					<div class="box-body">
						<?php echo $_SESSION['sequence_msg'];
$_SESSION['sequence_msg'] = ""; ?>
					</div>
					<div class="box-body table-responsive">
						<table class="table table-bordered table-hover" id="example">
							<thead>
								<tr>
									<th>ID</th>
									<th>Name</th>
									<th>Subject</th>
									<th>From</th>
									<th>From Email</th>
									<th>Reply To</th>
									<th>Reply To Email</th>
									<th>Email List</th>
									<th>Day</th>
									<th>Time</th>
									<th>Status</th>
									<th>Option</th>
								</tr>
							</thead>
							<tbody>
								<?php
$sequence_array = $sequence->sequence_display($db->tbl_pre . "sequence_tbl", array());
for ($sa = 0; $sa < count($sequence_array); $sa++) {
	$sequence_email_list_array = $sequence->sequence_display($db->tbl_pre . "sequence_email_list_tbl", array(), "WHERE sequence_id='" . $sequence_array[$sa]['sequence_id'] . "'");
	?>
									<tr>
										<td><?php echo repc($sequence_array[$sa]['sequence_id']); ?></td>
										<td><?php echo repc($sequence_array[$sa]['sequence_name']); ?></td>
										<td><?php echo repc($sequence_array[$sa]['sequence_subject']); ?></td>
										<td><?php echo repc($sequence_array[$sa]['sequence_sender_name']); ?></td>
										<td><?php echo repc($sequence_array[$sa]['sequence_sender_email']); ?></td>
										<td><?php echo repc($sequence_array[$sa]['sequence_reply_to_name']); ?></td>
										<td><?php echo repc($sequence_array[$sa]['sequence_reply_to_email']); ?></td>
										<td><?php echo repc($sequence_array[$sa]['sequence_id']); ?></td>
										<td><?php echo repc($sequence_array[$sa]['sequence_day']); ?></td>
										<td><?php echo repc($sequence_array[$sa]['sequence_time']); ?></td>
										<td><?php echo repc($sequence_array[$sa]['sequence_status']); ?></td>
										<td><?php echo repc($sequence_array[$sa]['sequence_id']); ?></td>
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