<?php include 'header.php'; ?>

	<div class="main-con sign-in-page">
		<div class="container">
			<div class="sign-in-con">
				<ul class="nav nav-tabs sign-in-tab">
				    <li class="active"><a data-toggle="tab" href="#tab-1">Sign In</a></li>
				    <li><a data-toggle="tab" href="#tab-2">Sign Up</a></li>
				  </ul>

				  <div class="tab-content">
				    <div id="tab-1" class="tab-pane fade in active sign-in-content">
				    	  <form action="" method="post" id="login-form" novalidate="novalidate">
				    		<input type="text" name="customer_email" id="customer_email" placeholder="USERNAME">
				    		<div class="input-grp">
				    			<input type="text" name="customer_password" id="user-password" placeholder="PASSWORD"><a href="javascript:void(0)" id="togglePasswordField" ><i class="fa fa-eye" aria-hidden="true"></i></a>
				    		</div>
				    		<input class="border-btn" type="submit" value="Sign In">
				    		<p class="sign-tip text-center"><a href="reset-password.php">Forgot Password?</a></p>	    		
				    	</form>
				    </div>
				    <div id="tab-2" class="tab-pane fade sign-up-content">
				    	  <form action="" method="post" id="register-form" novalidate="novalidate">
				    		<div class="input-holder">
				    			<label>Name</label>
				    			<input type="text" name="customer_name" id="customer_name">
				    		</div>
				    		<div class="input-holder">
				    			<label>Mobile</label>
				    			<input type="text" name="customer_phone_number" id="customer_phone_number">
				    		</div>
				    		<div class="input-holder">
				    			<label>Email</label>
				    			<input type="email" name="customer_email" id="customer_email">
				    		</div>
				    		<div class="input-holder">
				    			<label>Password</label>
				    			<input type="password" name="customer_password" id="customer_password">
				    		</div>
				    		<div class="input-holder">
				    			<label>Confirm Password</label>
				    			<input type="password"  name="password_confirm"  id="password_confirm">
				    		</div>
				    		<input class="border-btn" type="submit" value="Sign Up">
				    		<p class="sign-tip text-center">Already Have an Account? <a id="gt-si" href="#">SIGN IN</a></p>	    		
				    	</form>
				    </div>
				  </div>
			</div>
		</div>
	</div>

	<a class="skip-btn" href="<?php echo Site_URL; ?>">Skip</a>

<?php include 'footer.php'; ?>
