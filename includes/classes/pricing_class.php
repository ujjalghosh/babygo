<?php
class homesmiles_pricing {
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
	// pricing Add Function //
	public function pricing_add($pricing_array, $pricing_success_message, $pricing_unsuccess_message, $pricing_duplicate_message) {
		$pricing_duplicate_check_num = $this->pricing_check('', $pricing_array['pricing_unit'], $pricing_array['pricing_type'], $pricing_array['pricing_square_footage']);
		if ($pricing_duplicate_check_num == 0) {
			$pricing_add = $this->db->insert('pricing_tbl', $pricing_array);
			if ($pricing_add['affectedRow'] > 0) {
				$pricing_id = $pricing_add['insertedId'];
				// Success Message For Insert a New pricing //
				$_SESSION['pricing_msg'] = messagedisplay($pricing_success_message, 1);
				header('Location: add_pricing.php');
				exit();
			} else {
				// Message For Nothing Insert //
				$_SESSION['pricing_msg'] = messagedisplay($pricing_unsuccess_message, 3);
			}
		} else {
			$_SESSION['pricing_msg'] = messagedisplay($pricing_duplicate_message, 2);
		}
	}
	// pricing Duplicate Check Function //
	public function pricing_check($pricing_id = '', $pricing_unit, $pricing_type, $pricing_square_footage) {
		// Check Duplicate pricing Name //
		$pricing_duplicate_check_sql = $this->db->query("select * from " . $this->db->tbl_pre . "pricing_tbl where pricing_unit='" . rep($pricing_unit) . "' and pricing_type='" . rep($pricing_type) . "' and pricing_square_footage='" . rep($pricing_square_footage) . "' and pricing_id!='" . $pricing_id . "'");
		return $this->db->total($pricing_duplicate_check_sql);
	}
	// pricing Edit Function //
	public function pricing_edit($pricing_array, $pricing_id, $pricing_success_message, $pricing_unsuccess_message, $pricing_duplicate_message) {
		$pricing_duplicate_check_num = $this->pricing_check($pricing_id, $pricing_array['pricing_unit'], $pricing_array['pricing_type'], $pricing_array['pricing_square_footage']);
		if ($pricing_duplicate_check_num == 0) {
			$pricing_update = $this->db->update('pricing_tbl', $pricing_array, "pricing_id='" . $pricing_id . "'");
			if ($pricing_update['affectedRow'] > 0) {
				// Success Message For Update a Existing pricing //
				$_SESSION['pricing_msg'] = messagedisplay($pricing_success_message, 1);
				header('Location:' . $_SESSION['pricing_manage_url']);
				exit();
			} else {
				// Message For Nothing Update //
				$_SESSION['pricing_msg'] = messagedisplay($pricing_unsuccess_message, 3);
				header('Location:' . $_SESSION['pricing_manage_url']);
				exit();
			}
		} else {
			$_SESSION['pricing_msg'] = messagedisplay($pricing_duplicate_message, 2);
			header('Location:' . $_SESSION['pricing_manage_url']);
			exit();
		}
	}
	// pricing Display Function //
	public function pricing_display($sTable = '', $aColumns = '', $sWhere = '', $sLimit = '', $sOrder = '') {
		$pricing_query = array('tbl_name' => $sTable, 'field' => $aColumns, 'condition' => $sWhere, 'limit' => $sLimit, 'orderby' => $sOrder);
		$pricing_sql = $this->db->select($pricing_query);
		$pricing_array = $this->db->result($pricing_sql);
		return $pricing_array;
	}
	// pricing Status Update Function //
	public function pricing_status_update($pricing_page_url) {
		$pricing_id = $_REQUEST['cid'];
		if ($_REQUEST['current_status'] == 'Inactive') {
			$pricing_status = 'Active';
		} else {
			$pricing_status = 'Inactive';
		}
		$pricing_status_update = $this->db->update('pricing_tbl', array('pricing_status' => $pricing_status), "pricing_id='" . $pricing_id . "'");
		$_SESSION['pricing_msg'] = messagedisplay('pricing\'s Status is updated successfully', 1);
		header('Location: ' . $pricing_page_url);
		exit();
	}
	// pricing Delete Function //
	public function pricing_delete($pricing_page_url) {
		$pricing_id = $_REQUEST['cid'];
		// Check Reminder Exist or Not Exist Under This pricing //
		$check_sql = $this->db->query("select * from " . $this->db->tbl_pre . "appointment_tbl where pricing_id='" . $pricing_id . "'");
		if ($this->db->total($check_sql) != 0) {
			$_SESSION['pricing_msg'] = messagedisplay('Appointment(s) existing under this price. First delete appointment(s) and then delete this price.', 2);
		} else {
			$pricing_delete = $this->db->delete("pricing_tbl", array("pricing_id" => $pricing_id));
			if ($pricing_delete['affectedRow'] > 0) {
				$_SESSION['pricing_msg'] = messagedisplay('Pricing details deleted successfully', 1);
			} else {
				$_SESSION['pricing_msg'] = messagedisplay('Nothing is deleted successfully', 2);
			}
		}
		header('Location: ' . $pricing_page_url);
		exit();
	}
}
?>