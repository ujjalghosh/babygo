<?php
class emailsystem_subscriber {
	public $recperpage;
	public $url;
	public $db;
	public $email_list;
	public $extra_field;
	public function __construct() {
		global $recperpage;
		global $url;
		global $db;
		global $email_list;
		global $extra_field;
		$this->recperpage = $recperpage;
		$this->url = $url;
		$this->db = $db;
		$this->email_list = $email_list;
		$this->extra_field = $extra_field;
	}
	// Subscriber Add Function //
	public function subscriber_add($subscriber_array, $subscriber_additional_array, $subscriber_success_message, $subscriber_unsuccess_message, $subscriber_duplicate_message) {
		$subscriber_duplicate_check_num = $this->subscriber_check($subscriber_id);
		if ($subscriber_duplicate_check_num == 0) {
			$subscriber_add = $this->db->insert('subscriber_tbl', $subscriber_array);
			if ($subscriber_add['affectedRow'] > 0) {
				$subscriber_id = $subscriber_add['insertedId'];
				// Add Email list For this particular Subscriber //
				$email_list_array = $this->email_list->email_list_display($this->db->tbl_pre . "email_list_tbl", array(), "WHERE email_list_status='Active'");
				for ($ela = 0; $ela < count($email_list_array); $ela++) {
					if ($_REQUEST['email_list'][$email_list_array[$ela]['email_list_id']] != '') {
						$this->db->insert('subscriber_list_tbl', array('subscriber_id' => $subscriber_id, 'email_list_id' => $_REQUEST['email_list'][$email_list_array[$ela]['email_list_id']]));
					}
				}
				// Add Extra Field For this particular Subscriber //
				$extra_field_array = $this->extra_field->extra_field_display($this->db->tbl_pre . "extra_field_tbl", array(), "WHERE extra_field_status='Active'");
				for ($efa = 0; $efa < count($extra_field_array); $efa++) {
					if ($_REQUEST['extra_field'][$extra_field_array[$efa]['extra_field_id']] != '') {
						$this->db->insert('subscriber_extra_field_tbl', array('subscriber_id' => $subscriber_id, 'extra_field_value' => $_REQUEST['extra_field'][$extra_field_array[$efa]['extra_field_id']], 'extra_field_id' => $extra_field_array[$efa]['extra_field_id']));
					}
				}
				$this->db->update("subscriber_tbl", $subscriber_additional_array, "subscriber_id='" . $subscriber_id . "'");
				// Success Message For Insert a New Subscriber //
				$_SESSION['subscriber_msg'] = messagedisplay($subscriber_success_message, 1);
				header('location: add_subscriber.php');
				exit();
			} else {
				// Message For Nothing Insert //
				$_SESSION['subscriber_msg'] = messagedisplay($subscriber_unsuccess_message, 3);
			}
		} else {
			$_SESSION['subscriber_msg'] = messagedisplay($subscriber_duplicate_message, 2);
		}
	}
	public function subscriber_import_add($subscriber_array, $subscriber_additional_array) {
		$subscriber_add = $this->db->insert('subscriber_tbl', $subscriber_array);
		if ($subscriber_add['affectedRow'] > 0) {
			$subscriber_id = $subscriber_add['insertedId'];
			// Add Email list For this particular Subscriber //
			$email_list_array = $this->email_list->email_list_display($this->db->tbl_pre . "email_list_tbl", array(), "WHERE email_list_status='Active'");
			for ($ela = 0; $ela < count($email_list_array); $ela++) {
				if ($_REQUEST['email_list'][$email_list_array[$ela]['email_list_id']] != '') {
					$this->db->insert('subscriber_list_tbl', array('subscriber_id' => $subscriber_id, 'email_list_id' => $_REQUEST['email_list'][$email_list_array[$ela]['email_list_id']]));
				}
			}
			$this->db->update("subscriber_tbl", $subscriber_additional_array, "subscriber_id='" . $subscriber_id . "'");
		}
	}
// Subscriber Duplicate Check Function //
	public function subscriber_check($subscriber_id = '') {
		// Check Duplicate Subscriber Name //
		$subscriber_duplicate_check_sql = $this->db->query("select * from " . $this->db->tbl_pre . "subscriber_tbl where subscriber_email_address='" . rep($_REQUEST['subscriber_email_address']) . "' and subscriber_id!='" . $subscriber_id . "'");
		return $this->db->total($subscriber_duplicate_check_sql);
	}
// Subscriber Edit Function //
	public function subscriber_edit($subscriber_array, $subscriber_id, $subscriber_success_message, $subscriber_unsuccess_message, $subscriber_duplicate_message) {
		$subscriber_duplicate_check_num = $this->subscriber_check($subscriber_id);
		if ($subscriber_duplicate_check_num == 0) {
			$subscriber_update = $this->db->update('subscriber_tbl', $subscriber_array, "subscriber_id='" . $subscriber_id . "'");
			// Add Email list For this particular Subscriber //
			$subscriber_list_delete = $this->db->delete("subscriber_list_tbl", array('subscriber_id' => $subscriber_id));
			$email_list_array = $this->email_list->email_list_display($this->db->tbl_pre . "email_list_tbl", array(), "WHERE email_list_status='Active'");
			for ($ela = 0; $ela < count($email_list_array); $ela++) {
				if ($_REQUEST['email_list'][$email_list_array[$ela]['email_list_id']] != '') {
					$this->db->insert('subscriber_list_tbl', array('subscriber_id' => $subscriber_id, 'email_list_id' => $_REQUEST['email_list'][$email_list_array[$ela]['email_list_id']]));
				}
			}
			// Add Extra Field For this particular Subscriber //
			$subscriber_extra_field_delete = $this->db->delete("subscriber_extra_field_tbl", array('subscriber_id' => $subscriber_id));
			$extra_field_array = $this->extra_field->extra_field_display($this->db->tbl_pre . "extra_field_tbl", array(), "WHERE extra_field_status='Active'");
			for ($efa = 0; $efa < count($extra_field_array); $efa++) {
				if ($_REQUEST['extra_field'][$extra_field_array[$efa]['extra_field_id']] != '') {
					$this->db->insert('subscriber_extra_field_tbl', array('subscriber_id' => $subscriber_id, 'extra_field_value' => $_REQUEST['extra_field'][$extra_field_array[$efa]['extra_field_id']], 'extra_field_id' => $extra_field_array[$efa]['extra_field_id']));
				}
			}
			if ($subscriber_update['affectedRow'] > 0) {
				// Success Message For Update a Existing Subscriber //
				$_SESSION['subscriber_msg'] = messagedisplay($subscriber_success_message, 1);
				header('location:' . $_SESSION['subscriber_manage_url']);
				exit();
			} else {
				// Message For Nothing Update //
				$_SESSION['subscriber_msg'] = messagedisplay($subscriber_unsuccess_message, 3);
				header('location:' . $_SESSION['subscriber_manage_url']);
				exit();
			}
		} else {
			$_SESSION['subscriber_msg'] = messagedisplay($subscriber_duplicate_message, 2);
			header('location:' . $_SESSION['subscriber_manage_url']);
			exit();
		}
	}
	public function subscriber_import_edit($subscriber_array, $subscriber_id) {
		$subscriber_update = $this->db->update('subscriber_tbl', $subscriber_array, "subscriber_id='" . $subscriber_id . "'");
		// Add Email list For this particular Subscriber //
		$subscriber_list_delete = $this->db->delete("subscriber_list_tbl", array('subscriber_id' => $subscriber_id));
		$email_list_array = $this->email_list->email_list_display($this->db->tbl_pre . "email_list_tbl", array(), "WHERE email_list_status='Active'");
		for ($ela = 0; $ela < count($email_list_array); $ela++) {
			if ($_REQUEST['email_list'][$email_list_array[$ela]['email_list_id']] != '') {
				$this->db->insert('subscriber_list_tbl', array('subscriber_id' => $subscriber_id, 'email_list_id' => $_REQUEST['email_list'][$email_list_array[$ela]['email_list_id']]));
			}
		}
	}
// Subscriber Display Function //
	public function subscriber_display($sTable = '', $aColumns = '', $sWhere = '', $sLimit = '', $sOrder = '') {
		$subscriber_query = array('tbl_name' => $sTable, 'field' => $aColumns, 'condition' => $sWhere, 'limit' => $sLimit, 'orderby' => $sOrder);
		$subscriber_sql = $this->db->select($subscriber_query);
		$subscriber_array = $this->db->result($subscriber_sql);
		return $subscriber_array;
	}
// Subscriber Status Update Function //
	public function subscriber_status_update($subscriber_page_url) {
		$subscriber_id = $_REQUEST['cid'];
		if ($_REQUEST['current_status'] == 'Inactive') {
			$subscriber_status = 'Active';
		} else {
			$subscriber_status = 'Inactive';
		}
		$this->db->update('subscriber_tbl', array('subscriber_status' => ($subscriber_status)), "subscriber_id='" . $subscriber_id . "'");
		$_SESSION['subscriber_msg'] = messagedisplay('Subscriber\'s Status is updated successfully', 1);
		header('location: ' . $subscriber_page_url);
		exit();
	}
// Subscriber Delete Function //
	public function subscriber_delete($subscriber_page_url, $subscriber_front_delete) {
		$subscriber_id = $_REQUEST['cid'];
		$subscriber_delete = $this->db->delete("subscriber_tbl", array('subscriber_id' => $subscriber_id));
		$subscriber_list_delete = $this->db->delete("subscriber_list_tbl", array('subscriber_id' => $subscriber_id));
		$subscriber_extra_filed_delete = $this->db->delete("subscriber_extra_field_tbl", array('subscriber_id' => $subscriber_id));
		if ($subscriber_delete['affectedRow'] > 0) {
			$_SESSION['subscriber_msg'] = messagedisplay('Subscriber details deleted successfully', 1);
		} else {
			$_SESSION['subscriber_msg'] = messagedisplay('Nothing is deleted successfully', 2);
		}
		header('location: ' . $subscriber_page_url);
		exit();
	}
}
?>