<?php
include('common_connect.php'); // json response array
$response = array("status" => TRUE);
$response["stock"] = array();
if (isset($_POST['place_order']))  {
 
$aa= json_decode($_POST['place_order'], true);

if (!empty($aa)) {
  $orderchk_query = $db->query("select generate_no from " . $db->tbl_pre . "order_master   order by  `order_id` DESC limit 0,1 ", PDO::FETCH_BOTH);

$order_num = $db->total($orderchk_query);
  if (date('m') <= 4) {//Upto June 2014-2015
     $financial_year = (date('y')-1) . '-' . date('y');
} else {//After June 2015-2016
     $financial_year = date('y') . '-' . (date('y') + 1);
}
    if ($order_num != 0) {

$orderchk_array = $db->result($orderchk_query);
$lcod= $orderchk_array[0]['generate_no']; 
   $nres=substr("$lcod",0,7);
  $gtnum=substr("$lcod", 7);
     $num =substr("$gtnum", 0, -5);  
   $num=$num+1;
   //$generate_no = $nres.str_pad($num, 1, "0", STR_PAD_LEFT)."/".$financial_year;
   $generate_no = $nres."00".$num."/".$financial_year;
    }else{
      //ICPL/O/001/17-18
   $generate_no="ICPL/O/"."001"."/".$financial_year; 
} 

}
$total_bill_amount = $aa["total_bill_amount"];
$billing_address = $aa["billing_address"];
$shipping_address = $aa["shipping_address"];
$remarks = $aa["remarks"];
 
$discount_percent  = $aa['discount_percent'];
$billing_city  = $aa['billing_city'];
$billing_state  = $aa['billing_state'];
$billing_pin  = $aa['billing_pin'];
$shipping_city  = $aa['shipping_city'];
$shipping_state  = $aa['shipping_state'];
$shipping_pin  = $aa['shipping_pin']; 



//  Stock check start

 foreach($aa["cart_details"] as $value) {
  $product_id         =   $value["product_id"];
  $customer_id        =   $value["customer_id"];
  $order_status       =   "Ordered";
  if (!empty($product_id) && !empty($customer_id) && !empty($value["product_quantity"])) {
 
//print_r( $value); 
foreach ($value["product_quantity"] as $cart) {
//  print_r($cart);
$product_details_id =  $cart["product_details_id"];
$set =  $cart["set"];
$piece =  $cart["piece"];
$mrp =  $cart["mrp"];
$amount =  $cart["amount"];


if (!empty($product_id) && !empty($customer_id) && !empty($product_details_id) && !empty($set) && !empty($piece)&& !empty($mrp) && !empty($amount) ) {

  $details=$Product->product_display($db->tbl_pre . "product_tbl pt, " .$db->tbl_pre . "product_details_tbl pdt, " . $db->tbl_pre . "product_size_tbl sz ", array(), "WHERE pt.product_id ='".$product_id."' and product_details_id='".$product_details_id."'  and sz.product_size_id=pdt.size_id " );
//echo json_encode($details);
    
        if ($set>$details[0]["stock_in_hand"]) {               
               
        $product = array();
        $product["product_details_id"]  =   $details[0]["product_details_id"];
        $product["product_id"]          =   $details[0]["product_id"];
        $product["style_no"]            =   $details[0]["style_no"];
        $product["product_name"]        =   $details[0]["product_name"];
        $product["stock_in_hand"]       =   $details[0]["stock_in_hand"];
        $product["size_id"]             =   $details[0]["size_id"];
        $product["size_description"]    =   $details[0]["size_description"];
        $product["msg"]                 =   "Product style is out of stock";
        // push single product into final response array
        array_push($response["stock"], $product);
    
    }
}

} }
}

if (count($response["stock"])>0) {
    $response["status"] = FALSE;
    $response["msg"] = "Product is out of stock..  ";
 echo json_encode($response);
 exit();
} 
//  Stock check end

 
 foreach($aa["cart_details"] as $value) {
  $product_id         =   $value["product_id"];
  $customer_id        =   $value["customer_id"];
  $order_status       =   "Ordered";
  if (!empty($product_id) && !empty($customer_id) && !empty($value["product_quantity"])) {
 
//print_r( $value); 
foreach ($value["product_quantity"] as $cart) {
//  print_r($cart);
$product_details_id =  $cart["product_details_id"];
$set =  $cart["set"];
$piece =  $cart["piece"];
$mrp =  $cart["mrp"];
$amount =  $cart["amount"];

 

 if (!empty($product_id) && !empty($customer_id) && !empty($product_details_id) && !empty($set) && !empty($piece)&& !empty($mrp) && !empty($amount) ) {
 $get_generate_no= $Product->product_display($db->tbl_pre . "order_master", array(), "WHERE generate_no ='".$generate_no."'  " );
if (count($get_generate_no)==0) {

  $order_add = $db->insert('order_master', array('generate_no'=>$generate_no,'customer_id'=>rep($customer_id),'total_bill_amount'=>rep($total_bill_amount),'billing_address'=>rep($billing_address),'shipping_address'=>rep($shipping_address),'remarks'=>rep($remarks),'discount_percent'=>rep($discount_percent),'billing_city'=>rep($billing_city),'billing_state'=>rep($billing_state),'billing_pin'=>rep($billing_pin),'shipping_city'=>rep($shipping_city),'shipping_state'=>rep($shipping_state),'shipping_pin'=>rep($shipping_pin),'order_status'=>rep('Ordered') ));

}

$name_value = array('generate_no'=>$generate_no,'product_id' => rep($product_id), 'customer_id' => rep($customer_id), 'product_details_id' => rep($product_details_id), 'total_set' =>  ($set), 'mrp' => rep($mrp),'amount'=>rep($amount), 'order_status'=>rep($order_status));
 

  $order_confirm = $db->update('orders_tbl', $name_value, "product_id='" . $product_id . "' and customer_id='" . $customer_id . "'  and product_details_id='" . $product_details_id . "' and order_status='Cart' ");


/*if ($order_confirm['affectedRow'] == 1) {
  $details=$Product->product_display($db->tbl_pre . "product_details_tbl ", array(), "WHERE product_details_id ='".$product_details_id."'");
  //$order_pcs=$details[0]["style_set_qty"] * $set;
$sub_stock_in_hand=$details[0]["stock_in_hand"]-$set;
$name_value = array( 'stock_in_hand' => rep($sub_stock_in_hand) );

$stock = $db->update('product_details_tbl', $name_value, "product_details_id='" . $product_details_id . "'   ");
}*/


if ($order_confirm['affectedRow'] == 0) {

 foreach($aa["cart_details"] as $value) {
  $product_id         =   $value["product_id"];
  $customer_id        =   $value["customer_id"];
  $order_status       =   "Ordered";
  if (!empty($product_id) && !empty($customer_id) && !empty($value["product_quantity"])) {
 
//print_r( $value); 
foreach ($value["product_quantity"] as $cart) {
//  print_r($cart);
$product_details_id =  $cart["product_details_id"];
$set =  $cart["set"];
$piece =  $cart["piece"];
$mrp =  $cart["mrp"];
$amount =  $cart["amount"];
 if (!empty($product_id) && !empty($customer_id) && !empty($product_details_id) && !empty($set) && !empty($piece)&& !empty($mrp) && !empty($amount) ) {

$name_value = array( 'product_id' => rep($product_id), 'customer_id' => rep($customer_id), 'product_details_id' => rep($product_details_id), 'total_set' =>  ($set), 'mrp' => rep($mrp),'amount'=>rep($amount), 'order_status'=>'Cart');
 

  $order_confirm = $db->update('orders_tbl', $name_value, "product_id='" . $product_id . "' and customer_id='" . $customer_id . "'  and product_details_id='" . $product_details_id . "' and order_status='Ordered' and generate_no='".$generate_no."' ");


}
 }
        }}   
$order_confirm = $db->delete('order_master', array("generate_no" => $generate_no));
 $response["status"] = FALSE;
        $response["msg"] = "Error occured please select your product and palce order.  ";
        echo json_encode($response);
        exit();
         } }
            else {





         $response["status"] = FALSE;
        $response["msg"] = "Required Product details is empty.  ";
        echo json_encode($response);
        exit();
            }
       
}
}

  } 

$to= Admin_Receiving_Email_ID;
 
  $order_array = $order->order_display($db->tbl_pre . "order_master ortm, " . $db->tbl_pre . "orders_tbl ort, " . $db->tbl_pre . "customer_tbl lt, " . $db->tbl_pre . "product_details_tbl pdt, " . $db->tbl_pre . "product_size_tbl pst, " . $db->tbl_pre . "product_tbl pt ", array(), "WHERE ort.customer_id=lt.customer_id and ort.product_id=pt.product_id and ort.product_details_id=pdt.product_details_id and pdt.size_id=pst.product_size_id and ort.product_id=pt.product_id  and ort.generate_no='".$generate_no."' and ortm.generate_no='".$generate_no."'");
  
  $order_mstr = $order->order_display($db->tbl_pre . "order_master ", array(), "WHERE generate_no='".$generate_no."'");
  $shipping_address=strlen($order_mstr[0]["shipping_address"]);
  $address = $shipping_address> 10 ? $order_mstr[0]["shipping_address"] :  $order_mstr[0]["billing_address"]; 
  
$subject = "Dear Admin New Order Placed";
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
            <th colspan="8" align="center" style="font-size:13px;text-transform:uppercase;font-weight: 400;">Green Orbit Apparels Pvt Ltd</th>
          </tr>
          <tr style="font-size:14px">            
            <td colspan="4">
                21, Ballygunge Circular Road,<br/>Cpc Office Complex, 1st Floor, Suite No-III, <br/>Kolkata - 700019<br/>West Bengal<br/>Phone No. :  033 4602 6390<br/>CIN :xxxxxxxxxx<br/>GSTIN No.: 19AACCG5839Q1ZT<br/><br/>PAN : 19AACCG5839Q
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
                <br/>'.$order_array[0]["Company_name"].'<br/>'.$address.'<br/>GSTIN No.:'.$order_array[0]["gst_no"].'<br/>PAN :'.$order_array[0]["pan_no"].'

            </td>
            <td colspan="4" valign="top" style="border-left: 1px solid #000;">
                <br/><span style="width:68px;">Order No. :</span> '.$order_array[0]["generate_no"].'<br/><span style="width:68px;">Date :</span> '.date('F d, Y',strtotime($order_array[0]["order_Date"])).'<br/><span style="width:68px;">Remarks :</span> '.$order_array[0]["remarks"].'
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
                Terms :<br/>1) Defects/Shortages if any should be reported within three days from the receipt of goods.<br/>2) Interest @18 % will be charged after due date.<br/>3) All Subject to Kolkata Jurisdiction.<br/>4) Our Banker : XXXXX Bank Ltd, Corporate Banking Branch, A/c. XXXXXXXXXXXX, IFSC: XXXXXXXXXX.<br/>5) This is a computer generated copy hence signature is not required.
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
$subject_user = "Your Order Details";
$headers_user = "MIME-Version: 1.0" . "\r\n";
$headers_user .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers_user .= 'From:'.Site_Title.' <'.Admin_Sending_Email_ID.'>' . "\r\n";

mail($to_user,$subject_user,$message,$headers_user);

              $response["status"] = TRUE;
        $response["msg"] = "Your order is successfully placed. Your order no is :".$generate_no."  ";       
        $_SESSION['order_no']=$generate_no;
        echo json_encode($response);
}
else{
  $response["status"] = FALSE;
        $response["msg"] = "Required parameter missing  ";
        echo json_encode($response);
}


?>
