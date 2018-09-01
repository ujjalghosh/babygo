<?php
class homesmiles_location {
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
	// Location Add Function //
	public function location_add($location_array, $location_success_message, $location_unsuccess_message, $location_duplicate_message) {
		$location_duplicate_check_num = $this->location_check($location_id);
		if ($location_duplicate_check_num == 0) {
			$location_add = $this->db->insert('location_tbl', $location_array);
			if ($location_add['affectedRow'] > 0) {
				$location_id = $location_add['insertedId'];
				// Success Message For Insert a New Location //
				$_SESSION['location_msg'] = messagedisplay($location_success_message, 1);
				header('location: add_location.php');
				exit();
			} else {
				// Message For Nothing Insert //
				$_SESSION['location_msg'] = messagedisplay($location_unsuccess_message, 3);
			}
		} else {
			$_SESSION['location_msg'] = messagedisplay($location_duplicate_message, 2);
		}
	}
	// Location Duplicate Check Function //
	public function location_check($location_id = '') {
		// Check Duplicate Location Name //
		$location_duplicate_check_sql = $this->db->query("select * from " . $this->db->tbl_pre . "location_tbl where location_name='" . rep($_REQUEST['location_name']) . "' and location_id!='" . $location_id . "'");
		return $this->db->total($location_duplicate_check_sql);
	}
	// Location Edit Function //
	public function location_edit($location_array, $location_id, $location_success_message, $location_unsuccess_message, $location_duplicate_message) {
		$location_duplicate_check_num = $this->location_check($location_id);
		if ($location_duplicate_check_num == 0) {
			$location_update = $this->db->update('location_tbl', $location_array, "location_id='" . $location_id . "'");
			if ($location_update['affectedRow'] > 0) {
				// Success Message For Update a Existing Location //
				$_SESSION['location_msg'] = messagedisplay($location_success_message, 1);
				header('location:' . $_SESSION['location_manage_url']);
				exit();
			} else {
				// Message For Nothing Update //
				$_SESSION['location_msg'] = messagedisplay($location_unsuccess_message, 3);
				header('location:' . $_SESSION['location_manage_url']);
				exit();
			}
		} else {
			$_SESSION['location_msg'] = messagedisplay($location_duplicate_message, 2);
			header('location:' . $_SESSION['location_manage_url']);
			exit();
		}
	}
	// Location Display Function //
	public function location_display($sTable = '', $aColumns = '', $sWhere = '', $sLimit = '', $sOrder = '') {
		$location_query = array('tbl_name' => $sTable, 'field' => $aColumns, 'condition' => $sWhere, 'limit' => $sLimit, 'orderby' => $sOrder);
		$location_sql = $this->db->select($location_query);
		$location_array = $this->db->result($location_sql);
		return $location_array;
	}
	// Location Status Update Function //
	public function location_status_update($location_page_url) {
		$location_id = $_REQUEST['cid'];
		if ($_REQUEST['current_status'] == 'Inactive') {
			$location_status = 'Active';
		} else {
			$location_status = 'Inactive';
		}
		$this->db->update('location_tbl', array('location_status' => ($location_status)), "location_id='" . $location_id . "'");
		$_SESSION['location_msg'] = messagedisplay('Location\'s Status is updated successfully', 1);
		header('location: ' . $location_page_url);
		exit();
	}
	// Location Delete Function //
	public function location_delete($location_page_url) {
		$location_id = $_REQUEST['cid'];
		// Check Reminder Exist or Not Exist Under This Location //
		$check_sql = $this->db->query("select * from " . $this->db->tbl_pre . "zip_code_tbl where location_id='" . $location_id . "'");
		if ($this->db->total($check_sql) != 0) {
			$_SESSION['location_msg'] = messagedisplay('Zip code(s) already added under this location. First remove the zip code(s) from the location and then delete this location.', 2);
		} else {
			$location_delete = $this->db->delete("location_tbl", array("location_id" => $location_id));
			if ($location_delete['affectedRow'] > 0) {
				$_SESSION['location_msg'] = messagedisplay('Location details deleted successfully', 1);
			} else {
				$_SESSION['location_msg'] = messagedisplay('Nothing is deleted successfully', 2);
			}
		}
		header('location: ' . $location_page_url);
		exit();
	}
}
?>