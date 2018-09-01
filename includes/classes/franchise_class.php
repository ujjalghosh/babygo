<?php
class homesmiles_franchise {
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
		$this->zip_code = $zip_code;
	}
	// Franchise Add Function //
	public function franchise_add($franchise_array, $franchise_success_message, $franchise_unsuccess_message, $franchise_duplicate_message) {
		$franchise_duplicate_check_num = $this->franchise_check($franchise_id);
		if ($franchise_duplicate_check_num == 0) {
			$franchise_add = $this->db->insert('franchise_tbl', $franchise_array);
			if ($franchise_add['affectedRow'] > 0) {
				$franchise_id = $franchise_add['insertedId'];
				$this->db->update("franchise_tbl", array('franchise_creation_date' => date("Y-m-d H:i:s")), "franchise_id='" . $franchise_id . "'");
				 
				// Login Details email to Admin //
				$registration_message = '<html><body><table width="640" border="0" cellspacing="0" cellpadding="0" style="margin:0;"><tr><td align="left" valign="top"><img src="' . SITE_URL . 'administrator/timthumb.php?src=' . SITE_URL . '' . Site_Logo . '&w=150&h=100&zc=3" alt="" style="margin:0; padding:0;" ></td></tr><tr><td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#000000;"><p> 	Dear ' . $franchise_array['franchise_name'] . ' ,<br />
				Congratulations!  Your details has been successfully registered with our site.<br />
				Your Account details are:<br />
				<br />
				Email Address:&nbsp; ' . $franchise_array['franchise_email'] . ' <br />
				Password:&nbsp;  ' . decode($franchise_array['franchise_password']) . '</p>
				<p>To login to your account, please <a href="' . SITE_URL . '/login/">click here</a>.</p>
				<p>Thank you and Welcome to ' . Site_Title . '</p></td></tr></table></body></html>';
				$this->mailsend->FromName = Site_Title;
				$this->mailsend->From = Admin_Sending_Email_ID;
				$this->mailsend->Subject = 'Registration Notification: ' . Site_Title;
				$this->mailsend->Body = $registration_message;
				$this->mailsend->IsHTML(true);
				$this->mailsend->AddAddress($franchise_array['franchise_email'], '');
				$sss = $this->mailsend->Send();
				$this->mailsend->ClearAddresses();
				$this->mailsend->ClearAttachments();
				// Success Message For Insert a New Franchise //
				$_SESSION['franchise_msg'] = messagedisplay($franchise_success_message, 1);
				header('location: add_franchise.php');
				exit();
			} else {
				// Message For Nothing Insert //
				$_SESSION['franchise_msg'] = messagedisplay($franchise_unsuccess_message, 3);
			}
		} else {
			$_SESSION['franchise_msg'] = messagedisplay($franchise_duplicate_message, 2);
		}
	}
	// Franchise Duplicate Check Function //
	public function franchise_check($franchise_id = '') {
		// Check Duplicate Franchise Name //
		$franchise_duplicate_check_sql = $this->db->query("select * from " . $this->db->tbl_pre . "franchise_tbl where franchise_email='" . rep($_REQUEST['franchise_email']) . "' and franchise_id!='" . $franchise_id . "'");
		return $this->db->total($franchise_duplicate_check_sql);
	}
	// Franchise Edit Function //
	public function franchise_edit($franchise_array, $franchise_id, $franchise_success_message, $franchise_unsuccess_message, $franchise_duplicate_message) {
		$franchise_duplicate_check_num = $this->franchise_check($franchise_id);
		if ($franchise_duplicate_check_num == 0) {
			$franchise_update = $this->db->update('franchise_tbl', $franchise_array, "franchise_id='" . $franchise_id . "'");
 
			if ($franchise_update['affectedRow'] > 0) {
				// Success Message For Update a Existing Franchise //
				$_SESSION['franchise_msg'] = messagedisplay($franchise_success_message, 1);
				header('location:' . $_SESSION['franchise_manage_url']);
				exit();
			} else {
				// Message For Nothing Update //
				$_SESSION['franchise_msg'] = messagedisplay($franchise_unsuccess_message, 3);
				header('location:' . $_SESSION['franchise_manage_url']);
				exit();
			}
		} else {
			$_SESSION['franchise_msg'] = messagedisplay($franchise_duplicate_message, 2);
			header('location:' . $_SESSION['franchise_manage_url']);
			exit();
		}
	}
	// Franchise Display Function //
	public function franchise_display($sTable = '', $aColumns = '', $sWhere = '', $sLimit = '', $sOrder = '') {
		$franchise_query = array('tbl_name' => $sTable, 'field' => $aColumns, 'condition' => $sWhere, 'limit' => $sLimit, 'orderby' => $sOrder);
		$franchise_sql = $this->db->select($franchise_query);
		$franchise_array = $this->db->result($franchise_sql);
		return $franchise_array;
	}
	// Franchise Status Update Function //
	public function franchise_status_update($franchise_page_url) {
		$franchise_id = $_REQUEST['cid'];
		if ($_REQUEST['current_status'] == 'Inactive') {
			$franchise_status = 'Active';
		} else {
			$franchise_status = 'Inactive';
		}
		$this->db->update('franchise_tbl', array('franchise_status' => ($franchise_status)), "franchise_id='" . $franchise_id . "'");
		$_SESSION['franchise_msg'] = messagedisplay('Franchise\'s Status is updated successfully', 1);
		header('location: ' . $franchise_page_url);
		exit();
	}
	// Franchise Delete Function //
	public function franchise_delete($franchise_page_url) {
		$franchise_id = $_REQUEST['cid'];
		$franchise_delete = $this->db->delete("franchise_tbl", array("franchise_id" => $franchise_id));
		 
		if ($franchise_delete['affectedRow'] > 0) {
			$_SESSION['franchise_msg'] = messagedisplay('Franchise details deleted successfully', 1);
		} else {
			$_SESSION['franchise_msg'] = messagedisplay('Nothing is deleted successfully', 2);
		}
		header('location: ' . $franchise_page_url);
		exit();
	}
}
?>