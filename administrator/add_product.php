<?php
include "includes/session.php";
$product_id = isset($_REQUEST['Product_id']) ? $_REQUEST['Product_id'] : 0;
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'add';
if ($_REQUEST['submit'] == 'Submit') {
	$product_id=$_REQUEST['product_id'];
	$style_no = $_REQUEST['style_no'];
	$category_id = $_REQUEST['category_id'];
	 
	$group_id = implode(',',$_REQUEST['group_id']); 
	$size_id = $_REQUEST['size_id'];
	$style_set_qty = $_REQUEST['style_set_qty'];
	$style_mrp_for_size = $_REQUEST['style_mrp_for_size'];
 
	$product_name = $_REQUEST['product_name'];
	$style_decription = $_REQUEST['style_decription'];
	//$style_set_qty_mapping = $_REQUEST['style_set_qty_mapping'];
	$style_color_qty=$_REQUEST['style_color_qty'];
	$style_list_image=$_REQUEST['style_list_image'];
} else {
	$style_no = '';
	$category_id = '';
	$group_id = '';
	$product_name='';
	$style_decription = '';
	$style_set_qty_mapping = '';
	$style_color_qty='';
	$style_list_image='';
}
if ($_REQUEST['submit'] == 'Submit') {
	$name_value = array('style_no' => rep($style_no), 'category_id' => rep($category_id), 'group_id' => rep($group_id),'size_id' => rep($size_id),'style_set_qty' => rep($style_set_qty),'style_mrp_for_size' => rep($style_mrp_for_size),'product_name'=> rep($product_name), 'style_decription' => rep($style_decription),   'style_color_qty'=>rep($style_color_qty));
	// Product Add //
	if ($action == "add") {
		$Product->Product_add($name_value, "Product added successfully. Please enter another.", "Sorry, nothing is added.", "Sorry, email id is already added. Please use another email id.");
	}
	// Product Edit //
	elseif ($action == "edit") {
		$Product->Product_edit($name_value, $product_id, "Product updated successfully.", "Sorry, nothing is updated.", "Sorry, email id is already added. Please use another email id.");
	}
}
// Show Value When Try To Update Product //product_idPrimary
elseif ($action == "edit") {
	$Product_array = $Product->Product_display($db->tbl_pre . "product_tbl", array(), "WHERE product_id=" . $product_id . "");
}

include "includes/header.php";
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Manage Product
		</h1>
		<ol class="breadcrumb">
			<li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active"><?php echo $action == 'add' ? 'Add' : 'Edit'; ?> Product</li>
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
						<h3 class="box-title"><?php echo $action == 'add' ? 'Add' : 'Edit'; ?> Product</h3>
					</div><!-- /.box-header -->
					<!-- form start -->
					<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
						<input type="hidden" name="action" id="action" value="<?php echo $action; ?>" />
						<input type="hidden" name="product_id" id="product_id" value="<?php echo $product_id; ?>" />
						<div class="box-body">
							<?php echo $_SESSION['product_msg'];
							$_SESSION['product_msg'] = ""; ?>

							<div class="form-group">
								<label class="col-sm-2 control-label">Style NO</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="style_no" id="style_no"  data-validation-engine="validate[required]" value="<?php echo repc($Product_array[0]['style_no']); ?>" />
								</div>
							</div>
 
							<div class="form-group">
								<label class="col-sm-2 control-label">Category</label>
								<div class="col-sm-10">
									<select name="category_id" id="category_id" class="form-control select2" data-validation-engine="validate[required]"  >
<?php
$product_category_array = $product_category->Product_category_display($db->tbl_pre . "category_tbl", array(), "WHERE category_status='Active'"); ?>									
				 <option value="">-- Select Product Type --</option>
						<?php  for($l=0; $l<count($product_category_array); $l++) {    ?>
	<option value="<?php echo $product_category_array[$l]["category_id"]; ?>" <?php echo $product_category_array[$l]['category_id']==$Product_array[0]['category_id'] ? 'selected' : ''; ?>><?php echo $product_category_array[$l]["category_name"]; ?></option>
	<?php } ?>										  
					</select>



								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Group</label>
								<div class="col-sm-10">
<select name="group_id[]" id="group_id" multiple  class="form-control select2" data-validation-engine="validate[required]"  >

<?php
$product_group_array = $product_group->product_group_display($db->tbl_pre . "product_group_tbl", array(), "WHERE product_category_id='".$Product_array[0]['category_id']."' and product_group_status='Active'");
$group_id= (explode(",",$Product_array[0]['group_id']));
	?>								
			<option value="">-- Select Product group --</option>
				<?php  for($l=0; $l<count($product_group_array); $l++) {    ?>
	<option value="<?php echo $product_group_array[$l]["product_group_id"]; ?>" <?php echo in_array($product_group_array[$l]['product_group_id'], $group_id , TRUE)    ? 'selected' : ''; ?>><?php echo $product_group_array[$l]["product_group_name"]; ?></option>
	<?php } ?>
<?php// } ?>
</select>

								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Product Name</label>
								<div class="col-sm-10">
									<input type="text" class="form-control  " placeholder="Enter ..." name="product_name" id="product_name"  data-validation-engine="validate[required]" value="<?php echo repc($Product_array[0]['product_name']); ?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Size</label>
								<div class="col-sm-10">
<select name="size_id" id="size_id" class="form-control select2" data-validation-engine="validate[required]"  >

<?php
$Product_size_array = $Product_size->Product_size_display($db->tbl_pre . "product_size_tbl", array(), "WHERE size_status='Active'");
	?>								
			<option value="">-- Select Product Size --</option>
				<?php  for($l=0; $l<count($Product_size_array); $l++) {    ?>
	<option value="<?php echo $Product_size_array[$l]["product_size_id"]; ?>" <?php echo $Product_size_array[$l]['product_size_id']==$Product_array[0]['size_id'] ? 'selected' : ''; ?>><?php echo $Product_size_array[$l]["size_description"]; ?></option>
	<?php } ?>
<?php// } ?>
</select>

								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Style Set Qty</label>
								<div class="col-sm-10">
									<input type="text" class="form-control  " placeholder="Enter ..." name="style_set_qty" id="style_set_qty"  data-validation-engine="validate[required]" value="<?php echo repc($Product_array[0]['style_set_qty']); ?>" />
								</div>
							</div>
 
							<div class="form-group">
								<label class="col-sm-2 control-label">MRP For Size</label>
								<div class="col-sm-10">
									<input type="text" class="form-control  " placeholder="Enter ..." name="style_mrp_for_size" id="style_mrp_for_size"  data-validation-engine="validate[required]" value="<?php echo repc($Product_array[0]['style_mrp_for_size']); ?>" />
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label">Style Decription</label>
								<div class="col-sm-10">						
									<textarea class="form-control ckeditor" placeholder="Enter ..." name="style_decription" id="style_decription"><?php echo repc($Product_array[0]['style_decription']); ?></textarea>
								</div>
							</div>
<!-- 							<div class="form-group">
	<label class="col-sm-2 control-label">Set Qty Mapping</label>
	<div class="col-sm-10">
		<input type="text" class="form-control  " placeholder="Enter ..." name="style_set_qty_mapping" id="style_set_qty_mapping"  data-validation-engine="validate[required]" value="<?php echo repc($Product_array[0]['style_set_qty_mapping']); ?>" />
	</div>
</div> -->
							<div class="form-group">
								<label class="col-sm-2 control-label">Colour Qty</label>
								<div class="col-sm-10">
									<input type="text" class="form-control " placeholder="Enter ..." name="style_color_qty" id="style_color_qty"  data-validation-engine="validate[required]" value="<?php echo repc($Product_array[0]['style_color_qty']); ?>" />
								</div>
							</div>


						<?php 
							if($action == 'edit'){
						?>
						<div class="form-group">
								<label class="col-sm-2 control-label">Listing Image</label>
								<div class="col-sm-10">
								<input type="file"  placeholder="Enter ..." name="style_list_image" id="style_list_image"   />
									
								</div>
							</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Uploaded Listing Image</label>
									<div class="col-sm-10">
										<div class="col-sm-2">
											<img src="<?php echo Site_URL.'images/product_list/'.$Product_array[0]['style_list_image']; ?>" width="100px">
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Image Set</label>
									<div class="col-sm-6">
										<input type="file" name="style_color_image[]" id="style_color_image" multiple="multiple" />
									</div>
								</div>
								<div class="form-group" id="uploaded_reports">
									<label class="col-sm-2 control-label">Uedpload Image Set</label>
									<div class="col-sm-10">
									<?php
										$vehicle_additional_images = $Product->Product_display($db->tbl_pre . "product_images_tbl", array(), "WHERE product_id=".$product_id);
			$path1='images/product_list/set_images/';
										for ($row = 0; $row < count($vehicle_additional_images); $row++) {
											echo '<div class="col-sm-2" id="'.$vehicle_additional_images[$row]['image_id'].'"><img src="'.Site_URL.$path1.$vehicle_additional_images[$row]['style_color_image'].'" width="100px" height="100px"><div class="btn-danger" style="padding-top:5px; padding-bottom: 5px; text-align: center; color: blue; cursor: pointer" onclick="remove_product_images(\''.$vehicle_additional_images[$row]['style_color_image'].'\',\''.$vehicle_additional_images[$row]['image_id'].'\')"> Remove</div> </div>';
										}
									?>
									</div>
								</div>



								<div class="form-group">
									<label class="col-sm-2 control-label">Other Color Images</label>
									<div class="col-sm-6">
										<input type="file" name="listing_image[]" id="listing_image" multiple="multiple" />
									</div>
								</div>
								<div class="form-group" id="uploaded_reports">
									<label class="col-sm-2 control-label">Uedpload Other Color Images</label>
									<div class="col-sm-10">
									<?php
										$Other_additional_images = $Product->Product_display($db->tbl_pre . "color_image_tbl", array(), "WHERE product_id=".$product_id);
			$original = 'images/product_list/other_color/';
										for ($row = 0; $row < count($Other_additional_images); $row++) {
											echo '<div class="col-sm-2" id="'.$Other_additional_images[$row]['color_image_id'].'"><img src="'.Site_URL.$original.$Other_additional_images[$row]['listing_image'].'" width="100px" height="100px"><div class="btn-danger" style="padding-top:5px; padding-bottom: 5px; text-align: center; color: blue; cursor: pointer" onclick="remove_product_color_images(\''.$Other_additional_images[$row]['listing_image'].'\',\''.$Other_additional_images[$row]['color_image_id'].'\')"> Remove</div> </div>';
										}
									?>
									</div>
								</div>



						<?php
							}else{
						?>
							<div class="form-group">
								<label class="col-sm-2 control-label">Listing Image</label>
								<div class="col-sm-10">
								<input type="file"  placeholder="Enter ..." name="style_list_image" id="style_list_image"  data-validation-engine="validate[required]" />
									
								</div>
							</div>

 							<div class="form-group">
								<label class="col-sm-2 control-label"> Image Set</label>
								<div class="col-sm-10">
									<input type="file" class="form-control  " placeholder="Enter ..." name="style_color_image[]" id="style_color_image" multiple="multiple" data-validation-engine="validate[required]"  />
								</div>
							</div>

							 <div class="form-group">
								<label class="col-sm-2 control-label"> Other Color Images</label>
								<div class="col-sm-10">
									<input type="file" class="form-control  " placeholder="Enter ..." name="listing_image[]" id="listing_image" multiple="multiple"   />
								</div>
							</div>
						<?php }	?>



						 
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
<script type="text/javascript">

</script>
  