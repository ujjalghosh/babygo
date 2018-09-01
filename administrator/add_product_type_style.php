<?php
include "includes/session.php";
$product_type_style_id = isset($_REQUEST['product_type_style_id']) ? $_REQUEST['product_type_style_id'] : 0;
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'add';
if ($_REQUEST['submit'] == 'Submit') {
	$product_for =$_REQUEST['product_for'];
	$product_type = $_REQUEST['product_type'];
 	$product_style = $_REQUEST['product_style'];
} else {
	$product_for='';
	$product_type = '';
	$product_style='';
}
if ($_REQUEST['submit'] == 'Submit') {
	$name_value = array('product_for' => rep($product_for),'product_type' => rep($product_type),'product_style' => rep($product_style) );
	// Product_type Add //
	if ($action == "add") {
		$Product_type_style->Product_type_style_add($name_value, "Product type style added successfully. Please enter another.", "Sorry, nothing is added.", "Sorry, Product type style name is already added. Please use another name.");
	}
	// Product_type Edit //
	elseif ($action == "edit") {
		$Product_type_style->Product_type_style_edit($name_value, $product_type_style_id, "Product type style updated successfully.", "Sorry, nothing is updated.", "Sorry, Product type style is already added. Please use another name.");
	}
}
// Show Value When Try To Update Product_type //
elseif ($action == "edit") {
	$Product_type_style_array = $Product_type_style->Product_type_style_display($db->tbl_pre . "product_type_style_tbl", array(), "WHERE style_id=" . $product_type_style_id . "");
	$style_image=$Product_type_style->product_type_style_image_display($db->tbl_pre."product_type_image_tbl",array(),"WHERE product_type_style_id=".$product_type_style_id."");
	
}
include "includes/header.php";
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Manage Product Type Style
		</h1>
		<ol class="breadcrumb">
			<li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active"><?php echo $action == 'add' ? 'Add' : 'Edit'; ?> Product Type Style</li>
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
						<h3 class="box-title"><?php echo $action == 'add' ? 'Add' : 'Edit'; ?> Product Type Style</h3>
					</div><!-- /.box-header -->
					<!-- form start -->
					<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
					<input type="hidden" name="item" id="item" value="0">
						<input type="hidden" name="action" id="action" value="<?php echo $action; ?>" />
						<input type="hidden" name="product_type_style_id" id="product_type_style_id" value="<?php echo $product_type_style_id; ?>" />
						<div class="box-body">
							<?php echo $_SESSION['product_type_style_msg'];
							$_SESSION['product_type_style_msg'] = ""; ?>

								 <div class="form-group">
								<label class="col-sm-2 control-label">Style For</label>
								<div class="col-sm-10">
									<select name="product_for" id="product_for" class="form-control select2" data-validation-engine="validate[required]"  >
										<option value="">-- Select Product Type --</option>
										<option value="girl">Girl</option>
										<option value="boy">Boy</option>
										  
									</select>
								</div>
							</div>


							<div class="form-group">
								<label class="col-sm-2 control-label">Product Type</label>
								<div class="col-sm-10">
									<select name="product_type" id="product_type" class="form-control select2" data-validation-engine="validate[required]"  >
										<option value="">-- Select Product Type --</option>
										<?php
$Product_type_array = $Product_type->Product_type_display($db->tbl_pre . "product_type_tbl", array(), "WHERE product_type_status='Active'");
for ($row = 0; $row < count($Product_type_array); $row++) {
	$dropdown_select = $Product_type_style_array[0]['product_type'] == $Product_type_array[$row]['product_type_id'] ? 'selected="selected"' : '';
	echo '<option value="' . $Product_type_array[$row]['product_type_id'] . '" ' . $dropdown_select . '>' . $Product_type_array[$row]['product_type_name'] . '</option>';
}
?>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label">Product Style</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="product_style" id="product_style"  data-validation-engine="validate[required]" value="<?php echo $Product_type_style_array[0]['product_style']; ?>" />
								</div>
							</div>



        <div class="col-xs-12">
            <div class="col-md-12" >
                <h3> Style Image</h3>
                <div id="field">
                <div id="field0">

<br>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="image_text">Image Text</label>  
  <div class="col-md-5">
  <input id="image_text" name="image_text0" type="text" placeholder="" class="form-control input-md">
    
  </div>
</div>
       <!-- File Button --> 
<div class="form-group">
  <label class="col-md-4 control-label" for="style_image">Image</label>
  <div class="col-md-4">
  <input type="file" name="style_image0" id="style_image1" <?php echo $course_array[0]['style_image'] == '' ? 'data-validation-engine="validate[required]"' : ''; ?> />
              
     <div id="style_imagedisplay"></div>
  </div>
</div>

</div>
</div>
<!-- Button -->
<div class="form-group">
  <div class="col-md-4">
    <button id="add-more" name="add-more" class="btn btn-primary ">Add More</button>
  </div>
</div>
<br><br>
              
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