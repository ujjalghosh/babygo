<?php
class babygo_product_group {
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
	// Product_group Add Function //
	public function Product_group_add($Product_group_array, $Product_group_success_message, $Product_group_unsuccess_message, $Product_group_duplicate_message) {
		$Product_group_duplicate_check_num = $this->Product_group_check($product_group_id);
		if ($Product_group_duplicate_check_num == 0) {
			$Product_group_add = $this->db->insert('product_group_tbl', $Product_group_array);
			if ($Product_group_add['affectedRow'] > 0) {
				$product_group_id = $Product_group_add['insertedId'];
				// Success Message For Insert a New Product_group //
				$_SESSION['Product_group_msg'] = messagedisplay($Product_group_success_message, 1);
				header('location: add_Product_group.php');
				exit();
			} else {
				// Message For Nothing Insert //
				$_SESSION['Product_group_msg'] = messagedisplay($Product_group_unsuccess_message, 3);
			}
		} else {
			$_SESSION['Product_group_msg'] = messagedisplay($Product_group_duplicate_message, 2);
		}
	}
	// Product_group Duplicate Check Function //
	public function Product_group_check($product_group_id = '') {
		// Check Duplicate Product_group Name //
		$Product_group_duplicate_check_sql = $this->db->query("select * from " . $this->db->tbl_pre . "product_group_tbl where product_group_name='" . rep($_REQUEST['product_group_name']) . "' and product_category_id='" . rep($_REQUEST['product_category_id']) . "'  and product_group_id!='" . $product_group_id . "'");
		return $this->db->total($Product_group_duplicate_check_sql);
	}
	// Product_group Edit Function //
	public function Product_group_edit($Product_group_array, $product_group_id, $Product_group_success_message, $Product_group_unsuccess_message, $Product_group_duplicate_message) {
		$Product_group_duplicate_check_num = $this->Product_group_check($product_group_id);
		if ($Product_group_duplicate_check_num == 0) {
			$Product_group_update = $this->db->update('product_group_tbl', $Product_group_array, "product_group_id='" . $product_group_id . "'");
			if ($Product_group_update['affectedRow'] > 0) {
				// Success Message For Update a Existing Product_group //
				$_SESSION['Product_group_msg'] = messagedisplay($Product_group_success_message, 1);
				header('location:' . $_SESSION['Product_group_manage_url']);
				exit();
			} else {
				// Message For Nothing Update //
				$_SESSION['Product_group_msg'] = messagedisplay($Product_group_unsuccess_message, 3);
				header('location:' . $_SESSION['Product_group_manage_url']);
				exit();
			}
		} else {
			$_SESSION['Product_group_msg'] = messagedisplay($Product_group_duplicate_message, 2);
			header('location:' . $_SESSION['Product_group_manage_url']);
			exit();
		}
	}
	// Product_group Display Function //
	public function Product_group_display($sTable = '', $aColumns = '', $sWhere = '', $sLimit = '', $sOrder = '') {
		$Product_group_query = array('tbl_name' => $sTable, 'field' => $aColumns, 'condition' => $sWhere, 'limit' => $sLimit, 'orderby' => $sOrder);
		$Product_group_sql = $this->db->select($Product_group_query);
		$Product_group_array = $this->db->result($Product_group_sql);
		return $Product_group_array;
	}
	// Product_group Status Update Function //
	public function Product_group_status_update($Product_group_page_url) {
		$product_group_id = $_REQUEST['cid'];
		if ($_REQUEST['current_status'] == 'Inactive') {
			$Product_group_status = 'Active';
		} else {
			$Product_group_status = 'Inactive';
		}
		$this->db->update('product_group_tbl', array('product_group_status' => ($Product_group_status)), "product_group_id='" . $product_group_id . "'");
		$_SESSION['Product_group_msg'] = messagedisplay('Product_group\'s Status is updated successfully', 1);
		header('location: ' . $Product_group_page_url);
		exit();
	}
	// Product_group Delete Function //
	public function Product_group_delete($Product_group_page_url) {
		$product_group_id = $_REQUEST['cid'];
		// Check Reminder Exist or Not Exist Under This Product_group //

			$Product_group_delete = $this->db->delete("product_group_tbl", array("product_group_id" => $product_group_id));
			if ($Product_group_delete['affectedRow'] > 0) {
				$_SESSION['Product_group_msg'] = messagedisplay('Product_group details deleted successfully', 1);
			} else {
				$_SESSION['Product_group_msg'] = messagedisplay('Nothing is deleted successfully', 2);
			}
		
		header('location: ' . $Product_group_page_url);
		exit();
	}
}
?>