<?php
class babygo_product_size {
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
	// Product_size Add Function //
	public function Product_size_add($Product_size_array, $Product_size_success_message, $Product_size_unsuccess_message, $Product_size_duplicate_message) {
		$Product_size_duplicate_check_num = $this->Product_size_check($product_size_id);
		if ($Product_size_duplicate_check_num == 0) {
			$Product_size_add = $this->db->insert('product_size_tbl', $Product_size_array);
			if ($Product_size_add['affectedRow'] > 0) {
				$product_size_id = $Product_size_add['insertedId'];
				// Success Message For Insert a New Product_size //
				$_SESSION['Product_size_msg'] = messagedisplay($Product_size_success_message, 1);
				header('location: add_Product_size.php');
				exit();
			} else {
				// Message For Nothing Insert //
				$_SESSION['Product_size_msg'] = messagedisplay($Product_size_unsuccess_message, 3);
			}
		} else {
			$_SESSION['Product_size_msg'] = messagedisplay($Product_size_duplicate_message, 2);
		}
	}
	// Product_size Duplicate Check Function //
	public function Product_size_check($product_size_id = '') {
		// Check Duplicate Product_size Name //
		$Product_size_duplicate_check_sql = $this->db->query("select * from " . $this->db->tbl_pre . "product_size_tbl where size_description='" . rep($_REQUEST['size_description']) . "'  and product_size_id!='" . $product_size_id . "'");
		return $this->db->total($Product_size_duplicate_check_sql);
	}
	// Product_size Edit Function //
	public function Product_size_edit($Product_size_array, $product_size_id, $Product_size_success_message, $Product_size_unsuccess_message, $Product_size_duplicate_message) {
		$Product_size_duplicate_check_num = $this->Product_size_check($product_size_id);
		if ($Product_size_duplicate_check_num == 0) {
			$Product_size_update = $this->db->update('product_size_tbl', $Product_size_array, "product_size_id='" . $product_size_id . "'");
			if ($Product_size_update['affectedRow'] > 0) {
				// Success Message For Update a Existing Product_size //
				$_SESSION['Product_size_msg'] = messagedisplay($Product_size_success_message, 1);
				header('location:' . $_SESSION['Product_size_manage_url']);
				exit();
			} else {
				// Message For Nothing Update //
				$_SESSION['Product_size_msg'] = messagedisplay($Product_size_unsuccess_message, 3);
				header('location:' . $_SESSION['Product_size_manage_url']);
				exit();
			}
		} else {
			$_SESSION['Product_size_msg'] = messagedisplay($Product_size_duplicate_message, 2);
			header('location:' . $_SESSION['Product_size_manage_url']);
			exit();
		}
	}
	// Product_size Display Function //
	public function Product_size_display($sTable = '', $aColumns = '', $sWhere = '', $sLimit = '', $sOrder = '') {
		$Product_size_query = array('tbl_name' => $sTable, 'field' => $aColumns, 'condition' => $sWhere, 'limit' => $sLimit, 'orderby' => $sOrder);
		$Product_size_sql = $this->db->select($Product_size_query);
		$Product_size_array = $this->db->result($Product_size_sql);
		return $Product_size_array;
	}
	// Product_size Status Update Function //
	public function Product_size_status_update($Product_size_page_url) {
		$product_size_id = $_REQUEST['cid'];
		if ($_REQUEST['current_status'] == 'Inactive') {
			$Product_size_status = 'Active';
		} else {
			$Product_size_status = 'Inactive';
		}
		$this->db->update('product_size_tbl', array('size_status' => ($Product_size_status)), "product_size_id='" . $product_size_id . "'");
		$_SESSION['Product_size_msg'] = messagedisplay('Product_size\'s Status is updated successfully', 1);
		header('location: ' . $Product_size_page_url);
		exit();
	}
	// Product_size Delete Function //
	public function Product_size_delete($Product_size_page_url) {
		$product_size_id = $_REQUEST['cid'];
		// Check Reminder Exist or Not Exist Under This Product_size //

			$Product_size_delete = $this->db->delete("product_size_tbl", array("product_size_id" => $product_size_id));
			if ($Product_size_delete['affectedRow'] > 0) {
				$_SESSION['Product_size_msg'] = messagedisplay('Product_size details deleted successfully', 1);
			} else {
				$_SESSION['Product_size_msg'] = messagedisplay('Nothing is deleted successfully', 2);
			}
		
		header('location: ' . $Product_size_page_url);
		exit();
	}
}
?>