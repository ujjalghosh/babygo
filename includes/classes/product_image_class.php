<?php
class babygo_product_image {
	public $recperpage;
	public $url;
	public $db;
	public $product_image_owner;

	public function __construct() {
		global $recperpage;
		global $url;
		global $db;
		global $product_image_owner;

		$this->recperpage = $recperpage;
		$this->url = $url;
		$this->db = $db;
		$this->product_image_owner = $product_image_owner;
		
	}

	// product_image Add Function //
	public function product_image_add($product_image_array, $product_image_success_message, $product_image_unsuccess_message, $product_image_duplicate_message) {
		 $product_image_duplicate_check_num = $this->product_image_check($color_image_id);
		 if ($product_image_duplicate_check_num == 0) {
			$product_image_add = $this->db->insert('color_image_tbl', $product_image_array);
			if ($product_image_add['affectedRow'] > 0) {
				$color_image_id = $product_image_add['insertedId'];
			 	 

			 	// Upload Product Listing Image //
				if ($_FILES['listing_image']['size'] > 0) {
					
					$original = 'images/color/listing/';
					$listing_image_name = $_FILES['listing_image']['name'];
					$listing_image_tmp = $_FILES['listing_image']['tmp_name'];
					$listing_image_size = $_FILES['listing_image']['size'];
					$listing_image_type = $_FILES['listing_image']['type'];

					$listing_image_name_saved = str_replace("&", "and", $color_image_id . "_" . $listing_image_name);
					$listing_image_name_saved = str_replace(" ", "_", $color_image_id . "_" . $listing_image_name);
					$listing_image_img = '../' . $original . $listing_image_name_saved;
					move_uploaded_file($listing_image_tmp, $listing_image_img);
					//image upload
					$this->db->update("color_image_tbl", array('listing_image' => ($listing_image_name_saved)), "color_image_id='" . $color_image_id . "'");
				}
				//Upload Product Additional Images //
				for ($i = 0; $i < count($_FILES['style_color_image']['name']); $i++) {
					$original = 'images/color/set/';
					$style_color_image_name = $_FILES['style_color_image']['name'][$i];
					$style_color_image_tmp = $_FILES['style_color_image']['tmp_name'][$i];
					$style_color_image_size = $_FILES['style_color_image']['size'][$i];
					$style_color_image_type = $_FILES['style_color_image']['type'][$i];

					$style_color_name_saved = str_replace("&", "and", $color_image_id . "_" . $style_color_image_name);
					$style_color_name_saved = str_replace(" ", "_", $color_image_id . "_" . $style_color_image_name);
					$listing_image_img = '../' . $original . $style_color_name_saved;
					move_uploaded_file($listing_image_tmp, $listing_image_img);
 $this->db->insert("product_images_tbl", array('product_id' => ($product_image_array["product_id"]),'color_image_id'=>rep($color_image_id),'style_color_image'=>$style_color_name_saved) );
				}
 



				// Success Message For Insert a New product_image //
				$_SESSION['product_image_msg'] = messagedisplay($product_image_success_message, 1);
				header('location: add_product_image.php');
				exit();
			} else {
				// Message For Nothing Insert //
				$_SESSION['product_image_msg'] = messagedisplay($product_image_unsuccess_message, 3);
			}
		 } else {
		 	$_SESSION['product_image_msg'] = messagedisplay($product_image_duplicate_message, 2);
		 }
	}

	// product_image Duplicate Check Function //
	public function product_image_check($color_image_id = '') {
		// Check Duplicate product_image AR number //
		$product_image_duplicate_check_sql = $this->db->query("select * from " . $this->db->tbl_pre . "color_image_tbl where product_id='" . rep($_REQUEST['product_id']) . "' and color_id!='" . rep($_REQUEST['color_id']) . "' and color_image_id!='".$color_image_id."'");
		return $this->db->total($product_image_duplicate_check_sql);
	}

	// product_image Edit Function //
	public function product_image_edit($product_image_array, $color_image_id, $product_image_success_message, $product_image_unsuccess_message, $product_image_duplicate_message) {
		$file_up_count = 0;
		$product_image_duplicate_check_num = $this->product_image_check($color_image_id);
		if ($product_image_duplicate_check_num == 0) {
			$product_image_update = $this->db->update('product_image_tbl', $product_image_array, "color_image_id='" . $color_image_id . "'");

			// Upload Product Listing Image //
			if ($_FILES['listing_image']['size'] > 0) {
				$original = 'images/product_image/listing/';
				$listing_image_name = $_FILES['listing_image']['name'];
				$listing_image_tmp = $_FILES['listing_image']['tmp_name'];
				$listing_image_size = $_FILES['listing_image']['size'];
				$listing_image_type = $_FILES['listing_image']['type'];

				$listing_image_name_saved = str_replace("&", "and", $color_image_id . "_" . $listing_image_name);
				$listing_image_name_saved = str_replace(" ", "_", $color_image_id . "_" . $listing_image_name);
				$listing_image_img = '../' . $original . $listing_image_name_saved;
				move_uploaded_file($listing_image_tmp, $listing_image_img);
				//image upload
				$product_image_update = $this->db->update("product_image_tbl", array('listing_image' => ($listing_image_name_saved)), "color_image_id='" . $color_image_id . "'");
				$file_up_count++;
			}

			//Upload Additional Images //
			if($_SESSION['uploaded_product_image_image_files'][0] != ''){
			for ($i = 0; $i < count($_SESSION['uploaded_product_image_image_files']); $i++) {
				if ($_SESSION['uploaded_product_image_image_files'][$i]['metas'][0]['name'] != '') {
					$additional_image_array = array('color_image_id' => rep($color_image_id), 'product_image_additional_image' => rep($_SESSION['uploaded_product_image_image_files'][$i]['metas'][0]['name']));
					$this->db->insert('product_image_additional_image_tbl', $additional_image_array);
					$file_up_count++;
				}
			}
			$_SESSION['uploaded_product_image_image_files'] = '';
		}

			if ($product_image_update['affectedRow'] > 0) {
				$file_up_count++;
			} 

			if($file_up_count != 0 ){
				// Success Message For Update a Existing product_image //
				$_SESSION['product_image_msg'] = messagedisplay($product_image_success_message, 1);
				header('location:' . $_SESSION['product_image_manage_url']);
				exit();
			}else {
				// Message For Nothing Update //
				$_SESSION['product_image_msg'] = messagedisplay($product_image_unsuccess_message, 3);
				header('location:' . $_SESSION['product_image_manage_url']);
				exit();
			}
		} else {
			$_SESSION['product_image_msg'] = messagedisplay($product_image_duplicate_message, 2);
			header('location:' . $_SESSION['product_image_manage_url']);
			exit();
		}
	}

	// product_image Display Function //
	public function product_image_display($sTable = '', $aColumns = '', $sWhere = '', $sLimit = '', $sOrder = '') {
		$product_image_query = array('tbl_name' => $sTable, 'field' => $aColumns, 'condition' => $sWhere, 'limit' => $sLimit, 'orderby' => $sOrder);
		$product_image_sql = $this->db->select($product_image_query);
		$product_image_array = $this->db->result($product_image_sql);
		return $product_image_array;
	}

	// product_image Status Update Function //
	public function product_image_status_update($product_image_page_url) {
		$color_image_id = $_REQUEST['cid'];
		if ($_REQUEST['current_status'] == 'Inactive') {
			$product_image_status = 'Active';
		} else {
			$product_image_status = 'Inactive';
		}
		$this->db->update('product_image_tbl', array('product_image_status' => ($product_image_status)), "color_image_id='" . $color_image_id . "'");
		$_SESSION['product_image_msg'] = messagedisplay('product_image\'s Status is updated successfully', 1);
		header('location: ' . $product_image_page_url);
		exit();
	}

	// product_image Delete Function //
	public function product_image_delete($product_image_page_url) {
		$color_image_id = $_REQUEST['cid'];
		$owner_arr = $this->product_image_display($this->db->tbl_pre. "product_image_tbl",array(),"WHERE color_image_id=" . $color_image_id);
		$this->product_image_owner->product_image_owner_car_status_update($owner_arr[0]['product_image_owner_id'],'Absent');
		$product_image_delete = $this->db->delete("product_image_tbl", array('color_image_id' => $color_image_id));
		if ($product_image_delete['affectedRow'] > 0) {
			$_SESSION['product_image_msg'] = messagedisplay('product_image details deleted successfully', 1);
		} else {
			$_SESSION['product_image_msg'] = messagedisplay('Nothing is deleted successfully', 2);
		}
		header('location: ' . $product_image_page_url);
		exit();
	}

	// product_image Remove file //
	public function remove_file($product_image_additional_image_id) {
		$product_image_additional_delete = $this->db->delete("product_image_additional_image_tbl", array('product_image_additional_image_id' => $product_image_additional_image_id));
		if ($product_image_additional_delete['affectedRow'] > 0) {
			$response = array("error"=>false,"msg"=>"Additional image deleted");
		} else {
			$response = array("error"=>true,"msg"=>"Nothing is deleted successfully");
		}
		return $response;
	}

	// product_image Add Function From POPUP //
	public function product_image_add_from_popup($product_image_array, $product_image_additional_array, $product_image_success_message, $product_image_unsuccess_message, $product_image_duplicate_message) {
		 $product_image_duplicate_check_num = $this->product_image_check($color_image_id);
		 if ($product_image_duplicate_check_num == 0) {
			$product_image_add = $this->db->insert('product_image_tbl', $product_image_array);
			if ($product_image_add['affectedRow'] > 0) {
				$color_image_id = $product_image_add['insertedId'];
				 $this->db->update("product_image_tbl", $product_image_additional_array, "color_image_id='" . $color_image_id . "'");
				 
				
				$response = array("error"=>false,"color_image_id"=>$color_image_id,"product_image_msg"=>$product_image_success_message);
			} else {
				// Message For Nothing Insert //
				$response = array("error"=>true,"product_image_msg"=>$product_image_unsuccess_message);
			}
		 } else {
		 	$response = array("error"=>true,"product_image_msg"=>$product_image_duplicate_message);
		 }

		 return $response;
	}

	// product_image booking status update //
	public function product_image_booking_status_update($color_image_id,$product_image_booking_status){
		
		$this->db->update('product_image_tbl', array('product_image_booking_status' => ($product_image_booking_status)), "color_image_id='" . $color_image_id . "'");

	}
}
?>