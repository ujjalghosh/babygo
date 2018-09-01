<?php
class babygo_customer_category{
	public $recperpage;
	public $url;
	public $db;
	public $mailsend;
	public $zip_code;
	public function __construct() {
		global $recperpage;
		global $url;
		global $db;
		global $mailsend;
		global $zip_code;
		$this->recperpage = $recperpage;
		$this->url = $url;
		$this->db = $db;
		$this->mailsend = $mailsend;
		
	}
	// customer_category Add Function //
	public function customer_category_add($customer_category_array, $customer_category_success_message, $customer_category_unsuccess_message, $customer_category_duplicate_message) {
		$customer_category_duplicate_check_num = $this->customer_category_check($category_id);
		if ($customer_category_duplicate_check_num == 0) {
			$customer_category_add = $this->db->insert('customer_category_tbl', $customer_category_array);
			if ($customer_category_add['affectedRow'] > 0) {
				$category_id = $customer_category_add['insertedId'];
 
				$_SESSION['customer_category_msg'] = messagedisplay($customer_category_success_message, 1);
				header('location: add_customer_category.php');
				exit();
			} else {
				// Message For Nothing Insert //
				$_SESSION['customer_category_msg'] = messagedisplay($customer_category_unsuccess_message, 3);
			}
		} else {
			$_SESSION['customer_category_msg'] = messagedisplay($customer_category_duplicate_message, 2);
		}
	}
	// customer_category Duplicate Check Function //
	public function customer_category_check($category_id = '') {
		// Check Duplicate customer_category Name //
		$customer_category_duplicate_check_sql = $this->db->query("select * from " . $this->db->tbl_pre . "customer_category_tbl where category_name='" . rep($_REQUEST['category_name']) . "' and category_id!='" . $category_id . "'");
		return $this->db->total($customer_category_duplicate_check_sql);
	}
	// customer_category Edit Function //
	public function customer_category_edit($customer_category_array, $category_id, $customer_category_success_message, $customer_category_unsuccess_message, $customer_category_duplicate_message) {
		$customer_category_duplicate_check_num = $this->customer_category_check($category_id);
		if ($customer_category_duplicate_check_num == 0) {
			$customer_category_update = $this->db->update('customer_category_tbl', $customer_category_array, "category_id='" . $category_id . "'");
 
			if ($customer_category_update['affectedRow'] > 0) {
				// Success Message For Update a Existing customer_category //
				$_SESSION['customer_category_msg'] = messagedisplay($customer_category_success_message, 1);
				header('location:' . $_SESSION['customer_category_manage_url']);
				exit();
			} else {
				// Message For Nothing Update //
				$_SESSION['customer_category_msg'] = messagedisplay($customer_category_unsuccess_message, 3);
				header('location:' . $_SESSION['customer_category_manage_url']);
				exit();
			}
		} else {
			$_SESSION['customer_category_msg'] = messagedisplay($customer_category_duplicate_message, 2);
			header('location:' . $_SESSION['customer_category_manage_url']);
			exit();
		}
	}
	// customer_category Display Function //
	public function customer_category_display($sTable = '', $aColumns = '', $sWhere = '', $sLimit = '', $sOrder = '') {
		$customer_category_query = array('tbl_name' => $sTable, 'field' => $aColumns, 'condition' => $sWhere, 'limit' => $sLimit, 'orderby' => $sOrder);
		$customer_category_sql = $this->db->select($customer_category_query);
		$customer_category_array = $this->db->result($customer_category_sql);
		return $customer_category_array;
	}
	// customer_category Status Update Function //
	public function customer_category_status_update($customer_category_page_url) {
		$category_id = $_REQUEST['cid'];
		if ($_REQUEST['current_status'] == 'Inactive') {
			$customer_category_status = 'Active';
		} else {
			$customer_category_status = 'Inactive';
		}
		$this->db->update('customer_category_tbl', array('customer_category_status' => ($customer_category_status)), "category_id='" . $category_id . "'");
		$_SESSION['customer_category_msg'] = messagedisplay('customer_category\'s Status is updated successfully', 1);
		header('location: ' . $customer_category_page_url);
		exit();
	}
	// customer_category Delete Function //
	public function customer_category_delete($customer_category_page_url) {
		$category_id = $_REQUEST['cid'];
		$customer_category_delete = $this->db->delete("customer_category_tbl", array("category_id" => $category_id));
		 
		if ($customer_category_delete['affectedRow'] > 0) {
			$_SESSION['customer_category_msg'] = messagedisplay('customer_category details deleted successfully', 1);
		} else {
			$_SESSION['customer_category_msg'] = messagedisplay('Nothing is deleted successfully', 2);
		}
		header('location: ' . $customer_category_page_url);
		exit();
	}

 
}
?>