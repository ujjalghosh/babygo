<?php
class babygo_notification {
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
	// notification Add Function //
	public function notification_add($notification_array, $notification_success_message, $notification_unsuccess_message, $notification_duplicate_message) {
		$notification_check = $this->notification_check($notification_id);
		if ($notification_check == 0) {
			$notification_add = $this->db->insert('notification_tbl', $notification_array);
			if ($notification_add['affectedRow'] > 0) {
				$notification_id = $notification_add['insertedId'];

 
				if ($_FILES['notfication_image']['size'] > 0) {
						$original = 'images/notification/';
						$banner_title = $_FILES['notfication_image']['name'];
						$banner_tmp = $_FILES['notfication_image']['tmp_name'];
						$banner_size = $_FILES['notfication_image']['size'];
						$banner_type = $_FILES['notfication_image']['type'];

						$banner_title_saved = str_replace("&", "and", $notification_id . "_" . $banner_title);
						$banner_title_saved = str_replace(" ", "_", $notification_id . "_" . $banner_title);
						$banner_img = $original . $banner_title_saved;
					//original path
						$banner_img1 = "../" . $banner_img;
						move_uploaded_file($banner_tmp, $banner_img1);
					//image upload
		$this->db->update("notification_tbl", array('notfication_image' =>$banner_title_saved),"notification_id='" . $notification_id . "'");
				}




				// Success Message For Insert a New notification_type_style //
				$_SESSION['notification_msg'] = messagedisplay($notification_success_message, 1);
				header('location: add_notification.php');
				exit();
			} else {
				// Message For Nothing Insert //
				$_SESSION['notification_msg'] = messagedisplay($notification_unsuccess_message, 3);
			}
		} else {
			$_SESSION['notification_msg'] = messagedisplay($notification_duplicate_message, 2);
		}
	}
	// notification Duplicate Check Function //
	public function notification_check($notification_id = '') {
		// Check Duplicate notification Name //
		$notification_duplicate_check_sql = $this->db->query("select * from " . $this->db->tbl_pre . "notification_tbl where  from_date='" . rep($_REQUEST['style_no']) . "' and to_date='" . rep($_REQUEST['to_date']) . "' and notfication_title='" . rep($_REQUEST['notfication_title']) . "' and notification_id!='" . $notification_id . "'");
		return $this->db->total($notification_duplicate_check_sql);
	}
	// notification Edit Function //
	public function notification_edit($notification_array, $notification_id, $notification_success_message, $notification_unsuccess_message, $notification_duplicate_message) {
		$notification_duplicate_check_num = $this->notification_check($notification_id);
		if ($notification_duplicate_check_num == 0) {
			$notification_update = $this->db->update('notification_tbl', $notification_array, "notification_id='" . $notification_id . "'");
 
			if ($notification_update['affectedRow'] > 0) {
				// Success Message For Update a Existing notification //

				if ($_FILES['notfication_image']['size'] > 0) {
						$original = 'images/notification/';
						$banner_title = $_FILES['notfication_image']['name'];
						$banner_tmp = $_FILES['notfication_image']['tmp_name'];
						$banner_size = $_FILES['notfication_image']['size'];
						$banner_type = $_FILES['notfication_image']['type'];

						$banner_title_saved = str_replace("&", "and", $notification_id . "_" . $banner_title);
						$banner_title_saved = str_replace(" ", "_", $notification_id . "_" . $banner_title);
						$banner_img = $original . $banner_title_saved;
					//original path
						$banner_img1 = "../" . $banner_img;
						move_uploaded_file($banner_tmp, $banner_img1);
					//image upload
		$this->db->update("notification_tbl", array('notfication_image' =>$banner_title_saved),"notification_id='" . $notification_id . "'");
				}


				$_SESSION['notification_msg'] = messagedisplay($notification_success_message, 1);
				header('location:' . $_SESSION['notification_manage_url']);
				exit();
			} else {
				// Message For Nothing Update //
				$_SESSION['notification_msg'] = messagedisplay($notification_unsuccess_message, 3);
				header('location:' . $_SESSION['notification_manage_url']);
				exit();
			}
		} else {
			$_SESSION['notification_msg'] = messagedisplay($notification_duplicate_message, 2);
			header('location:' . $_SESSION['notification_manage_url']);
			exit();
		}
	}
	// notification Display Function //
	public function notification_display($sTable = '', $aColumns = '', $sWhere = '', $sLimit = '', $snotification = '') {
		$notification_query = array('tbl_name' => $sTable, 'field' => $aColumns, 'condition' => $sWhere, 'limit' => $sLimit, 'notificationby' => $snotification);
		$notification_sql = $this->db->select($notification_query);
		$notification_array = $this->db->result($notification_sql);
		return $notification_array;
	}
	// notification Status Update Function //
	public function notification_status_update($notification_page_url) {
		$notification_id = $_REQUEST['cid'];
		if ($_REQUEST['current_status'] == 'Inactive') {
			$notification_status = 'Active';
		} else {
			$notification_status = 'Inactive';
		}
		$this->db->update('notification_tbl', array('notification_status' => ($notification_status)), "notification_id='" . $notification_id . "'");
		$_SESSION['notification_msg'] = messagedisplay('notification\'s Status is updated successfully', 1);
		header('location: ' . $notification_page_url);
		exit();
	}
	// notification Delete Function //
	public function notification_delete($notification_page_url) {
		$notification_id = $_REQUEST['cid'];
		$notification_delete = $this->db->delete("notification_tbl", array("notification_id" => $notification_id));
		 
		if ($notification_delete['affectedRow'] > 0) {
			$_SESSION['notification_msg'] = messagedisplay('notification details deleted successfully', 1);
		} else {
			$_SESSION['notification_msg'] = messagedisplay('Nothing is deleted successfully', 2);
		}
		header('location: ' . $notification_page_url);
		exit();
	}
}
?>