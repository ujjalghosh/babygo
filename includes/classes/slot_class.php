<?php
class homesmiles_slot {
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
	// Subscriber Add Function //
	public function slot_add($slot_array, $slot_success_message, $slot_unsuccess_message, $slot_duplicate_message) {
		$slot_duplicate_check_num = $this->slot_check($slot_id);
		if ($slot_duplicate_check_num == 0) {
			$slot_add = $this->db->insert('slot_tbl', $slot_array);
			if ($slot_add['affectedRow'] > 0) {
				$slot_id = $slot_add['insertedId'];
				// Success Message For Insert a New Subscriber //
				$_SESSION['slot_msg'] = messagedisplay($slot_success_message, 1);
				header('location: add_slot.php');
				exit();
			} else {
				// Message For Nothing Insert //
				$_SESSION['slot_msg'] = messagedisplay($slot_unsuccess_message, 3);
			}
		} else {
			$_SESSION['slot_msg'] = messagedisplay($slot_duplicate_message, 2);
		}
	}
// Subscriber Duplicate Check Function //
	public function slot_check($slot_id = '') {
		// Check Duplicate Subscriber Name //
		$slot_duplicate_check_sql = $this->db->query("select * from " . $this->db->tbl_pre . "slot_tbl where slot_start_hour='" . rep($_REQUEST['slot_start_hour']) . "' and slot_start_minute='" . rep($_REQUEST['slot_start_minute']) . "' and slot_type='" . rep($_REQUEST['slot_type']) . "' and slot_id!='" . $slot_id . "'");
		return $this->db->total($slot_duplicate_check_sql);
	}
// Subscriber Edit Function //
	public function slot_edit($slot_array, $slot_id, $slot_success_message, $slot_unsuccess_message, $slot_duplicate_message) {
		$slot_duplicate_check_num = 0;
		if ($slot_duplicate_check_num == 0) {
			$slot_update = $this->db->update('slot_tbl', $slot_array, "slot_id='" . $slot_id . "'");
			if ($slot_update['affectedRow'] > 0) {
				// Success Message For Update a Existing Subscriber //
				$_SESSION['slot_msg'] = messagedisplay($slot_success_message, 1);
				header('location:' . $_SESSION['slot_manage_url']);
				exit();
			} else {
				// Message For Nothing Update //
				$_SESSION['slot_msg'] = messagedisplay($slot_unsuccess_message, 3);
				header('location:' . $_SESSION['slot_manage_url']);
				exit();
			}
		} else {
			$_SESSION['slot_msg'] = messagedisplay($slot_duplicate_message, 2);
			header('location:' . $_SESSION['slot_manage_url']);
			exit();
		}
	}
// Subscriber Display Function //
	public function slot_display($sTable = '', $aColumns = '', $sWhere = '', $sLimit = '', $sOrder = '') {
		$slot_query = array('tbl_name' => $sTable, 'field' => $aColumns, 'condition' => $sWhere, 'limit' => $sLimit, 'orderby' => $sOrder);
		$slot_sql = $this->db->select($slot_query);
		$slot_array = $this->db->result($slot_sql);
		return $slot_array;
	}
// Subscriber Status Update Function //
	public function slot_status_update($slot_page_url) {
		$slot_id = $_REQUEST['cid'];
		if ($_REQUEST['current_status'] == 'Inactive') {
			$slot_status = 'Active';
		} else {
			$slot_status = 'Inactive';
		}
		$this->db->update('slot_tbl', array('slot_status' => ($slot_status)), "slot_id='" . $slot_id . "'");
		$_SESSION['slot_msg'] = messagedisplay('Subscriber\'s Status is updated successfully', 1);
		header('location: ' . $slot_page_url);
		exit();
	}
// Subscriber Delete Function //
	public function slot_delete($slot_page_url) {
		$slot_id = $_REQUEST['cid'];
		$slot_delete = $this->db->delete("slot_tbl", array('slot_id' => $slot_id));
		$slot_list_delete = $this->db->delete("appointment_tbl", array('appointment_slot_id' => $slot_id));
		if ($slot_delete['affectedRow'] > 0) {
			$_SESSION['slot_msg'] = messagedisplay('Slot details deleted successfully', 1);
		} else {
			$_SESSION['slot_msg'] = messagedisplay('Nothing is deleted successfully', 2);
		}
		header('location: ' . $slot_page_url);
		exit();
	}
}
?>