<?php
include "../includes/settings.php";
include "../includes/class_call_one_file.php";
//echo encode('Home@17!Smiles');
// check cokkie set or not //
if (isset($_COOKIE['homesmiles_administrator_username']) && isset($_COOKIE['homesmiles_administrator_password'])) {
	$_SESSION['administrator_username'] = $_COOKIE['homesmiles_administrator_username'];
	$_SESSION['administrator_password'] = $_COOKIE['homesmiles_administrator_password'];
	$rember = 'Yes';
}
if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == 'Sign In') {
	$administrator_username = $_REQUEST['administrator_username'];
	$administrator_password = $_REQUEST['administrator_password'];
	// Check Username alphanumeric or not alphanumeric //
	if (!preg_match("/([0-9a-z])*/", $administrator_username)) {
		$form->setError("administrator_username", "* Username not alphanumeric");
		$_SESSION['administrator_username'] = $administrator_username;
		$_SESSION['administrator_password'] = $administrator_password;
	} else {
		// Username Check //
		$admin_login_username_sql = $db->query("select * from " . $db->tbl_pre . "administrator_tbl where administrator_username='" . $administrator_username . "'", PDO::FETCH_BOTH);
		$admin_login_username_num = $db->total($admin_login_username_sql);
		if ($admin_login_username_num != 0) {
			$admin_login_row = $db->result($admin_login_username_sql);
			// Paswword Check //
			if ($administrator_password == decode($admin_login_row[0]['administrator_password'])) {
				// Successfull login //
				$form->num_errors = 0;
				$admin_login_row = $db->result($admin_login_password_sql);
			} else {
				// Password Fail //
				$form->setError("administrator_password", "* Invalid Password");
				$_SESSION['administrator_username'] = $administrator_username;
				$_SESSION['administrator_password'] = $administrator_password;
			}
		} else {
			// Username Fail //
			$form->setError("administrator_username", "* Invalid Username");
			$_SESSION['administrator_username'] = $administrator_username;
			$_SESSION['administrator_password'] = $administrator_password;
		}
		// Check any error ocuur or not //
		if ($form->num_errors == 0) {
			// Set cookie to last 100 days //
			if (isset($_REQUEST['remember'])) {
				setcookie('homesmiles_administrator_username', $_REQUEST['administrator_username'], time() + COOKIE_EXPIRE, COOKIE_PATH);
				setcookie('homesmiles_administrator_password', $_REQUEST['administrator_password'], time() + COOKIE_EXPIRE, COOKIE_PATH);
			}
			$_SESSION['administrator_username'] = "";
			$_SESSION['administrator_password'] = "";
			$_SESSION['admin_name'] = $admin_login_row[0]['administrator_name'];
			$_SESSION['admin_id'] = $admin_login_row[0]['administrator_id'];
			$_SESSION['admin_login'] = "Success";
			header("Location: index.php");
		} else {
			$_SESSION['value_array'] = $_POST;
			$_SESSION['error_array'] = $form->getErrorArray();
			header("Location: login.php");
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title><?php echo Site_Title ?> | Log in</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.4 -->
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<!-- Font Awesome Icons -->
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<!-- Theme style -->
	<link href="dist/css/AdminLTE.css" rel="stylesheet" type="text/css" />
	<!-- iCheck -->
	<link href="plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="login-page">
  	<div class="login-box">
  		<div class="login-logo">
  			<a href="index.php"><img src="<?php echo SITE_URL; ?>administrator/timthumb.php?src=<?php echo SITE_URL; ?><?php echo Site_Logo; ?>&w=320&h=100&zc=3"></a>
  		</div><!-- /.login-logo -->
  		<div class="login-box-body">
  			<p class="login-box-msg">Sign in to start your session</p>
  			<div class="box-body"><?php echo $_SESSION['admin_msg'];
$_SESSION['admin_msg'] = ""; ?>
  			</div>
  			<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
  				<div class="form-group <?php echo $form->error("administrator_username") == '' ? 'has-feedback' : 'has-warning'; ?>">
  					<?php echo $form->error("administrator_username"); ?>
  					<input type="text" class="form-control" placeholder="User Name" name="administrator_username" id="administrator_username" />
  					<span class="glyphicon glyphicon-user form-control-feedback"></span>
  				</div>
  				<div class="form-group <?php echo $form->error("administrator_password") == '' ? 'has-feedback' : 'has-warning'; ?>">
  					<?php echo $form->error("administrator_password"); ?>
  					<input type="password" class="form-control" placeholder="Password" name="administrator_password" id="administrator_password"/>
  					<span class="glyphicon glyphicon-lock form-control-feedback"></span>
  				</div>
  				<div class="row">
  					<div class="col-xs-8">
  						<div class="checkbox icheck">
  							<label>
  								<input type="checkbox" name="remeber" value="Yes"> Remember Me
  							</label>
  						</div>
  					</div><!-- /.col -->
  					<div class="col-xs-4">
  						<button type="submit" class="btn btn-primary btn-block btn-flat" name="submit" value="Sign In">Sign In</button>
  					</div><!-- /.col -->
  				</div>
  			</form>
  			<a href="password_forgot.php">I forgot my password</a><br>
  		</div><!-- /.login-box-body -->
  	</div><!-- /.login-box -->
  	<!-- jQuery 2.1.4 -->
  	<script src="plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
  	<!-- Bootstrap 3.3.2 JS -->
  	<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
  	<!-- iCheck -->
  	<script src="plugins/iCheck/icheck.min.js" type="text/javascript"></script>
  	<script>
  		$(function () {
  			$('input').iCheck({
  				checkboxClass: 'icheckbox_square-blue',
  				radioClass: 'iradio_square-blue',
              increaseArea: '20%' // optional
            });
  		});
  	</script>
  </body>
  </html>