<?php
include "includes/session.php";
$static_page_id = isset($_REQUEST['static_page_id']) ? $_REQUEST['static_page_id'] : 0;
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'add';
if ($_REQUEST['submit'] == 'Submit') {
	$static_page_name = $_REQUEST['static_page_name'];
	$static_page_slug = sanitize_title_with_dashes($static_page_name);
	$static_page_meta_title = $_REQUEST['static_page_meta_title'];
	$static_page_meta_descriptions = $_REQUEST['static_page_meta_descriptions'];
	$static_page_meta_keywords = $_REQUEST['static_page_meta_keywords'];
	$static_page_description = $_REQUEST['static_page_description'];
} else {
	$static_page_name = '';
	$static_page_slug = '';
	$static_page_meta_title = '';
	$static_page_meta_descriptions = '';
	$static_page_meta_keywords = '';
	$static_page_description = '';
}
if ($_REQUEST['submit'] == 'Submit') {
	$name_value = array('static_page_name' => rep($static_page_name), 'static_page_slug' => rep($static_page_slug), 'static_page_description' => rep($static_page_description), 'static_page_meta_title' => rep($static_page_meta_title), 'static_page_meta_descriptions' => rep($static_page_meta_descriptions), 'static_page_meta_keywords' => rep($static_page_meta_keywords));
	// Static Page Add //
	if ($action == "add") {
		$static_page->static_page_add($name_value, "Static Page added successfully. Please enter another.", "Sorry, nothing is added.", "Sorry, name is already added. Please use another name.");
	}
	// Static Page Edit //
	elseif ($action == "edit") {
		$static_page->static_page_edit($name_value, $static_page_id, "Static Page updated successfully.", "Sorry, nothing is updated.", "Sorry, name is already added. Please use another name.");
	}
}
// Show Value When Try To Update Static Page //
elseif ($action == "edit") {
	$static_page_array = $static_page->static_page_display($db->tbl_pre . "static_page_tbl", array(), "WHERE static_page_id=" . $static_page_id . "");
}
//echo $box_image_total_count;
include "includes/header.php";
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Manage Static Page
		</h1>
		<ol class="breadcrumb">
			<li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active"><?php echo $action == 'add' ? 'Add' : 'Edit'; ?> Static Page</li>
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
						<h3 class="box-title"><?php echo $action == 'add' ? 'Add' : 'Edit'; ?> Static Page</h3>
					</div><!-- /.box-header -->
					<!-- form start -->
					<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
						<input type="hidden" name="action" id="action" value="<?php echo $action; ?>" />
						<input type="hidden" name="static_page_id" id="static_page_id" value="<?php echo $static_page_id; ?>" />
						<div class="box-body">
							<?php echo $_SESSION['static_page_msg'];
$_SESSION['static_page_msg'] = ""; ?>
							<div class="form-group">
								<label class="col-sm-2 control-label">Name</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="static_page_name" id="static_page_name"  data-validation-engine="validate[required]" value="<?php echo repc($static_page_array[0]['static_page_name']); ?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Meta Title</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" placeholder="Enter ..." name="static_page_meta_title" id="static_page_meta_title"  data-validation-engine="validate[condRequired[static_page_display_as_page1]]" value="<?php echo repc($static_page_array[0]['static_page_meta_title']); ?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Mets Descriptions</label>
								<div class="col-sm-10">
									<textarea class="form-control" placeholder="Enter ..." name="static_page_meta_descriptions" id="static_page_meta_descriptions"  data-validation-engine="validate[condRequired[static_page_display_as_page1]]"><?php echo repc($static_page_array[0]['static_page_meta_descriptions']); ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Meta Keywords</label>
								<div class="col-sm-10">
									<textarea class="form-control" placeholder="Enter ..." name="static_page_meta_keywords" id="static_page_meta_keywords"  data-validation-engine="validate[condRequired[static_page_display_as_page1]]"><?php echo repc($static_page_array[0]['static_page_meta_keywords']); ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Description</label>
								<div class="col-sm-10">
									<textarea class="form-control ckeditor" placeholder="Enter ..." name="static_page_description" id="static_page_description"  data-validation-engine="validate[condRequired[static_page_display_as_page1]]"><?php echo repc($static_page_array[0]['static_page_description']); ?></textarea>
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