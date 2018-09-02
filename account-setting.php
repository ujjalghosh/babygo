<?php include 'header.php'; ?>

	<div class="main-con purple-bg">
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<div class="profile-pic-con">
						<div class="profile-pic"><img src="images/profile-pic.png"></div>
						<p>Welcome Mr. <?php echo $_SESSION['customer_name']; ?></p>
					</div>
				</div>
				<div class="col-md-8">
					<div class="acc-setting-wrap">
						<div class="btn-grp clearfix">
							<a href="wishlist.php"><button class="gray-btn" type="button"><i class="fa fa-heart" aria-hidden="true"></i> Wishlist</button></a>
							<a href="user-dashboard.php"><button class="yellow-btn" type="submit">Order Details</button></a>
						</div>
						<div class="i-box acc-settings">
							<h4>Account Settings</h4>
							<div class="row">
								<div class="ibox-row">
									<div class="col-md-3"><label>Company Details</label></div>
									<div class="col-md-9"><div class="line">&nbsp; <a class="edit" href="profile-edit.php"><i class="fa fa-angle-right" aria-hidden="true"></i></a></div></div>
								</div>
								<div class="ibox-row">
									<div class="col-md-3"><label>Edit Profile</label></div>
									<div class="col-md-9"><div class="line">&nbsp; <a class="edit" href="profile-edit.php"><i class="fa fa-pencil" aria-hidden="true"></i></a></div></div>
								</div>
								<div class="ibox-row">
									<div class="col-md-3"><label>Change Password</label></div>
									<div class="col-md-9"><div class="line">&nbsp; <a class="edit" href="reset-password.php"><i class="fa fa-pencil" aria-hidden="true"></i></a></div></div>
								</div>
							</div>
						</div>
					</div>			
				</div>
			</div>
		</div>
	</div>

<?php include 'footer.php'; ?>
