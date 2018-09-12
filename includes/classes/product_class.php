<?php
class babygo_product {
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
	// product Add Function //
	public function Product_add($product_array, $product_success_message, $product_unsuccess_message, $product_duplicate_message) {
		$product_check = $this->product_check($product_id);
		if ($product_check == 0) {
			$product_add = $this->db->insert('product_tbl', $product_array);
			if ($product_add['affectedRow'] > 0) {
				$product_id = $product_add['insertedId'];

					$size_id = $_REQUEST['size_id'];
					$style_set_qty = $_REQUEST['style_set_qty'];
					$style_mrp_for_size = $_REQUEST['style_mrp_for_size'];

					$detalis_value = array('product_id' => rep($product_id), 'style_set_qty' => rep($style_set_qty), 'style_mrp_for_size' => rep($style_mrp_for_size),'size_id' => rep($size_id) );	 
					 $this->db->insert('product_details_tbl', $detalis_value);

 
				if ($_FILES['style_list_image']['size'] > 0) {
						$original = 'images/product_list/';
						$banner_title = $_FILES['style_list_image']['name'];
						$banner_tmp = $_FILES['style_list_image']['tmp_name'];
						$banner_size = $_FILES['style_list_image']['size'];
						$banner_type = $_FILES['style_list_image']['type'];

						$banner_title_saved = str_replace("&", "and", $product_id . "_" . $banner_title);
						$banner_title_saved = str_replace(" ", "_", $product_id . "_" . $banner_title);
						$banner_img = $original . $banner_title_saved;
					//original path
						$banner_img1 = "../" . $banner_img;
						move_uploaded_file($banner_tmp, $banner_img1);
					//image upload
		$this->db->update("product_tbl", array('style_list_image' =>$banner_title_saved),"product_id='" . $product_id . "'");
				}

				 for ($i = 0; $i < count($_FILES['style_color_image']['name']); $i++) {
					$original = 'images/product_list/set_images/';
					$style_color_image_name = $_FILES['style_color_image']['name'][$i];
					$style_color_image_tmp = $_FILES['style_color_image']['tmp_name'][$i];
					$style_color_image_size = $_FILES['style_color_image']['size'][$i];
					$style_color_image_type = $_FILES['style_color_image']['type'][$i];

					$style_color_name_saved = str_replace("&", "and", $product_id . "_" . $style_color_image_name);
					$style_color_name_saved = str_replace(" ", "_", $product_id . "_" . $style_color_image_name);
					$listing_image_img = '../' . $original . $style_color_name_saved;
					move_uploaded_file($style_color_image_tmp, $listing_image_img);
 $this->db->insert("product_images_tbl", array('product_id' => $product_id ,'style_color_image'=>$style_color_name_saved) );
				}

				 for ($i = 0; $i < count($_FILES['listing_image']['name']); $i++) {
					$original = 'images/product_list/other_color/';
					$style_color_image_name = $_FILES['listing_image']['name'][$i];
					$style_color_image_tmp = $_FILES['listing_image']['tmp_name'][$i];
					$style_color_image_size = $_FILES['listing_image']['size'][$i];
					$style_color_image_type = $_FILES['listing_image']['type'][$i];

					$listing_image_name_saved = str_replace("&", "and", $product_id . "_" . $style_color_image_name);
					$listing_image_name_saved = str_replace(" ", "_", $product_id . "_" . $style_color_image_name);
					$listing_image_img = '../' . $original . $listing_image_name_saved;
					move_uploaded_file($style_color_image_tmp, $listing_image_img);
 $this->db->insert("color_image_tbl", array('product_id' => $product_id ,'listing_image'=>$listing_image_name_saved) );
				}
goods_movement_summary();

				// Success Message For Insert a New product_type_style //
				$_SESSION['product_msg'] = messagedisplay($product_success_message, 1);
				header('location: add_product.php');
				exit();
			} else {
				// Message For Nothing Insert //
				$_SESSION['product_msg'] = messagedisplay($product_unsuccess_message, 3);
			}
		} else {
			$_SESSION['product_msg'] = messagedisplay($product_duplicate_message, 2);
		}
	}
	// product Duplicate Check Function //
	public function product_check($product_id = '') {
		// Check Duplicate product Name //
 $product_duplicate_check_sql = $this->db->query("select * from " . $this->db->tbl_pre . "product_tbl where style_no='" . rep($_REQUEST['style_no']) . "' and product_id!='" . $product_id . "'");
		return $this->db->total($product_duplicate_check_sql);
	}
	// product Edit Function //
	public function product_edit($product_array, $product_id, $product_success_message, $product_unsuccess_message, $product_duplicate_message) {
		$product_duplicate_check_num = $this->product_check($product_id);
		$file_up_count = 0;
		if ($product_duplicate_check_num == 0) {
			$product_update = $this->db->update('product_tbl', $product_array, "product_id='" . $product_id . "'");
 if ($product_update) {
 $details=	$this->product_display($this->db->tbl_pre . "product_details_tbl", array(), "WHERE product_id=" . $product_id . "");
 	$product_details_id=$details[0]['product_details_id'];
//$this->db->delete("product_details_tbl", array("product_id" => $product_id));
			$size_id = $_REQUEST['size_id'];
			$style_set_qty = $_REQUEST['style_set_qty'];
			$style_mrp_for_size = $_REQUEST['style_mrp_for_size'];

			$detalis_value = array('product_id' => rep($product_id), 'style_set_qty' => rep($style_set_qty), 'style_mrp_for_size' => rep($style_mrp_for_size),'size_id' => rep($size_id) );	 
			$this->db->update('product_details_tbl', $detalis_value, "product_details_id='" . $product_details_id . "'");
			 //$this->db->insert('product_details_tbl', $detalis_value);


 	$file_up_count++;
 	goods_movement_summary();
 }
			
				// Success Message For Update a Existing product //

if ($_FILES['style_list_image']['size'] > 0) {
						$original = 'images/product_list/';
						$banner_title = $_FILES['style_list_image']['name'];
						$banner_tmp = $_FILES['style_list_image']['tmp_name'];
						$banner_size = $_FILES['style_list_image']['size'];
						$banner_type = $_FILES['style_list_image']['type'];

						$banner_title_saved = str_replace("&", "and", $product_id . "_" . $banner_title);
						$banner_title_saved = str_replace(" ", "_", $product_id . "_" . $banner_title);
						$banner_img = $original . $banner_title_saved;
					//original path
						$banner_img1 = "../" . $banner_img;
						move_uploaded_file($banner_tmp, $banner_img1);
					//image upload
		$this->db->update("product_tbl", array('style_list_image' =>$banner_title_saved),"product_id='" . $product_id . "'");
		$file_up_count++;
				}

				 for ($i = 0; $i < count($_FILES['style_color_image']['name']); $i++) {
				 	if ($_FILES['style_color_image']['size'][$i] > 0) {
					$original = 'images/product_list/set_images/';
					$style_color_image_name = $_FILES['style_color_image']['name'][$i];
					$style_color_image_tmp = $_FILES['style_color_image']['tmp_name'][$i];
					$style_color_image_size = $_FILES['style_color_image']['size'][$i];
					$style_color_image_type = $_FILES['style_color_image']['type'][$i];

					$style_color_name_saved = str_replace("&", "and", $product_id . "_" . $style_color_image_name);
					$style_color_name_saved = str_replace(" ", "_", $product_id . "_" . $style_color_image_name);
					$listing_image_img = '../' . $original . $style_color_name_saved;
					move_uploaded_file($style_color_image_tmp, $listing_image_img);
 $this->db->insert("product_images_tbl", array('product_id' => $product_id ,'style_color_image'=>$style_color_name_saved) );
 $file_up_count++;
				}
}

				 for ($i = 0; $i < count($_FILES['listing_image']['name']); $i++) {
				 	if ($_FILES['listing_image']['size'][$i] > 0) {
					$original = 'images/product_list/other_color/';
					$style_color_image_name = $_FILES['listing_image']['name'][$i];
					$style_color_image_tmp = $_FILES['listing_image']['tmp_name'][$i];
					$style_color_image_size = $_FILES['listing_image']['size'][$i];
					$style_color_image_type = $_FILES['listing_image']['type'][$i];

					$listing_image_name_saved = str_replace("&", "and", $product_id . "_" . $style_color_image_name);
					$listing_image_name_saved = str_replace(" ", "_", $product_id . "_" . $style_color_image_name);
					$listing_image_img = '../' . $original . $listing_image_name_saved;
					move_uploaded_file($style_color_image_tmp, $listing_image_img);
 $this->db->insert("color_image_tbl", array('product_id' => $product_id ,'listing_image'=>$listing_image_name_saved) );
 $file_up_count++;
				}
}


if($file_up_count != 0 ){
				$_SESSION['product_msg'] = messagedisplay($product_success_message, 1);
				header('location:' . $_SESSION['product_manage_url']);
				exit();
			} else {
				// Message For Nothing Update //
				$_SESSION['product_msg'] = messagedisplay($product_unsuccess_message, 3);
				header('location:' . $_SESSION['product_manage_url']);
				exit();
			}
		} else {
			$_SESSION['product_msg'] = messagedisplay($product_duplicate_message, 2);
			header('location:' . $_SESSION['product_manage_url']);
			exit();
		}
	}
	// product Display Function //
	public function product_display($sTable = '', $aColumns = '', $sWhere = '', $sLimit = '', $sOrder = '') {
		$product_query = array('tbl_name' => $sTable, 'field' => $aColumns, 'condition' => $sWhere, 'limit' => $sLimit, 'orderby' => $sOrder);
		$product_sql = $this->db->select($product_query);
		$product_array = $this->db->result($product_sql);
		return $product_array;
	}
	// product Status Update Function //
	public function product_status_update($product_page_url) {
		$product_id = $_REQUEST['cid'];
		if ($_REQUEST['current_status'] == 'Inactive') {
			$product_status = 'Active';
		} else {
			$product_status = 'Inactive';
		}
		$this->db->update('product_tbl', array('product_status' => ($product_status)), "product_id='" . $product_id . "'");
		$_SESSION['product_msg'] = messagedisplay('product\'s Status is updated successfully', 1);
		header('location: ' . $product_page_url);
		exit();
	}
	// product Delete Function //
	public function product_delete($product_page_url) {
		$product_id = $_REQUEST['cid'];
		$product_delete = $this->db->delete("product_tbl", array("product_id" => $product_id));
		 
		if ($product_delete['affectedRow'] > 0) {
			$_SESSION['product_msg'] = messagedisplay('product details deleted successfully', 1);
		} else {
			$_SESSION['product_msg'] = messagedisplay('Nothing is deleted successfully', 2);
		}
		header('location: ' . $product_page_url);
		exit();
	}



	public function remove_file($image_id) {
		$vehicle_additional_delete = $this->db->delete("product_images_tbl", array('image_id' => $image_id));
		if ($vehicle_additional_delete['affectedRow'] > 0) {
			$response = array("error"=>false,"msg"=>"Additional image deleted");
		} else {
			$response = array("error"=>true,"msg"=>"Nothing is deleted successfully");
		}
		return $response;
	}

	public function remove_color_file($color_image_id) {
		$vehicle_additional_delete = $this->db->delete("color_image_tbl", array('color_image_id' => $color_image_id));
		if ($vehicle_additional_delete['affectedRow'] > 0) {
			$response = array("error"=>false,"msg"=>"Additional image deleted");
		} else {
			$response = array("error"=>true,"msg"=>"Nothing is deleted successfully");
		}
		return $response;
	}


}




?>