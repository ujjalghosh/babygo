<?php 
include "../../includes/settings.php";
include "../../includes/class_call_one_file.php";

?>

<?php
$product_group_array = $product_group->product_group_display($db->tbl_pre . "product_group_tbl", array(), "WHERE product_category_id='".$_POST['id']."' and product_group_status='Active'");
	?>								
			<option value="">-- Select Product group --</option>
				<?php  for($l=0; $l<count($product_group_array); $l++) {    ?>
	<option value="<?php echo $product_group_array[$l]["product_group_id"]; ?>" ><?php echo $product_group_array[$l]["product_group_name"]; ?></option>
	<?php } ?>
<?php// } ?>