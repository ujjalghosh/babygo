<?php
class babygo_product_color {
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
	// Product_color Add Function //
	public function Product_color_add($Product_color_array, $Product_color_success_message, $Product_color_unsuccess_message, $Product_color_duplicate_message) {
		$Product_color_duplicate_check_num = $this->Product_color_check($product_color_id);
		if ($Product_color_duplicate_check_num == 0) {
			$Product_color_add = $this->db->insert('product_color_tbl', $Product_color_array);
			if ($Product_color_add['affectedRow'] > 0) {
				$product_color_id = $Product_color_add['insertedId'];
				// Success Message For Insert a New Product_color //
				$_SESSION['Product_color_msg'] = messagedisplay($Product_color_success_message, 1);
				header('location: add_product_color.php');
				exit();
			} else {
				// Message For Nothing Insert //
				$_SESSION['Product_color_msg'] = messagedisplay($Product_color_unsuccess_message, 3);
			}
		} else {
			$_SESSION['Product_color_msg'] = messagedisplay($Product_color_duplicate_message, 2);
		}
	}
	// Product_color Duplicate Check Function //
	public function Product_color_check($product_color_id = '') {
		// Check Duplicate Product_color Name //
		$Product_color_duplicate_check_sql = $this->db->query("select * from " . $this->db->tbl_pre . "product_color_tbl where product_color_name='" . rep($_REQUEST['product_color_name']) . "'  and product_color_id!='" . $product_color_id . "'");
		return $this->db->total($Product_color_duplicate_check_sql);
	}
	// Product_color Edit Function //
	public function Product_color_edit($Product_color_array, $product_color_id, $Product_color_success_message, $Product_color_unsuccess_message, $Product_color_duplicate_message) {
		$Product_color_duplicate_check_num = $this->Product_color_check($product_color_id);
		if ($Product_color_duplicate_check_num == 0) {
			$Product_color_update = $this->db->update('product_color_tbl', $Product_color_array, "product_color_id='" . $product_color_id . "'");
			if ($Product_color_update['affectedRow'] > 0) {
				// Success Message For Update a Existing Product_color //
				$_SESSION['Product_color_msg'] = messagedisplay($Product_color_success_message, 1);
				header('location:' . $_SESSION['Product_color_manage_url']);
				exit();
			} else {
				// Message For Nothing Update //
				$_SESSION['Product_color_msg'] = messagedisplay($Product_color_unsuccess_message, 3);
				header('location:' . $_SESSION['Product_color_manage_url']);
				exit();
			}
		} else {
			$_SESSION['Product_color_msg'] = messagedisplay($Product_color_duplicate_message, 2);
			header('location:' . $_SESSION['Product_color_manage_url']);
			exit();
		}
	}
	// Product_color Display Function //
	public function Product_color_display($sTable = '', $aColumns = '', $sWhere = '', $sLimit = '', $sOrder = '') {
		$Product_color_query = array('tbl_name' => $sTable, 'field' => $aColumns, 'condition' => $sWhere, 'limit' => $sLimit, 'orderby' => $sOrder);
		$Product_color_sql = $this->db->select($Product_color_query);
		$Product_color_array = $this->db->result($Product_color_sql);
		return $Product_color_array;
	}
	// Product_color Status Update Function //
	public function Product_color_status_update($Product_color_page_url) {
		$product_color_id = $_REQUEST['cid'];
		if ($_REQUEST['current_status'] == 'Inactive') {
			$Product_color_status = 'Active';
		} else {
			$Product_color_status = 'Inactive';
		}
		$this->db->update('product_color_tbl', array('product_color_status' => ($Product_color_status)), "product_color_id='" . $product_color_id . "'");
		$_SESSION['Product_color_msg'] = messagedisplay('Product_color\'s Status is updated successfully', 1);
		header('location: ' . $Product_color_page_url);
		exit();
	}
	// Product_color Delete Function //
	public function Product_color_delete($Product_color_page_url) {
		$product_color_id = $_REQUEST['cid'];
		// Check Reminder Exist or Not Exist Under This Product_color //

			$Product_color_delete = $this->db->delete("product_color_tbl", array("product_color_id" => $product_color_id));
			if ($Product_color_delete['affectedRow'] > 0) {
				$_SESSION['Product_color_msg'] = messagedisplay('Product_color details deleted successfully', 1);
			} else {
				$_SESSION['Product_color_msg'] = messagedisplay('Nothing is deleted successfully', 2);
			}
		
		header('location: ' . $Product_color_page_url);
		exit();
	}
}
?>