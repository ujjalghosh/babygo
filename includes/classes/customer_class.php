<?php
class babygo_customer {
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
	// customer Add Function //
	public function customer_add($customer_array, $customer_success_message, $customer_unsuccess_message, $customer_duplicate_message) {
		$customer_duplicate_check_num = $this->customer_check($customer_id);
		if ($customer_duplicate_check_num == 0) {
			$customer_add = $this->db->insert('customer_tbl', $customer_array);
			if ($customer_add['affectedRow'] > 0) {
				$customer_id = $customer_add['insertedId'];
				$this->db->update("customer_tbl", array('customer_creation_date' => date("Y-m-d H:i:s")), "customer_id='" . $customer_id . "'");
				 
				// Login Details email to Admin //
				$registration_message = '<html><body><table width="640" border="0" cellspacing="0" cellpadding="0" style="margin:0;"><tr><td align="left" valign="top"><img src="' . SITE_URL . 'administrator/timthumb.php?src=' . SITE_URL . '' . Site_Logo . '&w=150&h=100&zc=3" alt="" style="margin:0; padding:0;" ></td></tr><tr><td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#000000;"><p> 	Dear ' . $customer_array['customer_name'] . ' ,<br />
				Congratulations!  Your details has been successfully registered with our site.<br />
				Your Account details are:<br />
				<br />
				Email Address:&nbsp; ' . $customer_array['customer_email'] . ' <br />
				Password:&nbsp;  ' . decode($customer_array['customer_password']) . '</p>
				<p>To login to your account, please <a href="' . SITE_URL . '/login/">click here</a>.</p>
				<p>Thank you and Welcome to ' . Site_Title . '</p></td></tr></table></body></html>';
				$this->mailsend->FromName = Site_Title;
				$this->mailsend->From = Admin_Sending_Email_ID;
				$this->mailsend->Subject = 'Registration Notification: ' . Site_Title;
				$this->mailsend->Body = $registration_message;
				$this->mailsend->IsHTML(true);
				$this->mailsend->AddAddress($customer_array['customer_email'], '');
				$sss = $this->mailsend->Send();
				$this->mailsend->ClearAddresses();
				$this->mailsend->ClearAttachments();
				// Success Message For Insert a New customer //
				$_SESSION['customer_msg'] = messagedisplay($customer_success_message, 1);
				header('location: add_customer.php');
				exit();
			} else {
				// Message For Nothing Insert //
				$_SESSION['customer_msg'] = messagedisplay($customer_unsuccess_message, 3);
			}
		} else {
			$_SESSION['customer_msg'] = messagedisplay($customer_duplicate_message, 2);
		}
	}
	// customer Duplicate Check Function //
	public function customer_check($customer_id = '') {
		// Check Duplicate customer Name //
		$customer_duplicate_check_sql = $this->db->query("select * from " . $this->db->tbl_pre . "customer_tbl where customer_email='" . rep($_REQUEST['customer_email']) . "' and customer_id!='" . $customer_id . "'");
		return $this->db->total($customer_duplicate_check_sql);
	}
	// customer Edit Function //
	public function customer_edit($customer_array, $customer_id, $customer_success_message, $customer_unsuccess_message, $customer_duplicate_message) {
		$customer_duplicate_check_num = $this->customer_check($customer_id);
		if ($customer_duplicate_check_num == 0) {
			$customer_update = $this->db->update('customer_tbl', $customer_array, "customer_id='" . $customer_id . "'");
 
			if ($customer_update['affectedRow'] > 0) {
				// Success Message For Update a Existing customer //
				$_SESSION['customer_msg'] = messagedisplay($customer_success_message, 1);
				header('location:' . $_SESSION['customer_manage_url']);
				exit();
			} else {
				// Message For Nothing Update //
				$_SESSION['customer_msg'] = messagedisplay($customer_unsuccess_message, 3);
				header('location:' . $_SESSION['customer_manage_url']);
				exit();
			}
		} else {
			$_SESSION['customer_msg'] = messagedisplay($customer_duplicate_message, 2);
			header('location:' . $_SESSION['customer_manage_url']);
			exit();
		}
	}
	// customer Display Function //
	public function customer_display($sTable = '', $aColumns = '', $sWhere = '', $sLimit = '', $sOrder = '') {
		$customer_query = array('tbl_name' => $sTable, 'field' => $aColumns, 'condition' => $sWhere, 'limit' => $sLimit, 'orderby' => $sOrder);
		$customer_sql = $this->db->select($customer_query);
		$customer_array = $this->db->result($customer_sql);
		return $customer_array;
	}
	// customer Status Update Function //
	public function customer_status_update($customer_page_url) {
		$customer_id = $_REQUEST['cid'];
		if ($_REQUEST['current_status'] == 'Inactive') {
			$customer_status = 'Active';
		} else {
			$customer_status = 'Inactive';
		}
		$this->db->update('customer_tbl', array('customer_status' => ($customer_status)), "customer_id='" . $customer_id . "'");
		$_SESSION['customer_msg'] = messagedisplay('customer\'s Status is updated successfully', 1);
		if ($customer_status == 'Active') {
		$user=  $this->customer_display($this->db->tbl_pre . "customer_tbl", array(), "WHERE customer_id=" . $customer_id . "");

		$registration_message = '<html><body><table width="640" border="0" cellspacing="0" cellpadding="0" style="margin:0;"><tr><td align="left" valign="top"><img src="' . SITE_URL . 'administrator/timthumb.php?src=' . SITE_URL . '' . Site_Logo . '&w=150&h=100&zc=3" alt="" style="margin:0; padding:0;" ></td></tr><tr><td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#000000;"><p> 	Dear ' . $customer_array['customer_name'] . ' ,<br />
				Congratulations!  Your account has been successfully activated you can login and place your order.<br />
				Your Account details are:<br />
				<br />
				Email Address:&nbsp; ' . $user[0]["customer_email"] . ' <br />
				Password:&nbsp;  ' . decode($user[0]['customer_password']) . '</p>
				<p>To login to your account, please <a href="' . SITE_URL . '/sign-in.php/">click here</a>.</p>
				<p>Thank you and Welcome to ' . Site_Title . '</p></td></tr></table></body></html>';
				$this->mailsend->FromName = Site_Title;
				$this->mailsend->From = Admin_Sending_Email_ID;
				$this->mailsend->Subject = 'Account confirmation: ' . Site_Title;
				$this->mailsend->Body = $registration_message;
				$this->mailsend->IsHTML(true);
				$this->mailsend->AddAddress($user[0]["customer_email"], '');
				$sss = $this->mailsend->Send();
				$this->mailsend->ClearAddresses();
				$this->mailsend->ClearAttachments();


		}
		header('location: ' . $customer_page_url);
		exit();
	}
	// customer Delete Function //
	public function customer_delete($customer_page_url) {
		$customer_id = $_REQUEST['cid'];
		$customer_delete = $this->db->delete("customer_tbl", array("customer_id" => $customer_id));
		 
		if ($customer_delete['affectedRow'] > 0) {
			$_SESSION['customer_msg'] = messagedisplay('customer details deleted successfully', 1);
		} else {
			$_SESSION['customer_msg'] = messagedisplay('Nothing is deleted successfully', 2);
		}
		header('location: ' . $customer_page_url);
		exit();
	}


//******************************************************API 
	public function customer_check_app($customer_mail) {
		// Check Duplicate customer Name //
		$customer_duplicate_check_sql = $this->db->query("select * from " . $this->db->tbl_pre . "customer_tbl where customer_email='" . rep($customer_mail) . "'  ");
		return $this->db->total($customer_duplicate_check_sql);
	}
	public function customer_register($customer_array, $customer_success_message, $customer_unsuccess_message, $customer_duplicate_message) {
		$customer_duplicate_check_num = $this->customer_check_app($customer_array['customer_email']);
		if ($customer_duplicate_check_num == 0) {
			$customer_add = $this->db->insert('customer_tbl', $customer_array);
			if ($customer_add['affectedRow'] > 0) {
				$customer_id = $customer_add['insertedId'];
				$this->db->update("customer_tbl", array('customer_creation_date' => date("Y-m-d H:i:s")), "customer_id='" . $customer_id . "'");
				 
				// Login Details email to Admin //
				$registration_message = '<html><body><table width="640" border="0" cellspacing="0" cellpadding="0" style="margin:0;"><tr><td align="left" valign="top"><img src="' . SITE_URL . 'administrator/timthumb.php?src=' . SITE_URL . '' . Site_Logo . '&w=150&h=100&zc=3" alt="" style="margin:0; padding:0;" ></td></tr><tr><td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#000000;"><p> 	Dear ' . $customer_array['customer_name'] . ' ,<br />
				Congratulations!  Your details has been successfully registered with our site.<br />
				Your Account details are:<br />
				<br />
				Email Address:&nbsp; ' . $customer_array['customer_email'] . ' <br />
				Password:&nbsp;  ' . decode($customer_array['customer_password']) . '</p>
				<p>To login to your account, please <a href="' . SITE_URL . '/sign-in.php/">click here</a>.</p>
				<p>Thank you and Welcome to ' . Site_Title . '</p></td></tr></table></body></html>';
				$this->mailsend->FromName = Site_Title;
				$this->mailsend->From = Admin_Sending_Email_ID;
				$this->mailsend->Subject = 'Registration Notification: ' . Site_Title;
				$this->mailsend->Body = $registration_message;
				$this->mailsend->IsHTML(true);
				$this->mailsend->AddAddress($customer_array['customer_email'], '');
				$sss = $this->mailsend->Send();
				$this->mailsend->ClearAddresses();
				$this->mailsend->ClearAttachments();

				$admin_message = '<html><body><table width="640" border="0" cellspacing="0" cellpadding="0" style="margin:0;"><tr><td align="left" valign="top"><img src="' . SITE_URL . 'administrator/timthumb.php?src=' . SITE_URL . '' . Site_Logo . '&w=150&h=100&zc=3" alt="" style="margin:0; padding:0;" ></td></tr><tr><td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#000000;"><p> 	Dear Admin ,<br />
				Congratulations!  a new user registered with your site.<br />
				Your Account details are:<br />
				<br />
				Email Address:&nbsp; ' . $customer_array['customer_email'] . ' <br />
				Name:&nbsp;  ' . $customer_array['customer_name'] . '</p>
				<p>To login to your account, please <a href="' . SITE_URL . '/administrator/">click here</a>.</p>
				<p>Thank you and Welcome to ' . Site_Title . '</p></td></tr></table></body></html>';
				$this->mailsend->FromName = Site_Title;
				$this->mailsend->From = Admin_Sending_Email_ID;
				$this->mailsend->Subject = 'Registration Notification: ' . Site_Title;
				$this->mailsend->Body = $admin_message;
				$this->mailsend->IsHTML(true);
				$this->mailsend->AddAddress(Admin_Receiving_Email_ID, '');
				$sss = $this->mailsend->Send();
				$this->mailsend->ClearAddresses();
				$this->mailsend->ClearAttachments();

				// Success Message For Insert a New customer //
				$user=  $this->customer_display($this->db->tbl_pre . "customer_tbl", array(), "WHERE customer_id=" . $customer_id . "");

				$response["status"]               = TRUE;
				$response["msg"] = $customer_success_message;
                $response["customer_id"]                    = $user[0]["customer_id"];
                $response["user"]["customer_name"]          = $user[0]["customer_name"];
                $response["user"]["customer_email"]         = $user[0]["customer_email"];
                $response["user"]["customer_phone_number"]  = $user[0]["customer_phone_number"];
                $response["user"]["Company_name"]           = $user[0]["Company_name"];
                $response["user"]["customer_address"]       = $user[0]["customer_address"];
                $response["user"]["customer_creation_date"] = $user[0]["customer_creation_date"];
                $response["user"]["customer_status"]        = $user[0]["customer_status"];
return $response;


			} else {
				// Message For Nothing Insert //
				$response["status"] = false;
                $response["msg"] = $customer_unsuccess_message;
				return $response;
			}
		} else {
			 
			$response["status"] = false;
                $response["msg"] = $customer_duplicate_message;
				return $response;
		}
	}

		public function customer_profile_update($customer_array, $customer_id, $customer_success_message, $customer_unsuccess_message, $customer_duplicate_message) {
 
			$customer_update = $this->db->update('customer_tbl', $customer_array, "customer_id='" . $customer_id . "'");
 
			if ($customer_update['affectedRow'] > 0) {
				// Success Message For Update a Existing customer //
				$user=  $this->customer_display($this->db->tbl_pre . "customer_tbl", array(), "WHERE customer_id=" . $customer_id . "");
				$response["status"] = TRUE;
                $response["msg"] = $customer_success_message;
                $response["customer_id"]                    = $user[0]["customer_id"];
                $response["user"]["customer_name"]          = $user[0]["customer_name"];
                $response["user"]["customer_email"]         = $user[0]["customer_email"];
                $response["user"]["customer_phone_number"]  = $user[0]["customer_phone_number"];
                $response["user"]["Company_name"]           = $user[0]["Company_name"];
                $response["user"]["billing_address"]        = strip_tags($user[0]["customer_address"]);
                $response["user"]["shipping_address"]       = strip_tags($user[0]["shipping_address"]);
                $response["user"]["vat_no"]                 = $user[0]["vat_no"];
                $response["user"]["cst_no"]                 = $user[0]["cst_no"];
                $response["user"]["pan_no"]                 = $user[0]["pan_no"];
				return $response;
			} else {
				// Message For Nothing Update //
				$response["status"] = false;
                $response["msg"] = $customer_unsuccess_message;
				return $response;
			}
 
	}


	public function password_change($customer_array, $customer_id, $customer_success_message, $customer_unsuccess_message, $customer_duplicate_message) {
 
			$customer_update = $this->db->update('customer_tbl', $customer_array, "customer_id='" . $customer_id . "'");
 
			if ($customer_update['affectedRow'] > 0) {
				// Success Message For Update a Existing customer //
				$response["status"] = FALSE;
                $response["msg"] = $customer_success_message;
				return $response;
				 
			} else {
				// Message For Nothing Update //
				$response["status"] = TRUE;
                $response["msg"] = $customer_unsuccess_message;
				return $response;
			}
 
	}

}
?>