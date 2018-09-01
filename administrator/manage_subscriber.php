<?php
include "includes/session.php";
$url = basename(__FILE__) . "?" . (isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : 'cc=cc');
$_SESSION['subscriber_manage_url'] = $url;
// Manage Delete //
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
	$subscriber->subscriber_delete('manage_subscriber.php');
}

include "includes/header.php";
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Manage Subscriber
		</h1>
		<ol class="breadcrumb">
			<li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Manage Subscriber</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-primary">
					<div class="box-body">
						<?php echo $_SESSION['subscriber_msg'];
$_SESSION['subscriber_msg'] = ""; ?>
					</div>
					<div class="box-body table-responsive">
						<table class="table table-bordered table-hover" id="example">
							<thead>
								<tr>
									<th>ID</th>
									<th>Last Name</th>
									<th>First Name</th>
									<th>Email Address</th>
									<th>Join Through</th>
									<th>Date of Joining</th>
									<th><span style="text-align: center; display: block;">Email List</span>
										<table width="100%" cellpadding="1" cellspacing="1" style="padding: 2px 0 2px 0;">
											<tr>
												<td>Name</td>
												<td width="20%">Status</td>
											</tr>
										</table>
									</th>
									<th>Subscriber Status</th>
									<th>Option</th>
								</tr>
							</thead>
							<tbody>
								<?php
$subscriber_list_array = $subscriber->subscriber_display($db->tbl_pre . "subscriber_tbl", array());
for ($sa = 0; $sa < count($subscriber_list_array); $sa++) {
	$subscriber_email_list_array = $subscriber->subscriber_display($db->tbl_pre . "subscriber_list_tbl", array(), "WHERE subscriber_id='" . $subscriber_list_array[$sa]['subscriber_id'] . "'");

	?>
									<tr>
										<td><?php echo repc($subscriber_list_array[$sa]['subscriber_id']); ?></td>
										<td><?php echo repc($subscriber_list_array[$sa]['subscriber_first_name']); ?></td>
										<td><?php echo repc($subscriber_list_array[$sa]['subscriber_last_name']); ?></td>
										<td><?php echo repc($subscriber_list_array[$sa]['subscriber_email_address']); ?></td>
										<td><?php echo repc($subscriber_list_array[$sa]['subscriber_through']); ?></td>
										<td><?php echo repc($subscriber_list_array[$sa]['subscriber_date']); ?></td>
										<td><table width="100%" cellpadding="1" cellspacing="1" style="padding: 2px 0 2px 0;">
											<?php
for ($sela = 0; $sela < count($subscriber_email_list_array); $sela++) {
		$email_list_array = $email_list->email_list_display($db->tbl_pre . "email_list_tbl", array(), "WHERE email_list_id='" . $subscriber_email_list_array[$sela]['email_list_id'] . "'");
		?>
												<tr>
													<td><?php echo repc($email_list_array[0]['email_list_name']); ?></td>
													<td width="20%"><?php echo repc($subscriber_email_list_array[$sela]['subscriber_list_status']); ?></td>
												</tr>
												<?php
}
	?>
										</table>
									</td>
									<td><?php echo repc($subscriber_list_array[$sa]['subscriber_status']); ?></td>
									<td><a href="add_subscriber.php?subscriber_id=<?php echo $subscriber_list_array[$sa]['subscriber_id']; ?>&action=edit" title="Edit"><i class="fa fa-fw fa-edit"></i></a><a href="javascript:del('<?php echo $subscriber_list_array[$sa]['subscriber_id']; ?>','manage_subscriber.php','Subscriber')" title="Delete"><i class="fa fa-fw fa-close"></i></a></td>
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