<?php
class homesmiles_zip_code {
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
	// Zip code Add Function //
	public function zip_code_add($zip_code_array, $zip_code_success_message, $zip_code_unsuccess_message, $zip_code_duplicate_message) {
		$zip_code_duplicate_check_num = $this->zip_code_check('', $zip_code_array['zip_code_value'],$zip_code_array['location_id']);
		if ($zip_code_duplicate_check_num == 0) {
			$zip_code_add = $this->db->insert('zip_code_tbl', $zip_code_array);
			if ($zip_code_add['affectedRow'] > 0) {
				$zip_code_id = $zip_code_add['insertedId'];
				// Success Message For Insert a New Zip code //
				$_SESSION['zip_code_msg'] = messagedisplay($zip_code_success_message, 1);
				header('Location: add_zip_code.php');
				exit();
			} else {
				// Message For Nothing Insert //
				$_SESSION['zip_code_msg'] = messagedisplay($zip_code_unsuccess_message, 3);
			}
		} else {
			$_SESSION['zip_code_msg'] = messagedisplay($zip_code_duplicate_message, 2);
		}
	}
	// Zip code Duplicate Check Function //
	public function zip_code_check($zip_code_id = '', $zip_code_value,$location_id) {
		// Check Duplicate Zip code Name //
		$zip_code_duplicate_check_sql = $this->db->query("select * from " . $this->db->tbl_pre . "zip_code_tbl where zip_code_value='" . rep($zip_code_value) . "' and location_id='" . $location_id . "' and zip_code_id!='" . $zip_code_id . "'");
		return $this->db->total($zip_code_duplicate_check_sql);
	}
	// Zip code Edit Function //
	public function zip_code_edit($zip_code_array, $zip_code_id, $zip_code_success_message, $zip_code_unsuccess_message, $zip_code_duplicate_message) {
		$zip_code_duplicate_check_num = $this->zip_code_check($zip_code_id, $zip_code_array['zip_code_value'],$zip_code_array['location_id']);
		if ($zip_code_duplicate_check_num == 0) {
			$zip_code_update = $this->db->update('zip_code_tbl', $zip_code_array, "zip_code_id='" . $zip_code_id . "'");
			if ($zip_code_update['affectedRow'] > 0) {
				// Success Message For Update a Existing Zip code //
				$_SESSION['zip_code_msg'] = messagedisplay($zip_code_success_message, 1);
				header('Location:' . $_SESSION['zip_code_manage_url']);
				exit();
			} else {
				// Message For Nothing Update //
				$_SESSION['zip_code_msg'] = messagedisplay($zip_code_unsuccess_message, 3);
				header('Location:' . $_SESSION['zip_code_manage_url']);
				exit();
			}
		} else {
			$_SESSION['zip_code_msg'] = messagedisplay($zip_code_duplicate_message, 2);
			header('Location:' . $_SESSION['zip_code_manage_url']);
			exit();
		}
	}
	// Zip code Display Function //
	public function zip_code_display($sTable = '', $aColumns = '', $sWhere = '', $sLimit = '', $sOrder = '') {
		$zip_code_query = array('tbl_name' => $sTable, 'field' => $aColumns, 'condition' => $sWhere, 'limit' => $sLimit, 'orderby' => $sOrder);
		$zip_code_sql = $this->db->select($zip_code_query);
		$zip_code_array = $this->db->result($zip_code_sql);
		return $zip_code_array;
	}
	// Zip code Status Update Function //
	public function zip_code_status_update($zip_code_page_url) {
		$zip_code_id = $_REQUEST['cid'];
		if ($_REQUEST['current_status'] == 'Inactive') {
			$zip_code_status = 'Active';
		} else {
			$zip_code_status = 'Inactive';
		}
		$zip_code_status_update = $this->db->update('zip_code_tbl', array('zip_code_status' => $zip_code_status), "zip_code_id='" . $zip_code_id . "'");
		$_SESSION['zip_code_msg'] = messagedisplay('Zip code\'s Status is updated successfully', 1);
		header('Location: ' . $zip_code_page_url);
		exit();
	}
	// Zip code Delete Function //
	public function zip_code_delete($zip_code_page_url) {
		$zip_code_id = $_REQUEST['cid'];
		// Check Reminder Exist or Not Exist Under This Zip code //
		$check_sql = $this->db->query("select * from " . $this->db->tbl_pre . "franchise_zip_code_tbl where zip_code_id='" . $zip_code_id . "'");
		if ($this->db->total($check_sql) != 0) {
			$_SESSION['zip_code_msg'] = messagedisplay('Franchise existing under this zip code. First delete franchise and then delete this zip code.', 2);
		} else {
			$zip_code_delete = $this->db->delete("zip_code_tbl", array("zip_code_id" => $zip_code_id));
			if ($zip_code_delete['affectedRow'] > 0) {
				$_SESSION['zip_code_msg'] = messagedisplay('Zip code details deleted successfully', 1);
			} else {
				$_SESSION['zip_code_msg'] = messagedisplay('Nothing is deleted successfully', 2);
			}
		}
		header('Location: ' . $zip_code_page_url);
		exit();
	}
}
?>