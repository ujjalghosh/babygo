<?php
include "includes/session.php";
if (isset($_REQUEST['submit'])) {
	//echo $_FILES['upload_csv']['type'];
	//validate whether uploaded file is a csv file
	$csvMimes = array('application/vnd.ms-excel', 'text/plain', 'text/csv', 'text/tsv', 'application/octet-stream');
	if (!empty($_FILES['upload_csv']['name']) && in_array($_FILES['upload_csv']['type'], $csvMimes)) {
		if (is_uploaded_file($_FILES['upload_csv']['tmp_name'])) {

			//open uploaded csv file with read only mode
			$csvFile = fopen($_FILES['upload_csv']['tmp_name'], 'r');

			//skip first line
			fgetcsv($csvFile);

			//parse data from csv file line by line
			while (($line = fgetcsv($csvFile)) !== FALSE) {
				$subscriber_through = 'Admin';
				$subscriber_admin_name = $_SESSION['admin_name'];
				$name_value = array('subscriber_first_name' => rep($line[0]), 'subscriber_last_name' => rep($line[1]), 'subscriber_email_address' => rep($line[2]));
				$name_value2 = array('subscriber_through' => $subscriber_through, 'subscriber_admin_name' => rep($subscriber_admin_name), 'subscriber_date' => date("Y-m-d"), 'subscriber_time' => date("H:i:s"));
				//print_r($name_value);
				//check whether member already exists in database with same email
				$subscriber_array = $subscriber->subscriber_display($db->tbl_pre . "subscriber_tbl", array(), "WHERE subscriber_email_address='" . $line[2] . "'");
				if (count($subscriber_array) > 0) {
					//update member data
					$subscriber->subscriber_import_edit($name_value, $subscriber_array[0]['subscriber_id']);
				} else {
					//insert member data into database
					$subscriber->subscriber_import_add($name_value, $name_value2);
				}
			}

			//close opened csv file
			fclose($csvFile);
			$_SESSION['import_subscriber_msg'] = messagedisplay('Subscribers data has been inserted successfully.', 1);
		} else {
			$_SESSION['import_subscriber_msg'] = messagedisplay('Some problem occurred, please try again.', 3);
		}
	} else {
		$_SESSION['import_subscriber_msg'] = messagedisplay('Please upload a valid CSV file.', 2);
	}
}

include "includes/header.php";
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Manage Import Subscriber
		</h1>
		<ol class="breadcrumb">
			<li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Import Subscriber</li>
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
						<h3 class="box-title">Import Subscriber</h3>
					</div><!-- /.box-header -->
					<!-- form start -->
					<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
						<input type="hidden" name="action" id="action" value="<?php echo $action; ?>" />
						<div class="box-body">
							<?php echo $_SESSION['import_subscriber_msg'];
$_SESSION['import_subscriber_msg'] = ""; ?>
							<div class="form-group">
								<label class="col-sm-2 control-label">Email List Signup</label>
								<div class="col-sm-10">
									<?php
/*$email_list_array = $email_list->email_list_display($db->tbl_pre . "email_list_tbl", array(), "WHERE email_list_status='Active'");
for ($ela = 0; $ela < count($email_list_array); $ela++) {

	?>
										<input type="checkbox" id="email_list<?php echo $email_list_array[$ela]['email_list_id']; ?>" name="email_list[<?php echo $email_list_array[$ela]['email_list_id']; ?>]" value="<?php echo $email_list_array[$ela]['email_list_id']; ?>" <?php echo count($subscriber_list_array) != 0 ? 'checked="checked"' : ''; ?>> &nbsp;<strong><?php echo $email_list_array[$ela]['email_list_name']; ?></strong><br><br>
										<?php
}*/
?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Upload CSV</label>
								<div class="col-sm-10">
									<input type="file" name="upload_csv" id="upload_csv" data-validation-engine="validate[required]"/>
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