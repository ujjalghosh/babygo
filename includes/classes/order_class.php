<?php
class babygo_product_order {
	public $recperpage;
	public $url;
	public $db;
		public $mailsend;
	public function __construct() {
		global $recperpage;
		global $url;
		global $db;
				global $mailsend;
		$this->recperpage = $recperpage;
		$this->url = $url;
		$this->db = $db;
		$this->mailsend = $mailsend;
	}
	// order Add Function //
	public function order_add($order_array, $order_success_message, $order_unsuccess_message, $order_duplicate_message) {
		$order_check = $this->order_check($order_id);
		if ($order_check == 0) {
			$order_add = $this->db->insert('order_tbl', $order_array);
			if ($order_add['affectedRow'] > 0) {
				$order_id = $order_add['insertedId'];


				// Success Message For Insert a New order_type_style //
				$_SESSION['order_msg'] = messagedisplay($order_success_message, 1);
				header('location: add_order.php');
				exit();
			} else {
				// Message For Nothing Insert //
				$_SESSION['order_msg'] = messagedisplay($order_unsuccess_message, 3);
			}
		} else {
			$_SESSION['order_msg'] = messagedisplay($order_duplicate_message, 2);
		}
	}
	// order Duplicate Check Function //
	public function order_check($order_id = '') {
		// Check Duplicate order Name //
		$order_duplicate_check_sql = $this->db->query("select * from " . $this->db->tbl_pre . "order_master where generate_no='" . rep($_REQUEST['generate_no']) . "' and order_id!='" . $order_id . "'");
		return $this->db->total($order_duplicate_check_sql);
	}
	// order Edit Function //
	public function order_edit($order_array, $order_id, $order_success_message, $order_unsuccess_message, $order_duplicate_message) {
		$order_duplicate_check_num = $this->order_check($order_id);
		if ($order_duplicate_check_num == 0) {
			$order_update = $this->db->update('order_master', $order_array, "order_id='" . $order_id . "'");
 
			if ($order_update['affectedRow'] > 0) {
				// Success Message For Update a Existing order //
			$order_update_array =  $this->order_display($this->db->tbl_pre . "orders_tbl", array(), "WHERE generate_no='" . $_REQUEST['generate_no'] . "' and customer_id='".$_REQUEST['customer_id']."'");
	 
 			for ($ou=0; $ou <count($order_update_array) ; $ou++) { 

 			$pddetails=$this->order_display($this->db->tbl_pre . "product_details_tbl pdt, " . $this->db->tbl_pre . "product_size_tbl sz ", array(), "WHERE pdt.product_id ='".$order_update_array[$ou]["product_id"]."' and pdt.product_details_id='".$order_update_array[$ou]["product_details_id"]."' and sz.product_size_id=pdt.size_id " );
				//stock_in_hand = stock_in_hand +
			$this->db->update('product_details_tbl', array('stock_in_hand'=>$pddetails[0]["stock_in_hand"] + $order_update_array[$ou]["total_set"]), "product_details_id='" . $order_update_array[$ou]["product_details_id"] . "'");

			}



			$orders_delete = $this->db->delete("orders_tbl", array("generate_no" => $_REQUEST['generate_no'],'customer_id' => $_REQUEST['customer_id']));

				    if (isset($_POST['order_num']))
				    {
				for ($or = 0; $or < $_REQUEST['order_num']; $or++) {
					if(isset($_REQUEST['num_product_id'.$or])){
					for ($p=0; $p <$_REQUEST['num_product_id'.$or] ; $p++) { 						
					$product_id=$_REQUEST['product_id'.$or.'_'.$p];
					$product_details_id=$_REQUEST['product_details_id_'.$or.'_'.$p];
					$total_set=$_REQUEST['set_'.$or.'_'.$p];
					$piece=$_REQUEST['piece_'.$or.'_'.$p];
					$mrp=$_REQUEST['mrp_'.$or.'_'.$p];
					$amount=$_REQUEST['amount_'.$or.'_'.$p];

		if ($total_set>0) {

			$name_value = array('product_id' => rep($product_id), 'customer_id' => $_REQUEST['customer_id'], 'generate_no' => $_REQUEST['generate_no'], 'product_details_id' => rep($product_details_id), 'total_set' => $total_set,'piece'=>$piece,'mrp'=>$mrp,'amount'=>$amount);

			$order_add = $this->db->insert('orders_tbl', $name_value);


 			$pddetails=$this->order_display($this->db->tbl_pre . "product_details_tbl pdt, " . $this->db->tbl_pre . "product_size_tbl sz ", array(), "WHERE pdt.product_id ='".$product_id."' and pdt.product_details_id='".$product_details_id."' and sz.product_size_id=pdt.size_id " );
				//stock_in_hand = stock_in_hand +
			$this->db->update('product_details_tbl', array('stock_in_hand'=>$pddetails[0]["stock_in_hand"] - $total_set), "product_details_id='" . $product_details_id . "'");


			}
				} 
			}
				}
			}

$this->send_order_Mail($_REQUEST['generate_no']);

				$_SESSION['order_msg'] = messagedisplay($order_success_message, 1);
				header('location: manage_order.php');
				exit();
			} else {
				// Message For Nothing Update //
				$_SESSION['order_msg'] = messagedisplay($order_unsuccess_message, 3);
				header('location: manage_order.php');
				exit();
			}
		} else {
			$_SESSION['order_msg'] = messagedisplay($order_duplicate_message, 2);
			header('location: manage_order.php');
			exit();
		}
	}
	// order Display Function //
	public function order_display($sTable = '', $aColumns = '', $sWhere = '', $sLimit = '', $sOrder = '') {
		$order_query = array('tbl_name' => $sTable, 'field' => $aColumns, 'condition' => $sWhere, 'limit' => $sLimit, 'orderby' => $sOrder);
		$order_sql = $this->db->select($order_query);
		$order_array = $this->db->result($order_sql);
		return $order_array;
	}
	// order Status Update Function //
	public function order_status_update($order_page_url) {
		$order_id = $_REQUEST['cid'];
		if ($_REQUEST['current_status'] == 'Inactive') {
			$order_status = 'Active';
		} else {
			$order_status = 'Inactive';
		}
		$this->db->update('order_tbl', array('order_status' => ($order_status)), "order_id='" . $order_id . "'");
		$_SESSION['order_msg'] = messagedisplay('order\'s Status is updated successfully', 1);
		header('location: ' . $order_page_url);
		exit();
	}
	// order Delete Function //
	public function order_delete($order_page_url) {
		$order_id = $_REQUEST['cid'];
		$order_array =  $this->order_display($this->db->tbl_pre . "order_master", array(), "WHERE order_id='" . $order_id . "' ");		
		$order_delete = $this->db->delete("orders_tbl", array("generate_no" => $order_array[0]["generate_no"]));
		 $order_delete = $this->db->delete("order_master", array("order_id" => $order_id));
		if ($order_delete['affectedRow'] > 0) {
			$_SESSION['order_msg'] = messagedisplay('order details deleted successfully', 1);
		} else {
			$_SESSION['order_msg'] = messagedisplay('Nothing is deleted successfully', 2);
		}
		header('location: ' . $order_page_url);
		exit();
	}
	
	public function send_order_Mail($generate_no){

$to= Admin_Receiving_Email_ID;
 
  $order_array = $this->order_display($this->db->tbl_pre . "order_master ortm, " . $this->db->tbl_pre . "orders_tbl ort, " . $this->db->tbl_pre . "customer_tbl lt, " . $this->db->tbl_pre . "product_details_tbl pdt, " . $this->db->tbl_pre . "product_size_tbl pst, " . $this->db->tbl_pre . "product_tbl pt ", array(), "WHERE ort.customer_id=lt.customer_id and ort.product_id=pt.product_id and ort.product_details_id=pdt.product_details_id and pdt.size_id=pst.product_size_id and ort.product_id=pt.product_id  and ort.generate_no='".$generate_no."' and ortm.generate_no='".$generate_no."'");
  
  $order_mstr = $this->order_display($this->db->tbl_pre . "order_master ", array(), "WHERE generate_no='".$generate_no."'");
  $shipping_address=strlen($order_mstr[0]["shipping_address"]);
 if( $shipping_address> 10){$address = $order_mstr[0]["shipping_address"]; } else {$address = $order_mstr[0]["billing_address"]; } 

$subject = "Dear Admin Update Order Placed";
$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title></title>
    </head>
    <body>
        <p style="text-align:center;font-size:13px;margin-bottom: 4px;font-weight: bold;">SALES ORDER</p>
        <table width="600" cellpadding="1" cellspacing="0" style="margin:0 auto;border:1px solid #000;border-collapse: collapse;">
          <tr>
            <th colspan="8" align="center" style="font-size:13px;text-transform:uppercase;font-weight: 400;">IRIS CLOTHINGS PRIVATE LIMITED</th>
          </tr>
          <tr style="font-size:14px">            
            <td colspan="4">
                103/24/1, Foreshore Road<br/>Binani Metal Compound<br/>Howrah - 711102<br/>West Bengal<br/>Phone No. : +91 33 2637 3856/81000 74062<br/>CIN : U18109WB2011PTC166895<br/>GSTIN No.: 19AACCI6963K1Z0<br/><br/>PAN : AACCI6963K
            </td>
            <td colspan="4">
                <img src="'.Site_URL.'images/logo_order.png" width="135" alt="logo" />
            </td>
          </tr>
          <tr>
              <td colspan="4" height="10"></td>
          </tr>
          <tr style="font-size:14px;border-top: 1px solid #000;">
            <td valign="top">To</td>
            <td colspan="3" valign="top">
                <br/>'.$order_array[0]["Company_name"].'<br/>'.$address.'<br/>GSTIN No.:'.$order_array[0]["vat_no"].'<br/>PAN :'.$order_array[0]["pan_no"].'

            </td>
            <td colspan="4" valign="top" style="border-left: 1px solid #000;">
                <br/><span style="width:68px;">Order No. :</span> '.$order_array[0]["generate_no"].'<br/><span style="width:68px;">Date :</span> '.date('F d, Y',strtotime($order_array[0]["order_Date"])).'<br/><span style="width:68px;">Transport :</span> '.$order_array[0]["preferred_courier_service"].'
            </td>
          </tr>
          <tr style="border-bottom: 1px solid #000;">
              <td colspan="4" height="10"></td>
              <td colspan="4" height="10" style="border-left: 1px solid #000;"></td>
          </tr>
          <tr style="font-size:14px;border-bottom: 1px solid #000;">
            <td align="left">SL</td>
            <td align="left" width="220"  style="border-left: 1px solid #000;">Description of Goods</td>
            <td align="left"  style="border-left: 1px solid #000;">Style No.</td>
            <td align="left"  style="border-left: 1px solid #000;">Size</td>
            <td align="left"  style="border-left: 1px solid #000;">Colour</td>
            <td align="left"  style="border-left: 1px solid #000;">Sets</td>
            <td align="left"  style="border-left: 1px solid #000;">Pcs</td>
            <td align="left" width="65"  style="border-left: 1px solid #000;">Amount</td>
          </tr>';
  $i=0;$set=0;$piece=0;
for ($li=0; $li <count($order_array) ; $li++) { 
  
$i=$i+1;
 $amount = $order_array[$li]["amount"];
setlocale(LC_MONETARY, 'en_IN');
$amount = money_format('%!i', $amount);
  $amount;

                  $message .='<tr style="font-size:14px;border-bottom: 1px solid #000;">
            <td align="center">'.$i.'</td>
            <td align="left" style="border-left: 1px solid #000;">'.$order_array[$li]["product_name"].'</td>
            <td align="left" style="border-left: 1px solid #000;">'.$order_array[$li]["style_no"].'</td>
            <td align="center" style="border-left: 1px solid #000;">'.$order_array[$li]["size_description"].'</td>
            <td align="center" style="border-left: 1px solid #000;">'.$order_array[$li]["style_color_qty"].'</td>
            <td align="center" style="border-left: 1px solid #000;">'.$order_array[$li]["total_set"].'</td>
            <td align="center" style="border-left: 1px solid #000;">'.$order_array[$li]["piece"].'</td>
            <td align="right" style="border-left: 1px solid #000;">'.$amount.'</td>
          </tr>';
                $set=$set+$order_array[$li]["total_set"];
                $piece=$piece+$order_array[$li]["piece"];
                     }
 $tamount = $order_array[0]["total_bill_amount"];
setlocale(LC_MONETARY, 'en_IN');
$tamount = money_format('%!i', $tamount);
  $tamount;

 
        for ($tr=$li; $tr <22 ; $tr++) { 
    $message .= '<tr style="border-bottom: 1px solid #000;">
            <td>&nbsp;</td>
            <td style="border-left: 1px solid #000;">&nbsp;</td>
            <td style="border-left: 1px solid #000;">&nbsp;</td>
            <td style="border-left: 1px solid #000;">&nbsp;</td>
            <td style="border-left: 1px solid #000;">&nbsp;</td>
            <td style="border-left: 1px solid #000;">&nbsp;</td>
            <td style="border-left: 1px solid #000;">&nbsp;</td>
            <td style="border-left: 1px solid #000;">&nbsp;</td>
          </tr>';
}

$message.='<tr style="border-bottom: 1px solid #000;">
            <td colspan="5" align="right">Total</td>
            <td align="center" style="border-left: 1px solid #000;">'.$set.'</td>
            <td align="center" style="border-left: 1px solid #000;">'.$piece.'</td>
            <td align="right" style="border-left: 1px solid #000;"> &#x20b9; '.$tamount.'</td>
          </tr>
          <tr>
              <td colspan="4" height="10"></td>
          </tr>
          <tr>
            <td colspan="8" style="font-size:13px;">
                Terms :<br/>1) Defects/Shotages if any should be reported within three days from the receipt of goods.<br/>2) Interest @18 % will be charged after due date.<br/>3) All Subject to Howrah Jurisdiction.<br/>4) Our Banker : Axis Bank Ltd, Corporate Banking Branch, A/c. 916030037170546, IFSC: UTIB0001164.<br/>5) This is a computer generated copy hence signature is not required.
            </td>
          </tr>
        </table>
    </body>
</html>';
// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
// More headers
$headers .= 'From:'.Site_Title.' <'.Admin_Sending_Email_ID.'>' . "\r\n";
//$headers .= 'Cc: '.Admin_Receiving_Email_ID.'' . "\r\n";
 
mail($to,$subject,$message,$headers);

 

$to_user= $order_array[0]["customer_email"]; 
$subject_user = "Your Update Order Details ";
$headers_user = "MIME-Version: 1.0" . "\r\n";
$headers_user .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers_user .= 'From:'.Site_Title.' <'.Admin_Sending_Email_ID.'>' . "\r\n";

mail($to_user,$subject_user,$message,$headers_user);
	}

}

?>