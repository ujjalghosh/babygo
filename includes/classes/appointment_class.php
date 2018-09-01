<?php
class homesmiles_appointment {
	public $recperpage;
	public $url;
	public $db;
	public $franchise;
	public $pricing;
	public $slot;
	public function __construct() {
		global $recperpage;
		global $url;
		global $db;
		global $franchise;
		global $pricing;
		global $slot;
		$this->recperpage = $recperpage;
		$this->url = $url;
		$this->db = $db;
		$this->franchise = $franchise;
		$this->pricing = $pricing;
		$this->slot = $slot;
	}
	// Appointment Add Function //
	public function appointment_add($appointment_array, $appointment_success_message, $appointment_unsuccess_message, $appointment_duplicate_message) {
		$appointment_duplicate_check_num = $this->appointment_check($appointment_id);
		if ($appointment_duplicate_check_num == 0) {
			$appointment_add = $this->db->insert('appointment_tbl', $appointment_array);
			if ($appointment_add['affectedRow'] > 0) {
				$appointment_id = $appointment_add['insertedId'];
				$franchise_zip_code_array = $this->franchise->franchise_display($this->db->tbl_pre . "franchise_zip_code_tbl", array(), "WHERE zip_code_id=" . $appointment_array['zip_code_id'] . "");
				$pricing_array = $this->pricing->pricing_display($this->db->tbl_pre . "pricing_tbl", array(), "WHERE pricing_id=" . $appointment_array['pricing_id'] . "");
				$appointment_total_price = $pricing_array[0]['pricing_amount'] + $appointment_array['appointment_story_price'];
				$appointment_additional_array = array('appointment_price' => $pricing_array[0]['pricing_amount'], 'appointment_total_price' => $appointment_total_price, 'franchise_id' => $franchise_zip_code_array[0]['franchise_id'] != '' ? $franchise_zip_code_array[0]['franchise_id'] : 0, 'appointment_creation_date' => date("Y-m-d"));
				//print_r($appointment_additional_array);
				$this->db->update("appointment_tbl", $appointment_additional_array, "appointment_id='" . $appointment_id . "'");
				// Success Message For Insert a New Appointment //
				$_SESSION['appointment_msg'] = messagedisplay($appointment_success_message, 1);
				header('location: add_appointment.php');
				exit();
			} else {
				// Message For Nothing Insert //
				$_SESSION['appointment_msg'] = messagedisplay($appointment_unsuccess_message, 3);
			}
		} else {
			$_SESSION['appointment_msg'] = messagedisplay($appointment_duplicate_message, 2);
		}
	}
// Appointment Duplicate Check Function //
	public function appointment_check($appointment_id = '') {
		// Check Duplicate Appointment Name //
		$appointment_duplicate_check_sql = $this->db->query("select * from " . $this->db->tbl_pre . "appointment_tbl where appointment_date='" . $_REQUEST['appointment_date'] . "' and appointment_slot_id='" . $_REQUEST['appointment_slot_id'] . "' and zip_code_id='" . $_REQUEST['zip_code_id'] . "' and appointment_id!='" . $appointment_id . "'");
		return $this->db->total($appointment_duplicate_check_sql);
	}
// Appointment Edit Function //
	public function appointment_edit($appointment_array, $appointment_id, $appointment_success_message, $appointment_unsuccess_message, $appointment_duplicate_message) {
		$appointment_duplicate_check_num = $this->appointment_check($appointment_id);
		if ($appointment_duplicate_check_num == 0) {
			$appointment_update = $this->db->update('appointment_tbl', $appointment_array, "appointment_id='" . $appointment_id . "'");
			$franchise_zip_code_array = $this->franchise->franchise_display($this->db->tbl_pre . "franchise_zip_code_tbl", array(), "WHERE zip_code_id=" . $appointment_array['zip_code_id'] . "");
			$pricing_array = $this->pricing->pricing_display($this->db->tbl_pre . "pricing_tbl", array(), "WHERE pricing_id=" . $appointment_array['pricing_id'] . "");
			$appointment_total_price = $pricing_array[0]['pricing_amount'] + $appointment_array['appointment_story_price'];
			$appointment_additional_array = array('appointment_price' => $pricing_array[0]['pricing_amount'], 'appointment_total_price' => $appointment_total_price, 'franchise_id' => $franchise_zip_code_array[0]['franchise_id'] != '' ? $franchise_zip_code_array[0]['franchise_id'] : 0);
			//print_r($appointment_additional_array);
			$appointment_additional_update = $this->db->update("appointment_tbl", $appointment_additional_array, "appointment_id='" . $appointment_id . "'");
			if ($appointment_update['affectedRow'] > 0 || $appointment_additional_update['affectedRow'] > 0) {
				// Success Message For Update a Existing Appointment //
				$_SESSION['appointment_msg'] = messagedisplay($appointment_success_message, 1);
				header('location:' . $_SESSION['appointment_manage_url']);
				exit();
			} else {
				// Message For Nothing Update //
				$_SESSION['appointment_msg'] = messagedisplay($appointment_unsuccess_message, 3);
				header('location:' . $_SESSION['appointment_manage_url']);
				exit();
			}
		} else {
			$_SESSION['appointment_msg'] = messagedisplay($appointment_duplicate_message, 2);
			header('location:' . $_SESSION['appointment_manage_url']);
			exit();
		}
	}
// Appointment Display Function //
	public function appointment_display($sTable = '', $aColumns = '', $sWhere = '', $sLimit = '', $sOrder = '') {
		$appointment_query = array('tbl_name' => $sTable, 'field' => $aColumns, 'condition' => $sWhere, 'limit' => $sLimit, 'orderby' => $sOrder);
		$appointment_sql = $this->db->select($appointment_query);
		$appointment_array = $this->db->result($appointment_sql);
		return $appointment_array;
	}
// Appointment Status Update Function //
	public function appointment_status_update($appointment_page_url) {
		$appointment_id = $_REQUEST['cid'];
		if ($_REQUEST['current_status'] == 'Inactive') {
			$appointment_status = 'Active';
		} else {
			$appointment_status = 'Inactive';
		}
		$this->db->update('appointment_tbl', array('appointment_status' => ($appointment_status)), "appointment_id='" . $appointment_id . "'");
		$_SESSION['appointment_msg'] = messagedisplay('Appointment\'s Status is updated successfully', 1);
		header('location: ' . $appointment_page_url);
		exit();
	}
// Appointment Delete Function //
	public function appointment_delete($appointment_page_url, $appointment_front_delete) {
		$appointment_id = $_REQUEST['cid'];
		$appointment_delete = $this->db->delete("appointment_tbl", array('appointment_id' => $appointment_id));
		if ($appointment_delete['affectedRow'] > 0) {
			$_SESSION['appointment_msg'] = messagedisplay('Appointment details deleted successfully', 1);
		} else {
			$_SESSION['appointment_msg'] = messagedisplay('Nothing is deleted successfully', 2);
		}
		header('location: ' . $appointment_page_url);
		exit();
	}


	// Appointment Booking Function from front-end //
	public function appointment_booking($appointment_array, $appointment_success_message, $appointment_unsuccess_message, $appointment_duplicate_message) {
$appointment_duplicate_check_num = $this->appointment_check($appointment_id);
		if ($appointment_duplicate_check_num == 0) {
			$appointment_add = $this->db->insert('appointment_tbl', $appointment_array);
			if ($appointment_add['affectedRow'] > 0) {
				$appointment_id = $appointment_add['insertedId'];
				$franchise_zip_code_array = $this->franchise->franchise_display($this->db->tbl_pre . "franchise_zip_code_tbl", array(), "WHERE zip_code_id=" . $appointment_array['zip_code_id'] . "");
				$pricing_array = $this->pricing->pricing_display($this->db->tbl_pre . "pricing_tbl", array(), "WHERE pricing_id=" . $appointment_array['pricing_id'] . "");
				$appointment_total_price = $pricing_array[0]['pricing_amount'] + $appointment_array['appointment_story_price'];
				$appointment_additional_array = array('appointment_price' => $pricing_array[0]['pricing_amount'], 'appointment_total_price' => $appointment_total_price, 'franchise_id' => $franchise_zip_code_array[0]['franchise_id'] != '' ? $franchise_zip_code_array[0]['franchise_id'] : 0, 'appointment_creation_date' => date("Y-m-d"));
				//print_r($appointment_additional_array);
				$this->db->update("appointment_tbl", $appointment_additional_array, "appointment_id='" . $appointment_id . "'");
				// Success Message For Insert a New Appointment //
				$_SESSION['appointment_msg'] = messagedisplay($appointment_success_message, 1);

				unset($_SESSION['appointment_slot_id']);
				unset($_SESSION['appointment_date']);
				unset($_SESSION['customer_first_name']);
				unset($_SESSION['customer_last_name']);
				unset($_SESSION['customer_address']);
				unset($_SESSION['customer_city']);
				unset($_SESSION['customer_email_address']);
				unset($_SESSION['zip_code_id']);
				unset($_SESSION['areaCode']);
				unset($_SESSION['phoneNo']);
				unset($_SESSION['customer_phone_number_for']);
				unset($_SESSION['customer_unit_number']);
				unset($_SESSION['customer_address_type']);
				unset($_SESSION['pricing_id']);
				unset($_SESSION['appointment_story_price']);
			
				
/*$time_sql=$this->db->query("select * from " . $this->db -> tbl_pre . "slot_tbl where  slot_id='".$appointment_array['appointment_slot_id']."' ");
	$time_object=$this->db->fetch_object($time_sql);*/
	//$slot_array = $this->slot->slot_display($this->db->tbl_pre . "slot_tbl", array(), "WHERE slot_id=" . $appointment_array['appointment_slot_id'] . "");

	//$this->slot->slot_display($this->db->tbl_pre . "slot_tbl", array(), "WHERE slot_id=1");
	$time_object = $this->slot->slot_display($this->db->tbl_pre . "slot_tbl", array(), "WHERE slot_id=" . $appointment_array['appointment_slot_id'] . "");
	 $time= $time_object[0]['slot_type']." - " .$time_object[0]['slot_start_hour'] . '.' . $time_object[0]['slot_start_minute'] . ' - ' . $time_object[0]['slot_end_hour'] . '.' . $time_object[0]['slot_end_minute'] ;

  $text="<html><body>\n";
  $text=$text."<table border='0' cellpadding='6' width='600' align='center'>\n";

  $text=$text."<tr>\n";
  $text=$text."<td colspan=2 align='left'><p align='justify' style='line-height:140%'><table width='100%' border='0' cellspacing='0' cellpadding='0'>

  <tr>
    <td align='left' valign='top'>
      <table width='100%' border='0' cellspacing='2' cellpadding='1'>
        <tr>
          <td height='24' colspan='3' align='left' valign='top'><h3>Appoinment Request </h3></td>
        </tr>
        <tr>
          <td width='37%' align='left' valign='top'>First Name</td>
          <td width='2%' align='left' valign='top'><strong>:</strong></td>
          <td width='61%' align='left' valign='top'>".$appointment_array['customer_first_name']."</td>
        </tr>

        <tr>
          <td width='37%' align='left' valign='top'>Last Name :</td>
          <td width='2%' align='left' valign='top'><strong>:</strong></td>
          <td width='61%' align='left' valign='top'>".$appointment_array['customer_last_name']."</td>
        </tr>
        <tr>
          <td width='37%' align='left' valign='top'>Email Address</td>
          <td width='2%' align='left' valign='top'><strong>:</strong></td>
          <td width='61%' align='left' valign='top'>".$appointment_array['customer_email_address']." </td>
        </tr>
         <tr>
          <td width='37%' align='left' valign='top'>Phone Number</td>
          <td width='2%' align='left' valign='top'><strong>:</strong></td>
          <td width='61%' align='left' valign='top'> ".$appointment_array['customer_phone_number']." ".$appointment_array['customer_phone_number_for']." </td>
        </tr>
        <tr>
          <td width='37%' align='left' valign='top'>Appointment Date</td>
          <td width='2%' align='left' valign='top'><strong>:</strong></td>
          <td width='61%' align='left' valign='top'>".$appointment_array['appointment_date']."</td>
        </tr>
        <tr>
          <td width='37%' align='left' valign='top'>Appointment Time</td>
          <td width='2%' align='left' valign='top'><strong>:</strong></td>
          <td width='61%' align='left' valign='top'>".$time. "</td>
        </tr>
      </table></td>
    </tr>
  </table>

</td>\n";
$text=$text."</tr>\n";

$text=$text."</table>\n";
$text=$text."</body></html>\n";
  

$mail_to=$appointment_array['customer_email_address'];
$mail_fm=Site_Title." <".Admin_Sending_Email_ID.">";
$mail_subject="Appointment Confirmation";

$mail_body=$text;
$mail_headers="From: $mail_fm\r\nContent-type: text/html";
mail($mail_to,$mail_subject,$mail_body,$mail_headers);
//**** Admin mail*****
$mail_to_admin=Admin_Receiving_Email_ID;
$mail_subject_admin="New Appointment";
mail($mail_to_admin,$mail_subject_admin,$mail_body,$mail_headers);


	header('location: '.$_SESSION['front_end_manage_url']);
		 exit();
		} else {
				// Message For Nothing Insert //
				$_SESSION['front_end_msg'] = messagedisplay($appointment_unsuccess_message, 3);
			}
		} else {
			$_SESSION['front_end_msg'] = messagedisplay($appointment_duplicate_message, 2);
		}
	}
}
?>