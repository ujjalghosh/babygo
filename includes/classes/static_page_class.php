<?php
class homesmiles_static_page {
	var $recperpage;
	var $url;
	var $static_page_status;
	var $static_page_name;
	var $db;
	function __construct() {
		global $recperpage;
		global $url;
		global $db;
		$this->recperpage = $recperpage;
		$this->url = $url;
		$this->db = $db;
	}
	// Static Page Add Function //
	function static_page_add($static_page_array, $static_page_success_message, $static_page_unsuccess_message, $static_page_duplicate_message) {
		$static_page_duplicate_check_num = $this->static_page_check('', $static_page_array['static_page_name']);
		if ($static_page_duplicate_check_num == 0) {
			$static_page_add = $this->db->insert('static_page_tbl', $static_page_array);
			if ($static_page_add['affectedRow'] > 0) {
				$static_page_id = $static_page_add['insertedId'];
				// Success Message For Insert a New Static Page //
				$_SESSION['static_page_msg'] = messagedisplay($static_page_success_message, 1);
				header('Location: add_static_page.php');
				exit();
			} else {
				// Message For Nothing Insert //
				$_SESSION['static_page_msg'] = messagedisplay($static_page_unsuccess_message, 3);
			}
		} else {
			$_SESSION['static_page_msg'] = messagedisplay($static_page_duplicate_message, 2);
		}
	}
	// Static Page Duplicate Check Function //
	function static_page_check($static_page_id = '', $static_page_name) {
		// Check Duplicate Static Page Name //
		$static_page_duplicate_check_sql = $this->db->query("select * from " . $this->db->tbl_pre . "static_page_tbl where static_page_name='" . rep($static_page_name) . "' and static_page_id!='" . $static_page_id . "'");
		return $this->db->total($static_page_duplicate_check_sql);
	}
	// Static Page Edit Function //
	function static_page_edit($static_page_array, $static_page_id, $static_page_success_message, $static_page_unsuccess_message, $static_page_duplicate_message) {
		$static_page_duplicate_check_num = $this->static_page_check($static_page_id, $static_page_array['static_page_name']);
		if ($static_page_duplicate_check_num == 0) {
			$static_page_update = $this->db->update('static_page_tbl', $static_page_array, "static_page_id='" . $static_page_id . "'");
			if ($static_page_update['affectedRow'] > 0) {
				// Success Message For Update a Existing Static Page //
				$_SESSION['static_page_msg'] = messagedisplay($static_page_success_message, 1);
				header('Location:' . $_SESSION['static_page_manage_url']);
				exit();
			} else {
				// Message For Nothing Update //
				$_SESSION['static_page_msg'] = messagedisplay($static_page_unsuccess_message, 3);
				header('Location:' . $_SESSION['static_page_manage_url']);
				exit();
			}
		} else {
			$_SESSION['static_page_msg'] = messagedisplay($static_page_duplicate_message, 2);
			header('Location:' . $_SESSION['static_page_manage_url']);
			exit();
		}
	}
	// Static Page Display Function //
	function static_page_display($sTable = '', $aColumns = '', $sWhere = '', $sLimit = '', $sOrder = '') {
		$static_page_query = array('tbl_name' => $sTable, 'field' => $aColumns, 'condition' => $sWhere, 'limit' => $sLimit, 'orderby' => $sOrder);
		$static_page_sql = $this->db->select($static_page_query);
		$static_page_array = $this->db->result($static_page_sql);
		return $static_page_array;
	}
	// Static Page Status Update Function //
	function static_page_status_update($static_page_page_url) {
		$static_page_id = $_REQUEST['cid'];
		if ($_REQUEST['current_status'] == 'Inactive') {
			$static_page_status = 'Active';
		} else {
			$static_page_status = 'Inactive';
		}
		$static_page_status_update = $this->db->update('static_page_tbl', array('static_page_status' => $static_page_status), "static_page_id='" . $static_page_id . "'");
		$_SESSION['static_page_msg'] = messagedisplay('Static page\'s Status is updated successfully', 1);
		header('Location: ' . $static_page_page_url);
		exit();
	}
	// Static Page Delete Function //
	function static_page_delete($static_page_page_url) {
		$static_page_id = $_REQUEST['cid'];
		$static_page_delete = $this->db->delete("static_page_tbl", "static_page_id='" . $static_page_id . "'");
		if ($static_page_delete['affectedRow'] > 0) {
			$_SESSION['static_page_msg'] = messagedisplay('Static Page details deleted successfully', 1);
		} else {
			$_SESSION['static_page_msg'] = messagedisplay('Nothing is deleted successfully', 2);
		}
		header('Location: ' . $static_page_page_url);
		exit();
	}
}
?>