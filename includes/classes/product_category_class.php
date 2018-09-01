<?php
class babygo_product_category {
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
	public function product_category_add($product_category_array, $product_type_style_success_message, $product_type_style_unsuccess_message, $product_type_style_duplicate_message) {
		$product_type_style_duplicate_check_num = $this->product_type_style_check($category_id);
		if ($product_type_style_duplicate_check_num == 0) {
			$product_type_style_add = $this->db->insert('category_tbl', $product_category_array);
			if ($product_type_style_add['affectedRow'] > 0) {
				$category_id = $product_type_style_add['insertedId'];

 
 
				if ($_FILES['category_image']['size'] > 0) {
						$original = 'images/product_category/';
						$banner_title = $_FILES['category_image']['name'];
						$banner_tmp = $_FILES['category_image']['tmp_name'];
						$banner_size = $_FILES['category_image']['size'];
						$banner_type = $_FILES['category_image']['type'];

						$banner_title_saved = str_replace("&", "and", $category_id . "_" . $banner_title);
						$banner_title_saved = str_replace(" ", "_", $category_id . "_" . $banner_title);
						$banner_img = $original . $banner_title_saved;
					//original path
						$banner_img1 = "../" . $banner_img;
						move_uploaded_file($banner_tmp, $banner_img1);
					//image upload
		$this->db->update("category_tbl", array('category_image' =>$banner_title_saved),"category_id='" . $category_id . "'");
				}

 
 


				// Success Message For Insert a New product_type_style //
				$_SESSION['product_category_msg'] = messagedisplay($product_type_style_success_message, 1);
				header('location: add_product_category.php');
				exit();
			} else {
				// Message For Nothing Insert //
				$_SESSION['product_category_msg'] = messagedisplay($product_type_style_unsuccess_message, 3);
			}
		} else {
			$_SESSION['product_category_msg'] = messagedisplay($product_type_style_duplicate_message, 2);
		}
	}
	// product_type_style Duplicate Check Function //
	public function product_type_style_check($category_id = '') {
		// Check Duplicate product_type_style Name //
		$product_type_style_duplicate_check_sql = $this->db->query("select * from " . $this->db->tbl_pre . "category_tbl where category_name='" . rep($_REQUEST['category_name']) . "' and category_id!='" . $category_id . "'");
		return $this->db->total($product_type_style_duplicate_check_sql);
	}
	// product_type_style Edit Function //
	public function product_type_style_edit($product_category_array, $category_id, $product_type_style_success_message, $product_type_style_unsuccess_message, $product_type_style_duplicate_message) {
		$product_type_style_duplicate_check_num = $this->product_type_style_check($category_id);
		if ($product_type_style_duplicate_check_num == 0) {
			$product_type_style_update = $this->db->update('category_tbl', $product_category_array, "category_id='" . $category_id . "'");
			if ($product_type_style_update['affectedRow'] > 0) {
				// Success Message For Update a Existing product_type_style //
				$_SESSION['product_category_msg'] = messagedisplay($product_type_style_success_message, 1);
				header('location:' . $_SESSION['product_type_style_manage_url']);
				exit();
			} else {
				// Message For Nothing Update //
				$_SESSION['product_category_msg'] = messagedisplay($product_type_style_unsuccess_message, 3);
				header('location:' . $_SESSION['product_type_style_manage_url']);
				exit();
			}
		} else {
			$_SESSION['product_category_msg'] = messagedisplay($product_type_style_duplicate_message, 2);
			header('product_type_style:' . $_SESSION['product_type_style_manage_url']);
			exit();
		}
	}
	// product_type_style Display Function //
	public function Product_category_display($sTable = '', $aColumns = '', $sWhere = '', $sLimit = '', $sOrder = '') {
		$product_type_style_query = array('tbl_name' => $sTable, 'field' => $aColumns, 'condition' => $sWhere, 'limit' => $sLimit, 'orderby' => $sOrder);
		$product_type_style_sql = $this->db->select($product_type_style_query);
		$product_category_array = $this->db->result($product_type_style_sql);
		return $product_category_array;
	}

	function product_type_category_image_display($sTable = '', $aColumns = '', $sWhere = '', $sLimit = '', $sOrder = '') {
		$banner_query=array( 'tbl_name' => $sTable, 'field' => $aColumns, 'condition' => $sWhere, 'limit' => $sLimit, 'orderby' => $sOrder);
		$banner_sql = $this->db->select($banner_query);
		$banner_array = $this->db->result($banner_sql);
		return $banner_array;
	}

	// product_type_style Status Update Function //
	public function product_type_style_status_update($product_type_style_manage_url) {
		$category_id = $_REQUEST['cid'];
		if ($_REQUEST['current_status'] == 'Inactive') {
			$category_status = 'Active';
		} else {
			$category_status = 'Inactive';
		}
		$this->db->update('category_tbl', array('category_status' => ($category_status)), "category_id='" . $category_id . "'");
		$_SESSION['product_category_msg'] = messagedisplay('product Category\'s Status is updated successfully', 1);
		header('location: ' . $product_type_style_manage_url);
		exit();
	}
	// product_type_style Delete Function //
	public function product_category_delete($product_type_style_manage_url) {
		$category_id = $_REQUEST['cid'];

			$product_category_delete = $this->db->delete("category_tbl", array("category_id" => $category_id));
			if ($product_category_delete['affectedRow'] > 0) {

				$_SESSION['product_category_msg'] = messagedisplay('product_type_style details deleted successfully', 1);
			} else {
				$_SESSION['product_category_msg'] = messagedisplay('Nothing is deleted successfully', 2);
			}
		
		header('location: ' . $product_type_style_manage_url);
		exit();
	}
}
?>