	<footer class="shadow">

		<div class="container">

			<div class="row">

				<div class="col-md-4 col-sm-3">

					<div class="footer-col">

						<h3>Doreme</h3>

						<ul>

							<li><a href="<?php echo Site_URL ?>">Home</a></li>

							<li><a href="<?php echo Site_URL ?>account-setting.php">Profile</a></li>

							<li><a href="<?php echo Site_URL ?>notifications.php">Notification</a></li>

							<li><a href="<?php echo Site_URL ?>shopping-bag.php">Bag</a></li>

							<li><a href="<?php echo Site_URL ?>contact.php">About Us</a></li>

							<li><a href="<?php echo Site_URL ?>feedback.php">Feedback</a></li>

						</ul>

					</div>

				</div>								

				<div class="col-md-4 col-sm-4">

					<div class="footer-col policy-col">

						<h3>Our Policies</h3>

						<ul>

							<li><a href="<?php echo Site_URL ?>terms_condition.php">Terms and conditions</a></li>

							<li><a href="<?php echo Site_URL ?>privacy_policy.php">Privacy Policy</a></li>

						</ul>

					</div>

				</div>

				<div class="col-md-4 col-sm-5">

					<div class="footer-col dwnl-app">

						<h3>Download The App</h3>

						<div class="app-store">

							<a href="#" target="_blank"><img src="images/google_store.png"></a>

							<a href="#" target="_blank"><img src="images/app_store.png"></a>

						</div>

						<div class="social">

							<a href="#" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>

							<a href="#" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>

							<a href="#" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a>

						</div>

					</div>

				</div>

			</div>

		</div>

	</footer>

</body>

<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>

<script type="text/javascript" src="js/bootstrap.min.js"></script>

<script type="text/javascript" src="js/owl.carousel.js"></script>

<script type="text/javascript" src="js/slick.min.js"></script>

<script type="text/javascript" src="js/jquery.magnific-popup.min.js"></script>

<script type="text/javascript" src="js/jquery.bootstrap-touchspin.min.js"></script>

<script type="text/javascript" src="js/jquery.matchHeight-min.js"></script>

<script type="text/javascript" src="js/jquery.mCustomScrollbar.js"></script>

<script src="https://cdn.jsdelivr.net/sweetalert2/5.3.8/sweetalert2.js"></script>

<link href="https://cdn.jsdelivr.net/sweetalert2/5.3.8/sweetalert2.css" rel="stylesheet"/>

<script type="text/javascript" src="js/main.js"></script>

<script type="text/javascript" src="js/custom.js"></script>

</html>
<?php
$page_name = basename($_SERVER['PHP_SELF']); 
if ($page_name=="product.php") {
$pages = ceil(count($product_array)/4);	 ?>
<script type="text/javascript">
$(document).ready(function() {
 
	//$("#results").load("ajax/product_list.php");  //initial page number to load
		   $.ajax({
           type: "POST",
           url: 'ajax/product_list.php',          
          data: $('#product_list').serialize() , // serializes the form's elements.       
           success: function(data)
           {
           	$("#results").html(data);
	 
                },
        error: function (e) {
            alert(e);
        },

         });


	$(".pagination").bootpag({
	   total: <?php echo $pages; ?>,
	   page: 1,
	   maxVisible: 5 
	}).on("page", function(e, num){
		e.preventDefault(); 
		var data= $('#product_list').serialize() + "&page=" + num;

		$("#results").prepend('<div class="loading-indication"><img src="ajax-loader.gif" /> Loading...</div>');
		   $.ajax({
           type: "POST",
           url: 'ajax/product_list.php',          
          data: data , // serializes the form's elements.       
           success: function(data)
           {
           	$("#results").html(data);
	 
                },
        error: function (e) {
            alert(e);
        },

         });
	});

});
</script>
<?php } ?>
<style type="text/css">

.errMsg{

	color:#DE496C;

}

</style>