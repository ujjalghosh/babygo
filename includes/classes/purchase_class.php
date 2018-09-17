<?php
class babygo_product_purchase {
	public $recperpage;
	public $url;
	public $db;
	public $DB1;
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
	// purchase Add Function //
	public function purchase_add($purchase_array, $purchase_success_message, $purchase_unsuccess_message, $purchase_duplicate_message) {
		$purchase_duplicate_check_num = $this->purchase_check($bill_id);
		if ($purchase_duplicate_check_num == 0) {
    
			$purchase_add = $this->db->insert('purchase_bill_master', $purchase_array);

			if ($purchase_add['affectedRow'] > 0) {
				$bill_id = $purchase_add['insertedId'];
 

				    if (isset($_POST['item']))
    {

for ($pr = 1; $pr < $_REQUEST['item']; $pr++) {
 
$product_id    = $_REQUEST['product_id'. $pr];
$qty           = $_REQUEST['qty'. $pr];
$rate          = $_REQUEST['rate'. $pr];
$total       = $_REQUEST['total'. $pr];
 
 
 

if ($product_id!='' && $qty!='') {
$purchase_array_trns=array(  'bill_id' => rep($bill_id),  'product_id' => rep($product_id),'qty' => "".rep($qty)."",'rate' => "".rep($rate)."",'total' => rep($total)  );

$date_of_transaction = date('Y-m-d',strtotime($_POST['bill_date']));
$goods_movement_array = array('product_id' => rep($product_id), 'date_of_transaction' => "".rep($date_of_transaction)."",'qty_in' => rep($qty),'reference_id' => rep($bill_id),'reference_type' => 'purchase','value_in'=> "".rep($total).""  );
 
 $this->db->insert('purchase_bill_transaction', $purchase_array_trns);
 
 
 $goods_movement_add=$this->db->insert('goods_movement_register', $goods_movement_array); 
 
}

}
 

  }
 
  goods_movement_summary();
 				 
		// Success Message For Insert a New purchase //
				$_SESSION['purchase_msg'] = messagedisplay($purchase_success_message, 1);
				//$print = $this->billprint($bill_id);
				header('location: add_product_stock.php');
				exit();
			} else {
				// Message For Nothing Insert //
				$_SESSION['purchase_msg'] = messagedisplay($purchase_unsuccess_message, 3);
			}
		} else {
			$_SESSION['purchase_msg'] = messagedisplay($purchase_duplicate_message, 2);
		}
	}
	// purchase Duplicate Check Function //
	public function purchase_check($bill_id = '') {
		// Check Duplicate purchase Name //
		$purchase_duplicate_check_sql = $this->db->query("select * from " . $this->db->tbl_pre . "purchase_bill_master where bill_no='" . rep($_REQUEST['bill_no']) . "' and bill_id!='" . $bill_id . "'");
		return $this->db->total($purchase_duplicate_check_sql);
	}
	// purchase Edit Function //
	public function purchase_edit($purchase_array, $bill_id, $purchase_success_message, $purchase_unsuccess_message, $purchase_duplicate_message) {
		$purchase_duplicate_check_num = $this->purchase_check($bill_id);
		if ($purchase_duplicate_check_num == 0) {
			$purchase_update 		= $this->db->update('purchase_bill_master', $purchase_array, "bill_id='" . $bill_id . "'");
 			$purchase_trns_delete 	= $this->db->delete('purchase_bill_transaction', array("bill_id" => $bill_id));
 			$purchase_goods_delete 	= $this->db->delete('goods_movement_register', array("reference_id" => $bill_id,'reference_type' => 'purchase')); 
 

				    if (isset($_POST['item']))
    {

for ($pr = 1; $pr < $_REQUEST['item']; $pr++) { 
$product_id    = $_REQUEST['product_id'. $pr];
$qty           = $_REQUEST['qty'. $pr];
$rate          = $_REQUEST['rate'. $pr];
$total       = $_REQUEST['total'. $pr];  

if ($product_id!='' && $qty!='') {
$purchase_array_trns=array(  'bill_id' => rep($bill_id),  'product_id' => rep($product_id),'qty' => "".rep($qty)."",'rate' => "".rep($rate)."",'total' => rep($total)  );

$date_of_transaction = date('Y-m-d',strtotime($_POST['bill_date']));
$goods_movement_array = array('product_id' => rep($product_id), 'date_of_transaction' => "".rep($date_of_transaction)."",'qty_in' => rep($qty),'reference_id' => rep($bill_id),'reference_type' => 'purchase','value_in'=> "".rep($total).""  );
 
 $purchase_update = $this->db->insert('purchase_bill_transaction', $purchase_array_trns); 
 $goods_movement_add = $this->db->insert('goods_movement_register', $goods_movement_array); 
 
}
}
  }

			if ($purchase_update['affectedRow'] > 0) {
				 goods_movement_summary();
				// Success Message For Update a Existing purchase //
				$_SESSION['purchase_msg'] = messagedisplay($purchase_success_message, 1); 
				header('location: manage_product_stock.php'); 
			 
				exit();
			} else {
				// Message For Nothing Update //
				$_SESSION['purchase_msg'] = messagedisplay($purchase_unsuccess_message, 3); 
				header('location: manage_product_stock.php'); 
				exit();
			}
		} else {
			$_SESSION['purchase_msg'] = messagedisplay($purchase_duplicate_message, 2); 
				header('location: add_product_stock.php'); 
			exit();
		}
	}
	// purchase Display Function //
	public function purchase_display($sTable = '', $aColumns = '', $sWhere = '', $sLimit = '', $sOrder = '') {
		$purchase_query = array('tbl_name' => $sTable, 'field' => $aColumns, 'condition' => $sWhere, 'limit' => $sLimit, 'orderby' => $sOrder);
		$purchase_sql = $this->db->select($purchase_query);
		$purchase_array = $this->db->result($purchase_sql);
		return $purchase_array;
	}
	// purchase Status Update Function //
	public function purchase_status_update($purchase_page_url) {
		$bill_id = $_REQUEST['cid'];
		if ($_REQUEST['current_status'] == 'Inactive') {
			$purchase_status = 'Active';
		} else {
			$purchase_status = 'Inactive';
		}
		$this->db->update(''.$_SESSION['userid'].'_purchase_bill_master', array('purchase_status' => ($purchase_status)), "bill_id='" . $bill_id . "'");
		$_SESSION['purchase_msg'] = messagedisplay('purchase\'s Status is updated successfully', 1);

		header('location: ' . $purchase_page_url);
		exit();
	}

	// purchase Delete Function //
	public function purchase_delete($purchase_page_url) {
	$bill_id = $_REQUEST['cid'];
	$purchase_delete = $this->db->delete('purchase_bill_master', array("bill_id" => $bill_id));
	$purchase_delete = $this->db->delete('purchase_bill_transaction', array("bill_id" => $bill_id));
 
 	$goods_movement_register = $this->db->delete('goods_movement_register', array("reference_id" => $bill_id,'reference_type' => 'purchase'));
 
		goods_movement_summary();
		if ($purchase_delete['affectedRow'] > 0) {
			$_SESSION['purchase_msg'] = messagedisplay('Product stock details deleted successfully', 1);
		} else {
			$_SESSION['purchase_msg'] = messagedisplay('Nothing is deleted successfully', 2);
		}
		header('location: ' . $purchase_page_url);
		exit();
	}




}
?>