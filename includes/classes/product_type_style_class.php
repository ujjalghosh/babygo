<?php
class justborn_product_type_style {
	public $recperpage;
	public $url;
	public $db;
	public function __construct() {
		global $recperpage;
		global $url;
		global $db;
		$this->recperpage = $recperpage;
		$this->url = $url;
		$this->db = $db;
	}
	// product_type_style Add Function //
	public function product_type_style_add($product_type_style_array, $product_type_style_success_message, $product_type_style_unsuccess_message, $product_type_style_duplicate_message) {
		$product_type_style_duplicate_check_num = $this->product_type_style_check($product_type_style_id);
		if ($product_type_style_duplicate_check_num == 0) {
			$product_type_style_add = $this->db->insert('product_type_style_tbl', $product_type_style_array);
			if ($product_type_style_add['affectedRow'] > 0) {
				$product_type_style_id = $product_type_style_add['insertedId'];

   if (isset($_REQUEST['item']))
    {
    for ($pr = 0; $pr < $_REQUEST['item']; $pr++) {
    	$image_text = $_REQUEST['image_text'.$pr];
 
				if ($_FILES['style_image'. $pr]['size'] > 0) {
						$original = 'images/product_style/';
						$banner_title = $_FILES['style_image'. $pr]['name'];
						$banner_tmp = $_FILES['style_image'. $pr]['tmp_name'];
						$banner_size = $_FILES['style_image'. $pr]['size'];
						$banner_type = $_FILES['style_image'. $pr]['type'];

						$banner_title_saved = str_replace("&", "and", $product_type_style_id . "_" . $banner_title);
						$banner_title_saved = str_replace(" ", "_", $product_type_style_id . "_" . $banner_title);
						$banner_img = $original . $banner_title_saved;
					//original path
						$banner_img1 = "../" . $banner_img;
						move_uploaded_file($banner_tmp, $banner_img1);
					//image upload
		$this->db->insert("product_type_image_tbl", array('product_type_style_id' =>$product_type_style_id, 'image_text' =>$image_text, 'image' =>$banner_title_saved ));
				}


}
	}


				// Success Message For Insert a New product_type_style //
				$_SESSION['product_type_style_msg'] = messagedisplay($product_type_style_success_message, 1);
				header('location: add_product_type_style.php');
				exit();
			} else {
				// Message For Nothing Insert //
				$_SESSION['product_type_style_msg'] = messagedisplay($product_type_style_unsuccess_message, 3);
			}
		} else {
			$_SESSION['product_type_style_msg'] = messagedisplay($product_type_style_duplicate_message, 2);
		}
	}
	// product_type_style Duplicate Check Function //
	public function product_type_style_check($product_type_style_id = '') {
		// Check Duplicate product_type_style Name //
		$product_type_style_duplicate_check_sql = $this->db->query("select * from " . $this->db->tbl_pre . "product_type_style_tbl where product_type='" . rep($_REQUEST['product_type']) . "' and product_for='" . $product_for . "'");
		return $this->db->total($product_type_style_duplicate_check_sql);
	}
	// product_type_style Edit Function //
	public function product_type_style_edit($product_type_style_array, $product_type_style_id, $product_type_style_success_message, $product_type_style_unsuccess_message, $product_type_style_duplicate_message) {
		$product_type_style_duplicate_check_num = $this->product_type_style_check($product_type_style_id);
		if ($product_type_style_duplicate_check_num == 0) {
			$product_type_style_update = $this->db->update('product_type_style_tbl', $product_type_style_array, "product_type_style_id='" . $product_type_style_id . "'");
			if ($product_type_style_update['affectedRow'] > 0) {
				// Success Message For Update a Existing product_type_style //
				$_SESSION['product_type_style_msg'] = messagedisplay($product_type_style_success_message, 1);
				header('location:' . $_SESSION['product_type_style_manage_url']);
				exit();
			} else {
				// Message For Nothing Update //
				$_SESSION['product_type_style_msg'] = messagedisplay($product_type_style_unsuccess_message, 3);
				header('location:' . $_SESSION['product_type_style_manage_url']);
				exit();
			}
		} else {
			$_SESSION['product_type_style_msg'] = messagedisplay($product_type_style_duplicate_message, 2);
			header('product_type_style:' . $_SESSION['product_type_style_manage_url']);
			exit();
		}
	}
	// product_type_style Display Function //
	public function product_type_style_display($sTable = '', $aColumns = '', $sWhere = '', $sLimit = '', $sOrder = '') {
		$product_type_style_query = array('tbl_name' => $sTable, 'field' => $aColumns, 'condition' => $sWhere, 'limit' => $sLimit, 'orderby' => $sOrder);
		$product_type_style_sql = $this->db->select($product_type_style_query);
		$product_type_style_array = $this->db->result($product_type_style_sql);
		return $product_type_style_array;
	}

	function product_type_style_image_display($sTable = '', $aColumns = '', $sWhere = '', $sLimit = '', $sOrder = '') {
		$banner_query=array( 'tbl_name' => $sTable, 'field' => $aColumns, 'condition' => $sWhere, 'limit' => $sLimit, 'orderby' => $sOrder);
		$banner_sql = $this->db->select($banner_query);
		$banner_array = $this->db->result($banner_sql);
		return $banner_array;
	}

	// product_type_style Status Update Function //
	public function product_type_style_status_update($product_type_style_manage_url) {
		$product_type_style_id = $_REQUEST['cid'];
		if ($_REQUEST['current_status'] == 'Inactive') {
			$product_style_status = 'Active';
		} else {
			$product_style_status = 'Inactive';
		}
		$this->db->update('product_type_style_tbl', array('product_style_status' => ($product_style_status)), "style_id='" . $product_type_style_id . "'");
		$_SESSION['product_type_style_msg'] = messagedisplay('product type style\'s Status is updated successfully', 1);
		header('location: ' . $product_type_style_manage_url);
		exit();
	}
	// product_type_style Delete Function //
	public function product_type_style_delete($product_type_style_manage_url) {
		$product_type_style_id = $_REQUEST['cid'];

			$product_type_style_delete = $this->db->delete("product_type_style_tbl", array("style_id" => $product_type_style_id));
			if ($product_type_style_delete['affectedRow'] > 0) {
				$product_type_style_image_delete = $this->db->delete("product_type_image_tbl", array("product_type_style_id" => $product_type_style_id));
				$_SESSION['product_type_style_msg'] = messagedisplay('product_type_style details deleted successfully', 1);
			} else {
				$_SESSION['product_type_style_msg'] = messagedisplay('Nothing is deleted successfully', 2);
			}
		
		header('location: ' . $product_type_style_manage_url);
		exit();
	}
}
?>