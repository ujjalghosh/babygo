<?php
include "includes/session.php";
if (isset($_REQUEST['submit'])) {
	$c = 0;
	# Update General Settings #
	$sql = $db->update('site_configuration_tbl', array('site_configuration_value' => rep($_POST['site_title'])), "site_configuration_id=1");
	$c = $c + $sql['affectedRow'];
	$sql = $db->update('site_configuration_tbl', array('site_configuration_value' => rep($_POST['site_tagline'])), "site_configuration_id=2");
	$c = $c + $sql['affectedRow'];
	$sql = $db->update('site_configuration_tbl', array('site_configuration_value' => rep($_POST['site_url'])), "site_configuration_id=3");
	$c = $c + $sql['affectedRow'];
	$sql = $db->update('site_configuration_tbl', array('site_configuration_value' => rep($_POST['date_format'])), "site_configuration_id=4");
	$c = $c + $sql['affectedRow'];
	$sql = $db->update('site_configuration_tbl', array('site_configuration_value' => rep($_POST['time_format'])), "site_configuration_id=5");
	$c = $c + $sql['affectedRow'];
	$sql = $db->update('site_configuration_tbl', array('site_configuration_value' => rep($_POST['time_zone'])), "site_configuration_id=6");
	$c = $c + $sql['affectedRow'];
	$sql = $db->update('site_configuration_tbl', array('site_configuration_value' => rep($_POST['admin_receiving_email_id'])), "site_configuration_id=7");
	$c = $c + $sql['affectedRow'];
	$sql = $db->update('site_configuration_tbl', array('site_configuration_value' => rep($_POST['admin_sending_email_id'])), "site_configuration_id=8");
	$c = $c + $sql['affectedRow'];
	$sql = $db->update('site_configuration_tbl', array('site_configuration_value' => rep($_POST['pagination_number'])), "site_configuration_id=9");
	$c = $c + $sql['affectedRow'];
	$sql = $db->update('site_configuration_tbl', array('site_configuration_value' => rep($_POST['paypal_api_username'])), "site_configuration_id=10");
	$c = $c + $sql['affectedRow'];
	$sql = $db->update('site_configuration_tbl', array('site_configuration_value' => rep($_POST['paypal_api_password'])), "site_configuration_id=11");
	$c = $c + $sql['affectedRow'];
	$sql = $db->update('site_configuration_tbl', array('site_configuration_value' => rep($_POST['paypal_api_signature'])), "site_configuration_id=12");
	$c = $c + $sql['affectedRow'];
	$sql = $db->update('site_configuration_tbl', array('site_configuration_value' => rep($_POST['payment_mode'])), "site_configuration_id=13");
	$c = $c + $sql['affectedRow'];
	if ($_FILES['site_logo']['size'] > 0) {
		$original = 'images/';
		$albumfile_name = $_FILES['site_logo']['name'];
		$albumfile_tmp = $_FILES['site_logo']['tmp_name'];
		$albumfile_size = $_FILES['site_logo']['size'];
		$albumfile_type = $_FILES['site_logo']['type'];
		$site_id = 1;
		$site_image_name_saved = str_replace("&", "and", $site_id . "_" . time() . "_" . $albumfile_name);
		$site_image_name_saved = str_replace(" ", "_", $site_id . "_" . time() . "_" . $albumfile_name);
		$site_image_img = str_replace("&", "and", $original . $site_id . "_" . time() . "_" . $albumfile_name);
		//original path
		$site_image_img = str_replace(" ", "_", $original . $site_id . "_" . time() . "_" . $albumfile_name);
		//original path
		$site_image_img1 = "../" . $site_image_img;
		move_uploaded_file($albumfile_tmp, $site_image_img1);
		$sql = $db->update('site_configuration_tbl', array('site_configuration_value' => (rep($site_image_img))), "site_configuration_id=14");
		$c = $c + 1;
	}
	$sql = $db->update('site_configuration_tbl', array('site_configuration_value' => rep($_POST['copyright_text'])), "site_configuration_id=15");
	$c = $c + $sql['affectedRow'];
	$sql = $db->update('site_configuration_tbl', array('site_configuration_value' => rep($_POST['story2_unit_price'])), "site_configuration_id=16");
	$c = $c + $sql['affectedRow'];
	$sql = $db->update('site_configuration_tbl', array('site_configuration_value' => rep($_POST['story3_unit_price'])), "site_configuration_id=17");
	$c = $c + $sql['affectedRow'];
	//echo $c;
	if ($c > 0) {
		$_SESSION['general_settings_msg'] = messagedisplay("Settings updated successfully.", 1);
	} else {
		$_SESSION['general_settings_msg'] = messagedisplay("Sorry, nothing is updated.", 2);
	}
	header('Location: general_settings.php');
	exit();
}

$site_title = $db->result($db->query("select site_configuration_value from " . $db->tbl_pre . "site_configuration_tbl where site_configuration_id=1", PDO::FETCH_BOTH));
$site_tagline = $db->result($db->query("select site_configuration_value from " . $db->tbl_pre . "site_configuration_tbl where site_configuration_id=2", PDO::FETCH_BOTH));
$site_url = $db->result($db->query("select site_configuration_value from " . $db->tbl_pre . "site_configuration_tbl where site_configuration_id=3", PDO::FETCH_BOTH));
$date_format = $db->result($db->query("select site_configuration_value from " . $db->tbl_pre . "site_configuration_tbl where site_configuration_id=4", PDO::FETCH_BOTH));
$time_format = $db->result($db->query("select site_configuration_value from " . $db->tbl_pre . "site_configuration_tbl where site_configuration_id=5", PDO::FETCH_BOTH));
$time_zone = $db->result($db->query("select site_configuration_value from " . $db->tbl_pre . "site_configuration_tbl where site_configuration_id=6", PDO::FETCH_BOTH));
$admin_receiving_email_id = $db->result($db->query("select site_configuration_value from " . $db->tbl_pre . "site_configuration_tbl where site_configuration_id=7", PDO::FETCH_BOTH));
$admin_sending_email_id = $db->result($db->query("select site_configuration_value from " . $db->tbl_pre . "site_configuration_tbl where site_configuration_id=8", PDO::FETCH_BOTH));
$pagination_number = $db->result($db->query("select site_configuration_value from " . $db->tbl_pre . "site_configuration_tbl where site_configuration_id=9", PDO::FETCH_BOTH));
$paypal_api_username = $db->result($db->query("select site_configuration_value from " . $db->tbl_pre . "site_configuration_tbl where site_configuration_id=10", PDO::FETCH_BOTH));
$paypal_api_password = $db->result($db->query("select site_configuration_value from " . $db->tbl_pre . "site_configuration_tbl where site_configuration_id=11", PDO::FETCH_BOTH));
$paypal_api_signature = $db->result($db->query("select site_configuration_value from " . $db->tbl_pre . "site_configuration_tbl where site_configuration_id=12", PDO::FETCH_BOTH));
$payment_mode = $db->result($db->query("select site_configuration_value from " . $db->tbl_pre . "site_configuration_tbl where site_configuration_id=13", PDO::FETCH_BOTH));
$site_logo = $db->result($db->query("select site_configuration_value from " . $db->tbl_pre . "site_configuration_tbl where site_configuration_id=14", PDO::FETCH_BOTH));
$copyright_text = $db->result($db->query("select site_configuration_value from " . $db->tbl_pre . "site_configuration_tbl where site_configuration_id=15", PDO::FETCH_BOTH));
$story2_unit_price = $db->result($db->query("select site_configuration_value from " . $db->tbl_pre . "site_configuration_tbl where site_configuration_id=16", PDO::FETCH_BOTH));
$story3_unit_price = $db->result($db->query("select site_configuration_value from " . $db->tbl_pre . "site_configuration_tbl where site_configuration_id=17", PDO::FETCH_BOTH));
include "includes/header.php";
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Manage General Settings
		</h1>
		<ol class="breadcrumb">
			<li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">General Settings</li>
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
						<h3 class="box-title">Edit Settings</h3>
					</div><!-- /.box-header -->
					<!-- form start -->
					<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
						<input type="hidden" name="action" id="action" value="<?php echo $action; ?>" />
						<div class="box-body">
							<?php echo $_SESSION['general_settings_msg'];
$_SESSION['general_settings_msg'] = ""; ?>
							<div class="form-group">
								<label class="col-sm-2 control-label">Site Title</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="site_title" id="site_title" data-validation-engine="validate[required]" value="<?php echo $site_title[0][0]; ?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Site Tagline</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="site_tagline" id="site_tagline" value="<?php echo $site_tagline[0][0]; ?>" data-validation-engine="validate[required]" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Site URL</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="site_url" id="site_url" value="<?php echo $site_url[0][0]; ?>" data-validation-engine="validate[required]"/>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Date Format</label>
								<div class="col-sm-10">
									<select name="date_format" id="date_format" data-validation-engine="validate[required]" class="form-control select2">
										<option value="">[ Date Format ]</option>
										<option value="1" <?php echo $date_format[0][0] == 1 ? "selected" : ""; ?>>2004-06-29</option>
										<option value="2" <?php echo $date_format[0][0] == 2 ? "selected" : ""; ?>>06-29-2004</option>
										<option value="3" <?php echo $date_format[0][0] == 3 ? "selected" : ""; ?>>29-06-2004</option>
										<option value="4" <?php echo $date_format[0][0] == 4 ? "selected" : ""; ?>>29 Jun 2004</option>
										<option value="5" <?php echo $date_format[0][0] == 5 ? "selected" : ""; ?>>29 June 2004</option>
										<option value="6" <?php echo $date_format[0][0] == 6 ? "selected" : ""; ?>>Jun 29,2004</option>
										<option value="7" <?php echo $date_format[0][0] == 7 ? "selected" : ""; ?>>Tue Jun 29th,2004</option>
										<option value="8" <?php echo $date_format[0][0] == 8 ? "selected" : ""; ?>>Tuesday Jun 29th,2004</option>
										<option value="9" <?php echo $date_format[0][0] == 9 ? "selected" : ""; ?>>Tuesday June 29th,2004</option>
										<option value="10" <?php echo $date_format[0][0] == 10 ? "selected" : ""; ?>>29 June 2004 Tuesday</option>
										<option value="11" <?php echo $date_format[0][0] == 11 ? "selected" : ""; ?>>6/20/2012</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Time Format</label>
								<div class="col-sm-10">
									<select name="time_format" id="time_format" data-validation-engine="validate[required]" class="form-control select2">
										<option value="">[ Time Format ]</option>
										<option value="1" <?php echo $time_format[0][0] == 1 ? "selected" : ""; ?>>06:20 pm</option>
										<option value="2" <?php echo $time_format[0][0] == 2 ? "selected" : ""; ?>>06:20 PM</option>
										<option value="3" <?php echo $time_format[0][0] == 3 ? "selected" : ""; ?>>18:20</option></option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Current Timezone</label>
								<div class="col-sm-10">
									<select class="form-control select2" id="time_zone" name="time_zone" data-validation-engine="validate[required]">
										<option value="">[ Timezone ]</option>
										<option value="Pacific/Midway" <?php echo $time_zone[0][0] == "Pacific/Midway" ? "selected" : ""; ?>>(UTC-11:00) Midway Island</option>
										<option value="Pacific/Samoa" <?php echo $time_zone[0][0] == "Pacific/Samoa" ? "selected" : ""; ?>>(UTC-11:00) Samoa</option>
										<option value="Pacific/Honolulu" <?php echo $time_zone[0][0] == "Pacific/Honolulu" ? "selected" : ""; ?>>(UTC-10:00) Hawaii</option>
										<option value="US/Alaska" <?php echo $time_zone[0][0] == "US/Alaska" ? "selected" : ""; ?>>(UTC-09:00) Alaska</option>
										<option value="America/Los_Angeles" <?php echo $time_zone[0][0] == "America/Los_Angeles" ? "selected" : ""; ?>>(UTC-08:00) Pacific Time (US &amp; Canada)</option>
										<option value="America/Tijuana" <?php echo $time_zone[0][0] == "America/Tijuana" ? "selected" : ""; ?>>(UTC-08:00) Tijuana</option>
										<option value="US/Arizona" <?php echo $time_zone[0][0] == "US/Arizona" ? "selected" : ""; ?>>(UTC-07:00) Arizona</option>
										<option value="America/Chihuahua" <?php echo $time_zone[0][0] == "America/Chihuahua" ? "selected" : ""; ?>>(UTC-07:00) Chihuahua</option>
										<option value="America/Chihuahua" <?php echo $time_zone[0][0] == "America/Chihuahua" ? "selected" : ""; ?>>(UTC-07:00) La Paz</option>
										<option value="America/Mazatlan" <?php echo $time_zone[0][0] == "America/Mazatlan" ? "selected" : ""; ?>>(UTC-07:00) Mazatlan</option>
										<option value="US/Mountain" <?php echo $time_zone[0][0] == "US/Mountain" ? "selected" : ""; ?>>(UTC-07:00) Mountain Time (US &amp; Canada)</option>
										<option value="America/Managua" <?php echo $time_zone[0][0] == "America/Managua" ? "selected" : ""; ?>>(UTC-06:00) Central America</option>
										<option value="US/Central" <?php echo $time_zone[0][0] == "US/Central" ? "selected" : ""; ?>>(UTC-06:00) Central Time (US &amp; Canada)</option>
										<option value="America/Mexico_City" <?php echo $time_zone[0][0] == "America/Mexico_City" ? "selected" : ""; ?>>(UTC-06:00) Guadalajara</option>
										<option value="America/Mexico_City" <?php echo $time_zone[0][0] == "America/Mexico_City" ? "selected" : ""; ?>>(UTC-06:00) Mexico City</option>
										<option value="America/Monterrey" <?php echo $time_zone[0][0] == "America/Monterrey" ? "selected" : ""; ?>>(UTC-06:00) Monterrey</option>
										<option value="Canada/Saskatchewan" <?php echo $time_zone[0][0] == "Canada/Saskatchewan" ? "selected" : ""; ?>>(UTC-06:00) Saskatchewan</option>
										<option value="America/Bogota" <?php echo $time_zone[0][0] == "America/Bogota" ? "selected" : ""; ?>>(UTC-05:00) Bogota</option>
										<option value="US/Eastern" <?php echo $time_zone[0][0] == "US/Eastern" ? "selected" : ""; ?>>(UTC-05:00) Eastern Time (US &amp; Canada)</option>
										<option value="US/East-Indiana" <?php echo $time_zone[0][0] == "US/East-Indiana" ? "selected" : ""; ?>>(UTC-05:00) Indiana (East)</option>
										<option value="America/Lima" <?php echo $time_zone[0][0] == "America/Lima" ? "selected" : ""; ?>>(UTC-05:00) Lima</option>
										<option value="America/Bogota" <?php echo $time_zone[0][0] == "America/Bogota" ? "selected" : ""; ?>>(UTC-05:00) Quito</option>
										<option value="Canada/Atlantic" <?php echo $time_zone[0][0] == "Canada/Atlantic" ? "selected" : ""; ?>>(UTC-04:00) Atlantic Time (Canada)</option>
										<option value="America/Caracas" <?php echo $time_zone[0][0] == "America/Caracas" ? "selected" : ""; ?>>(UTC-04:30) Caracas</option>
										<option value="America/La_Paz" <?php echo $time_zone[0][0] == "America/La_Paz" ? "selected" : ""; ?>>(UTC-04:00) La Paz</option>
										<option value="America/Santiago" <?php echo $time_zone[0][0] == "America/Santiago" ? "selected" : ""; ?>>(UTC-04:00) Santiago</option>
										<option value="Canada/Newfoundland" <?php echo $time_zone[0][0] == "Canada/Newfoundland" ? "selected" : ""; ?>>(UTC-03:30) Newfoundland</option>
										<option value="America/Sao_Paulo" <?php echo $time_zone[0][0] == "America/Sao_Paulo" ? "selected" : ""; ?>>(UTC-03:00) Brasilia</option>
										<option value="America/Argentina/Buenos_Aires" <?php echo $time_zone[0][0] == "America/Argentina/Buenos_Aires" ? "selected" : ""; ?>>(UTC-03:00) Buenos Aires</option>
										<option value="America/Argentina/Buenos_Aires" <?php echo $time_zone[0][0] == "America/Argentina/Buenos_Aires" ? "selected" : ""; ?>>(UTC-03:00) Georgetown</option>
										<option value="America/Godthab" <?php echo $time_zone[0][0] == "America/Godthab" ? "selected" : ""; ?>>(UTC-03:00) Greenland</option>
										<option value="America/Noronha" <?php echo $time_zone[0][0] == "America/Noronha" ? "selected" : ""; ?>>(UTC-02:00) Mid-Atlantic</option>
										<option value="Atlantic/Azores" <?php echo $time_zone[0][0] == "Atlantic/Azores" ? "selected" : ""; ?>>(UTC-01:00) Azores</option>
										<option value="Atlantic/Cape_Verde" <?php echo $time_zone[0][0] == "Atlantic/Cape_Verde" ? "selected" : ""; ?>>(UTC-01:00) Cape Verde Is.</option>
										<option value="Africa/Casablanca" <?php echo $time_zone[0][0] == "Africa/Casablanca" ? "selected" : ""; ?>>(UTC+00:00) Casablanca</option>
										<option value="Europe/London" <?php echo $time_zone[0][0] == "Europe/London" ? "selected" : ""; ?>>(UTC+00:00) Edinburgh</option>
										<option value="Etc/Greenwich" <?php echo $time_zone[0][0] == "Etc/Greenwich" ? "selected" : ""; ?>>(UTC+00:00) Greenwich Mean Time : Dublin</option>
										<option value="Europe/Lisbon" <?php echo $time_zone[0][0] == "Europe/Lisbon" ? "selected" : ""; ?>>(UTC+00:00) Lisbon</option>
										<option value="Europe/London" <?php echo $time_zone[0][0] == "Europe/London" ? "selected" : ""; ?>>(UTC+00:00) London</option>
										<option value="Africa/Monrovia" <?php echo $time_zone[0][0] == "Africa/Monrovia" ? "selected" : ""; ?>>(UTC+00:00) Monrovia</option>
										<option value="UTC" <?php echo $time_zone[0][0] == "UTC" ? "selected" : ""; ?>>(UTC+00:00) UTC</option>
										<option value="Europe/Amsterdam" <?php echo $time_zone[0][0] == "Europe/Amsterdam" ? "selected" : ""; ?>>(UTC+01:00) Amsterdam</option>
										<option value="Europe/Belgrade" <?php echo $time_zone[0][0] == "Europe/Belgrade" ? "selected" : ""; ?>>(UTC+01:00) Belgrade</option>
										<option value="Europe/Berlin" <?php echo $time_zone[0][0] == "Europe/Berlin" ? "selected" : ""; ?>>(UTC+01:00) Berlin</option>
										<option value="Europe/Berlin" <?php echo $time_zone[0][0] == "Europe/Berlin" ? "selected" : ""; ?>>(UTC+01:00) Bern</option>
										<option value="Europe/Bratislava" <?php echo $time_zone[0][0] == "Europe/Bratislava" ? "selected" : ""; ?>>(UTC+01:00) Bratislava</option>
										<option value="Europe/Brussels" <?php echo $time_zone[0][0] == "Europe/Brussels" ? "selected" : ""; ?>>(UTC+01:00) Brussels</option>
										<option value="Europe/Budapest" <?php echo $time_zone[0][0] == "Europe/Budapest" ? "selected" : ""; ?>>(UTC+01:00) Budapest</option>
										<option value="Europe/Copenhagen" <?php echo $time_zone[0][0] == "Europe/Copenhagen" ? "selected" : ""; ?>>(UTC+01:00) Copenhagen</option>
										<option value="Europe/Ljubljana" <?php echo $time_zone[0][0] == "Europe/Ljubljana" ? "selected" : ""; ?>>(UTC+01:00) Ljubljana</option>
										<option value="Europe/Madrid" <?php echo $time_zone[0][0] == "Europe/Madrid" ? "selected" : ""; ?>>(UTC+01:00) Madrid</option>
										<option value="Europe/Paris" <?php echo $time_zone[0][0] == "Europe/Paris" ? "selected" : ""; ?>>(UTC+01:00) Paris</option>
										<option value="Europe/Prague" <?php echo $time_zone[0][0] == "Europe/Prague" ? "selected" : ""; ?>>(UTC+01:00) Prague</option>
										<option value="Europe/Rome" <?php echo $time_zone[0][0] == "Europe/Rome" ? "selected" : ""; ?>>(UTC+01:00) Rome</option>
										<option value="Europe/Sarajevo" <?php echo $time_zone[0][0] == "Europe/Sarajevo" ? "selected" : ""; ?>>(UTC+01:00) Sarajevo</option>
										<option value="Europe/Skopje" <?php echo $time_zone[0][0] == "Europe/Skopje" ? "selected" : ""; ?>>(UTC+01:00) Skopje</option>
										<option value="Europe/Stockholm" <?php echo $time_zone[0][0] == "Europe/Stockholm" ? "selected" : ""; ?>>(UTC+01:00) Stockholm</option>
										<option value="Europe/Vienna" <?php echo $time_zone[0][0] == "Europe/Vienna" ? "selected" : ""; ?>>(UTC+01:00) Vienna</option>
										<option value="Europe/Warsaw" <?php echo $time_zone[0][0] == "Europe/Warsaw" ? "selected" : ""; ?>>(UTC+01:00) Warsaw</option>
										<option value="Africa/Lagos" <?php echo $time_zone[0][0] == "Africa/Lagos" ? "selected" : ""; ?>>(UTC+01:00) West Central Africa</option>
										<option value="Europe/Zagreb" <?php echo $time_zone[0][0] == "Europe/Zagreb" ? "selected" : ""; ?>>(UTC+01:00) Zagreb</option>
										<option value="Europe/Athens" <?php echo $time_zone[0][0] == "Europe/Athens" ? "selected" : ""; ?>>(UTC+02:00) Athens</option>
										<option value="Europe/Bucharest" <?php echo $time_zone[0][0] == "Europe/Bucharest" ? "selected" : ""; ?>>(UTC+02:00) Bucharest</option>
										<option value="Africa/Cairo" <?php echo $time_zone[0][0] == "Africa/Cairo" ? "selected" : ""; ?>>(UTC+02:00) Cairo</option>
										<option value="Africa/Harare" <?php echo $time_zone[0][0] == "Africa/Harare" ? "selected" : ""; ?>>(UTC+02:00) Harare</option>
										<option value="Europe/Helsinki" <?php echo $time_zone[0][0] == "Europe/Helsinki" ? "selected" : ""; ?>>(UTC+02:00) Helsinki</option>
										<option value="Europe/Istanbul" <?php echo $time_zone[0][0] == "Europe/Istanbul" ? "selected" : ""; ?>>(UTC+02:00) Istanbul</option>
										<option value="Asia/Jerusalem" <?php echo $time_zone[0][0] == "Asia/Jerusalem" ? "selected" : ""; ?>>(UTC+02:00) Jerusalem</option>
										<option value="Europe/Helsinki" <?php echo $time_zone[0][0] == "Europe/Helsinki" ? "selected" : ""; ?>>(UTC+02:00) Kyiv</option>
										<option value="Africa/Johannesburg" <?php echo $time_zone[0][0] == "Africa/Johannesburg" ? "selected" : ""; ?>>(UTC+02:00) Pretoria</option>
										<option value="Europe/Riga" <?php echo $time_zone[0][0] == "Europe/Riga" ? "selected" : ""; ?>>(UTC+02:00) Riga</option>
										<option value="Europe/Sofia" <?php echo $time_zone[0][0] == "Europe/Sofia" ? "selected" : ""; ?>>(UTC+02:00) Sofia</option>
										<option value="Europe/Tallinn" <?php echo $time_zone[0][0] == "Europe/Tallinn" ? "selected" : ""; ?>>(UTC+02:00) Tallinn</option>
										<option value="Europe/Vilnius" <?php echo $time_zone[0][0] == "Europe/Vilnius" ? "selected" : ""; ?>>(UTC+02:00) Vilnius</option>
										<option value="Asia/Baghdad" <?php echo $time_zone[0][0] == "Asia/Baghdad" ? "selected" : ""; ?>>(UTC+03:00) Baghdad</option>
										<option value="Asia/Kuwait" <?php echo $time_zone[0][0] == "Asia/Kuwait" ? "selected" : ""; ?>>(UTC+03:00) Kuwait</option>
										<option value="Europe/Minsk" <?php echo $time_zone[0][0] == "Europe/Minsk" ? "selected" : ""; ?>>(UTC+03:00) Minsk</option>
										<option value="Africa/Nairobi" <?php echo $time_zone[0][0] == "Africa/Nairobi" ? "selected" : ""; ?>>(UTC+03:00) Nairobi</option>
										<option value="Asia/Riyadh" <?php echo $time_zone[0][0] == "Asia/Riyadh" ? "selected" : ""; ?>>(UTC+03:00) Riyadh</option>
										<option value="Europe/Volgograd" <?php echo $time_zone[0][0] == "Europe/Volgograd" ? "selected" : ""; ?>>(UTC+03:00) Volgograd</option>
										<option value="Asia/Tehran" <?php echo $time_zone[0][0] == "Asia/Tehran" ? "selected" : ""; ?>>(UTC+03:30) Tehran</option>
										<option value="Asia/Muscat" <?php echo $time_zone[0][0] == "Asia/Muscat" ? "selected" : ""; ?>>(UTC+04:00) Abu Dhabi</option>
										<option value="Asia/Baku" <?php echo $time_zone[0][0] == "Asia/Baku" ? "selected" : ""; ?>>(UTC+04:00) Baku</option>
										<option value="Europe/Moscow" <?php echo $time_zone[0][0] == "Europe/Moscow" ? "selected" : ""; ?>>(UTC+04:00) Moscow</option>
										<option value="Asia/Muscat" <?php echo $time_zone[0][0] == "Asia/Muscat" ? "selected" : ""; ?>>(UTC+04:00) Muscat</option>
										<option value="Europe/Moscow" <?php echo $time_zone[0][0] == "Europe/Moscow" ? "selected" : ""; ?>>(UTC+04:00) St. Petersburg</option>
										<option value="Asia/Tbilisi" <?php echo $time_zone[0][0] == "Asia/Tbilisi" ? "selected" : ""; ?>>(UTC+04:00) Tbilisi</option>
										<option value="Asia/Yerevan" <?php echo $time_zone[0][0] == "Asia/Yerevan" ? "selected" : ""; ?>>(UTC+04:00) Yerevan</option>
										<option value="Asia/Kabul" <?php echo $time_zone[0][0] == "Asia/Kabul" ? "selected" : ""; ?>>(UTC+04:30) Kabul</option>
										<option value="Asia/Karachi" <?php echo $time_zone[0][0] == "Asia/Karachi" ? "selected" : ""; ?>>(UTC+05:00) Islamabad</option>
										<option value="Asia/Karachi" <?php echo $time_zone[0][0] == "Asia/Karachi" ? "selected" : ""; ?>>(UTC+05:00) Karachi</option>
										<option value="Asia/Tashkent" <?php echo $time_zone[0][0] == "Asia/Tashkent" ? "selected" : ""; ?>>(UTC+05:00) Tashkent</option>
										<option value="Asia/Calcutta" <?php echo $time_zone[0][0] == "Asia/Calcutta" ? "selected" : ""; ?>>(UTC+05:30) Chennai</option>
										<option value="Asia/Kolkata" <?php echo $time_zone[0][0] == "Asia/Kolkata" ? "selected" : ""; ?>>(UTC+05:30) Kolkata</option>
										<option value="Asia/Calcutta" <?php echo $time_zone[0][0] == "Asia/Calcutta" ? "selected" : ""; ?>>(UTC+05:30) Mumbai</option>
										<option value="Asia/Calcutta" <?php echo $time_zone[0][0] == "Asia/Calcutta" ? "selected" : ""; ?>>(UTC+05:30) New Delhi</option>
										<option value="Asia/Calcutta" <?php echo $time_zone[0][0] == "Asia/Calcutta" ? "selected" : ""; ?>>(UTC+05:30) Sri Jayawardenepura</option>
										<option value="Asia/Katmandu" <?php echo $time_zone[0][0] == "Asia/Katmandu" ? "selected" : ""; ?>>(UTC+05:45) Kathmandu</option>
										<option value="Asia/Almaty" <?php echo $time_zone[0][0] == "Asia/Almaty" ? "selected" : ""; ?>>(UTC+06:00) Almaty</option>
										<option value="Asia/Dhaka" <?php echo $time_zone[0][0] == "Asia/Dhaka" ? "selected" : ""; ?>>(UTC+06:00) Astana</option>
										<option value="Asia/Dhaka" <?php echo $time_zone[0][0] == "Asia/Dhaka" ? "selected" : ""; ?>>(UTC+06:00) Dhaka</option>
										<option value="Asia/Yekaterinburg" <?php echo $time_zone[0][0] == "Asia/Yekaterinburg" ? "selected" : ""; ?>>(UTC+06:00) Ekaterinburg</option>
										<option value="Asia/Rangoon" <?php echo $time_zone[0][0] == "Asia/Rangoon" ? "selected" : ""; ?>>(UTC+06:30) Rangoon</option>
										<option value="Asia/Bangkok" <?php echo $time_zone[0][0] == "Asia/Bangkok" ? "selected" : ""; ?>>(UTC+07:00) Bangkok</option>
										<option value="Asia/Bangkok" <?php echo $time_zone[0][0] == "Asia/Bangkok" ? "selected" : ""; ?>>(UTC+07:00) Hanoi</option>
										<option value="Asia/Jakarta" <?php echo $time_zone[0][0] == "Asia/Jakarta" ? "selected" : ""; ?>>(UTC+07:00) Jakarta</option>
										<option value="Asia/Novosibirsk" <?php echo $time_zone[0][0] == "Asia/Novosibirsk" ? "selected" : ""; ?>>(UTC+07:00) Novosibirsk</option>
										<option value="Asia/Hong_Kong" <?php echo $time_zone[0][0] == "Asia/Hong_Kong" ? "selected" : ""; ?>>(UTC+08:00) Beijing</option>
										<option value="Asia/Chongqing" <?php echo $time_zone[0][0] == "Asia/Chongqing" ? "selected" : ""; ?>>(UTC+08:00) Chongqing</option>
										<option value="Asia/Hong_Kong" <?php echo $time_zone[0][0] == "Asia/Hong_Kong" ? "selected" : ""; ?>>(UTC+08:00) Hong Kong</option>
										<option value="Asia/Krasnoyarsk" <?php echo $time_zone[0][0] == "Asia/Krasnoyarsk" ? "selected" : ""; ?>>(UTC+08:00) Krasnoyarsk</option>
										<option value="Asia/Kuala_Lumpur" <?php echo $time_zone[0][0] == "Asia/Kuala_Lumpur" ? "selected" : ""; ?>>(UTC+08:00) Kuala Lumpur</option>
										<option value="Australia/Perth" <?php echo $time_zone[0][0] == "Australia/Perth" ? "selected" : ""; ?>>(UTC+08:00) Perth</option>
										<option value="Asia/Singapore" <?php echo $time_zone[0][0] == "Asia/Singapore" ? "selected" : ""; ?>>(UTC+08:00) Singapore</option>
										<option value="Asia/Taipei" <?php echo $time_zone[0][0] == "Asia/Taipei" ? "selected" : ""; ?>>(UTC+08:00) Taipei</option>
										<option value="Asia/Ulan_Bator" <?php echo $time_zone[0][0] == "Asia/Ulan_Bator" ? "selected" : ""; ?>>(UTC+08:00) Ulaan Bataar</option>
										<option value="Asia/Urumqi" <?php echo $time_zone[0][0] == "Asia/Urumqi" ? "selected" : ""; ?>>(UTC+08:00) Urumqi</option>
										<option value="Asia/Irkutsk" <?php echo $time_zone[0][0] == "Asia/Irkutsk" ? "selected" : ""; ?>>(UTC+09:00) Irkutsk</option>
										<option value="Asia/Tokyo" <?php echo $time_zone[0][0] == "Asia/Tokyo" ? "selected" : ""; ?>>(UTC+09:00) Osaka</option>
										<option value="Asia/Tokyo" <?php echo $time_zone[0][0] == "Asia/Tokyo" ? "selected" : ""; ?>>(UTC+09:00) Sapporo</option>
										<option value="Asia/Seoul" <?php echo $time_zone[0][0] == "Asia/Seoul" ? "selected" : ""; ?>>(UTC+09:00) Seoul</option>
										<option value="Asia/Tokyo" <?php echo $time_zone[0][0] == "Asia/Tokyo" ? "selected" : ""; ?>>(UTC+09:00) Tokyo</option>
										<option value="Australia/Adelaide" <?php echo $time_zone[0][0] == "Australia/Adelaide" ? "selected" : ""; ?>>(UTC+09:30) Adelaide</option>
										<option value="Australia/Darwin" <?php echo $time_zone[0][0] == "Australia/Darwin" ? "selected" : ""; ?>>(UTC+09:30) Darwin</option>
										<option value="Australia/Brisbane" <?php echo $time_zone[0][0] == "Australia/Brisbane" ? "selected" : ""; ?>>(UTC+10:00) Brisbane</option>
										<option value="Australia/Canberra" <?php echo $time_zone[0][0] == "Australia/Canberra" ? "selected" : ""; ?>>(UTC+10:00) Canberra</option>
										<option value="Pacific/Guam" <?php echo $time_zone[0][0] == "Pacific/Guam" ? "selected" : ""; ?>>(UTC+10:00) Guam</option>
										<option value="Australia/Hobart" <?php echo $time_zone[0][0] == "Australia/Hobart" ? "selected" : ""; ?>>(UTC+10:00) Hobart</option>
										<option value="Australia/Melbourne" <?php echo $time_zone[0][0] == "Australia/Melbourne" ? "selected" : ""; ?>>(UTC+10:00) Melbourne</option>
										<option value="Pacific/Port_Moresby" <?php echo $time_zone[0][0] == "Pacific/Port_Moresby" ? "selected" : ""; ?>>(UTC+10:00) Port Moresby</option>
										<option value="Australia/Sydney" <?php echo $time_zone[0][0] == "Australia/Sydney" ? "selected" : ""; ?>>(UTC+10:00) Sydney</option>
										<option value="Asia/Yakutsk" <?php echo $time_zone[0][0] == "Asia/Yakutsk" ? "selected" : ""; ?>>(UTC+10:00) Yakutsk</option>
										<option value="Asia/Vladivostok" <?php echo $time_zone[0][0] == "Asia/Vladivostok" ? "selected" : ""; ?>>(UTC+11:00) Vladivostok</option>
										<option value="Pacific/Auckland" <?php echo $time_zone[0][0] == "Pacific/Auckland" ? "selected" : ""; ?>>(UTC+12:00) Auckland</option>
										<option value="Pacific/Fiji" <?php echo $time_zone[0][0] == "Pacific/Fiji" ? "selected" : ""; ?>>(UTC+12:00) Fiji</option>
										<option value="Pacific/Kwajalein" <?php echo $time_zone[0][0] == "Pacific/Kwajalein" ? "selected" : ""; ?>>(UTC+12:00) International Date Line West</option>
										<option value="Asia/Kamchatka" <?php echo $time_zone[0][0] == "Asia/Kamchatka" ? "selected" : ""; ?>>(UTC+12:00) Kamchatka</option>
										<option value="Asia/Magadan" <?php echo $time_zone[0][0] == "Asia/Magadan" ? "selected" : ""; ?>>(UTC+12:00) Magadan</option>
										<option value="Pacific/Fiji" <?php echo $time_zone[0][0] == "Pacific/Fiji" ? "selected" : ""; ?>>(UTC+12:00) Marshall Is.</option>
										<option value="Asia/Magadan" <?php echo $time_zone[0][0] == "Asia/Magadan" ? "selected" : ""; ?>>(UTC+12:00) New Caledonia</option>
										<option value="Asia/Magadan" <?php echo $time_zone[0][0] == "Asia/Magadan" ? "selected" : ""; ?>>(UTC+12:00) Solomon Is.</option>
										<option value="Pacific/Auckland" <?php echo $time_zone[0][0] == "Pacific/Auckland" ? "selected" : ""; ?>>(UTC+12:00) Wellington</option>
										<option value="Pacific/Tongatapu" <?php echo $time_zone[0][0] == "Pacific/Tongatapu" ? "selected" : ""; ?>>(UTC+13:00) Nuku'alofa</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Admin Receiving Email ID</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="admin_receiving_email_id" id="admin_receiving_email_id" value="<?php echo $admin_receiving_email_id[0][0]; ?>" data-validation-engine="validate[required]" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Admin Sending Email ID</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="admin_sending_email_id" id="admin_sending_email_id" value="<?php echo $admin_sending_email_id[0][0]; ?>" data-validation-engine="validate[required,custom[email]]" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Pagination Number</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="pagination_number" id="pagination_number" value="<?php echo $pagination_number[0][0]; ?>" data-validation-engine="validate[required,custom[integer]]" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Paypal API Username</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="paypal_api_username" id="paypal_api_username" value="<?php echo $paypal_api_username[0][0]; ?>" data-validation-engine="validate[required]" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Paypal API Password</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="paypal_api_password" id="paypal_api_password" value="<?php echo $paypal_api_password[0][0]; ?>" data-validation-engine="validate[required]" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Paypal API Signature</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="paypal_api_signature" id="paypal_api_signature" value="<?php echo $paypal_api_signature[0][0]; ?>" data-validation-engine="validate[required]" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Payment Mode</label>
								<div class="col-sm-10">
									<input type="radio" class="form-control" name="payment_mode" id="payment_mode" value="Sandbox" data-validation-engine="validate[required]" <?php echo $payment_mode[0][0] == 'Sandbox' ? 'checked="checked"' : ''; ?> /> Sandbox
									<input type="radio" class="form-control" name="payment_mode" id="payment_mode" value="Live" data-validation-engine="validate[required]" <?php echo $payment_mode[0][0] == 'Live' ? 'checked="checked"' : ''; ?> /> Live
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Upload Logo</label>
								<div class="col-sm-10">
									<input type="file" name="site_logo" id="site_logo" <?php echo $site_logo[0][0] == '' ? 'data-validation-engine="validate[required]"' : ''; ?> />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Copyright Text</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="copyright_text" id="copyright_text" value="<?php echo $copyright_text[0][0]; ?>" data-validation-engine="validate[required]" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">2 Story Unit Price</label>
								<div class="col-sm-10">
									<div class="col-sm-10 input-group">
										<span class="input-group-addon"><i class="fa fa-dollar"></i></span>
										<input type="text" class="form-control" placeholder="Enter ..." name="story2_unit_price" id="story2_unit_price" value="<?php echo $story2_unit_price[0][0]; ?>" data-validation-engine="validate[required,custom[number]]" />
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">3 Story Unit Price</label>
								<div class="col-sm-10">
									<div class="col-sm-10 input-group">
										<span class="input-group-addon"><i class="fa fa-dollar"></i></span>
										<input type="text" class="form-control" placeholder="Enter ..." name="story3_unit_price" id="story3_unit_price" value="<?php echo $story3_unit_price[0][0]; ?>" data-validation-engine="validate[required,custom[number]]" />
									</div>
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