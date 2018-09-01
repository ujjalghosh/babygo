<?php
class babygo_product_details {
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
	// product_details Add Function //
	public function product_details_add($product_details_array, $product_details_success_message, $product_details_unsuccess_message, $product_details_duplicate_message) {
		$product_details_check = $this->product_details_check($product_details_id);
		if ($product_details_check == 0) {
			$product_details_add = $this->db->insert('product_details_tbl', $product_details_array);
			if ($product_details_add['affectedRow'] > 0) {
				$product_details_id = $product_details_add['insertedId'];
 
				// Success Message For Insert a New product_details_type_style //
				$_SESSION['product_style_msg'] = messagedisplay($product_details_success_message, 1);
				header('location: add_product_style.php');
				exit();
			} else {
				// Message For Nothing Insert //
				$_SESSION['product_style_msg'] = messagedisplay($product_details_unsuccess_message, 3);
			}
		} else {
			$_SESSION['product_style_msg'] = messagedisplay($product_details_duplicate_message, 2);
		}
	}
	// product_details Duplicate Check Function //
	public function product_details_check($product_details_id = '') {
		// Check Duplicate product_details Name //
		$product_details_duplicate_check_sql = $this->db->query("select * from " . $this->db->tbl_pre . "product_details_tbl where product_id='" . rep($_REQUEST['product_id']) . "' and size_id='" . rep($_REQUEST['size_id']) . "' and product_details_id!='" . $product_details_id . "'");
		return $this->db->total($product_details_duplicate_check_sql);
	}
	// product_details Edit Function //
	public function product_details_edit($product_details_array, $product_details_id, $product_details_success_message, $product_details_unsuccess_message, $product_details_duplicate_message) {
		$product_details_duplicate_check_num = $this->product_details_check($product_details_id);
		if ($product_details_duplicate_check_num == 0) {
			$product_details_update = $this->db->update('product_details_tbl', $product_details_array, "product_details_id='" . $product_details_id . "'");
 
			if ($product_details_update['affectedRow'] > 0) {
				// Success Message For Update a Existing product_details //
				$_SESSION['product_style_msg'] = messagedisplay($product_details_success_message, 1);
				header('location:' . $_SESSION['product_details_manage_url']);
				exit();
			} else {
				// Message For Nothing Update //
				$_SESSION['product_style_msg'] = messagedisplay($product_details_unsuccess_message, 3);
				header('location:' . $_SESSION['product_details_manage_url']);
				exit();
			}
		} else {
			$_SESSION['product_style_msg'] = messagedisplay($product_details_duplicate_message, 2);
			header('location:' . $_SESSION['product_details_manage_url']);
			exit();
		}
	}
	// product_details Display Function //
	public function product_details_display($sTable = '', $aColumns = '', $sWhere = '', $sLimit = '', $sOrder = '') {
		$product_details_query = array('tbl_name' => $sTable, 'field' => $aColumns, 'condition' => $sWhere, 'limit' => $sLimit, 'orderby' => $sOrder);
		$product_details_sql = $this->db->select($product_details_query);
		$product_details_array = $this->db->result($product_details_sql);
		return $product_details_array;
	}
	// product_details Status Update Function //
	public function product_details_status_update($product_details_page_url) {
		$product_details_id = $_REQUEST['cid'];
		if ($_REQUEST['current_status'] == 'Inactive') {
			$product_details_status = 'Active';
		} else {
			$product_details_status = 'Inactive';
		}
		$this->db->update('product_details_tbl', array('product_details_status' => ($product_details_status)), "product_details_id='" . $product_details_id . "'");
		$_SESSION['product_style_msg'] = messagedisplay('product_details\'s Status is updated successfully', 1);
		header('location: ' . $product_details_page_url);
		exit();
	}
	// product_details Delete Function //
	public function product_details_delete($product_details_page_url) {
		$product_details_id = $_REQUEST['cid'];
		$product_details_delete = $this->db->delete("product_details_tbl", array("product_details_id" => $product_details_id));
		 
		if ($product_details_delete['affectedRow'] > 0) {
			$_SESSION['product_style_msg'] = messagedisplay('product_details details deleted successfully', 1);
		} else {
			$_SESSION['product_style_msg'] = messagedisplay('Nothing is deleted successfully', 2);
		}
		header('location: ' . $product_details_page_url);
		exit();
	}
}
?>