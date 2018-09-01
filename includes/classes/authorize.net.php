<?php
/*******************************************************************************
 *                Authorize.net AIM Interface using CURL
 *******************************************************************************
 *      Author:     Micah Carrick
 *      Email:      email@micahcarrick.com
 *      Website:    N/A
 *
 *      File:       authorizenet.class.php
 *      Version:    1.00
 *      Copyright:  (c) 2005 - Micah Carrick 
 *                  You are free to use, distribute, and modify this software 
 *                  under the terms of the GNU General Public License.  See the
 *                  included license.txt file.
 *      
 *******************************************************************************
 *  REQUIREMENTS:
 *      - PHP4+ with CURL and SSL support
 *      - An Authorize.net AIM merchant account
 *      - (optionally) http://www.authorize.net/support/AIM_guide.pdf
 *  
 *******************************************************************************
 *  VERION HISTORY:
 *  
 *      v1.00 [04.07.2005] - Initial Version
 *
 *******************************************************************************
 *  DESCRIPTION:
 *
 *      This class was developed to simplify interfacing a PHP script to the
 *      authorize.net AIM payment gateway.  It does not do all the work for
 *      you as some of the other scripts out there do.  It simply provides
 *      an easy way to implement and debug your own script.  
 * 
 *******************************************************************************
*/

class authorizenet_class {

	var $field_string;
	var $fields = array();

	var $response_string;
	var $response = array();

	var $gateway_url = "https://secure.nmi.com/gateway/transact.dll";	
 //var $gateway_url = "https://test.authorize.net/gateway/transact.dll";
//var $gateway_url = "https://secure.authorize.net/gateway/transact.dll";	

	function add_field($field, $value) {

      // adds a field/value pair to the list of fields which is going to be 
      // passed to authorize.net.  For example: "x_version=3.1" would be one
      // field/value pair.  A list of the required and optional fields to pass
      // to the authorize.net payment gateway are listed in the AIM document
      // available in PDF form from www.authorize.net

		$this->fields["$field"] = urlencode($value);   

	}

	function process() {

      // This function actually processes the payment.  This function will 
      // load the $response array with all the returned information.  The return
      // values for the function are:
      // 1 - Approved
      // 2 - Declined
      // 3 - Error

      // construct the fields string to pass to authorize.net
		foreach( $this->fields as $key => $value ) 
			$this->field_string .= "$key=" . urlencode( $value ) . "&";

      // execute the HTTPS post via CURL
		$ch = curl_init($this->gateway_url); 
		curl_setopt($ch, CURLOPT_HEADER, 0); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, rtrim( $this->field_string, "& " )); 
		$this->response_string = urldecode(curl_exec($ch)); 

		if (curl_errno($ch)) {
			$this->response['Response Reason Text'] = curl_error($ch);
			return 3;
		}
		else curl_close ($ch);


      // load a temporary array with the values returned from authorize.net
		$temp_values = explode('|', $this->response_string);

      // load a temporary array with the keys corresponding to the values 
      // returned from authorize.net (taken from AIM documentation)
		$temp_keys= array ( 
			"Response Code", "Response Subcode", "Response Reason Code", "Response Reason Text",
			"Approval Code", "AVS Result Code", "Transaction ID", "Invoice Number", "Description",
			"Amount", "Method", "Transaction Type", "Customer ID", "Cardholder First Name",
			"Cardholder Last Name", "Company", "Billing Address", "City", "State",
			"Zip", "Country", "Phone", "Fax", "Email", "Ship to First Name", "Ship to Last Name",
			"Ship to Company", "Ship to Address", "Ship to City", "Ship to State",
			"Ship to Zip", "Ship to Country", "Tax Amount", "Duty Amount", "Freight Amount",
			"Tax Exempt Flag", "PO Number", "MD5 Hash", "Card Code (CVV2/CVC2/CID) Response Code",
			"Cardholder Authentication Verification Value (CAVV) Response Code"
			);

      // add additional keys for reserved fields and merchant defined fields
		for ($i=0; $i<=27; $i++) {
			array_push($temp_keys, 'Reserved Field '.$i);
		}
		$i=0;
		while (sizeof($temp_keys) < sizeof($temp_values)) {
			array_push($temp_keys, 'Merchant Defined Field '.$i);
			$i++;
		}

      // combine the keys and values arrays into the $response array.  This
      // can be done with the array_combine() function instead if you are using
      // php 5.
		for ($i=0; $i<sizeof($temp_values);$i++) {
			$this->response["$temp_keys[$i]"] = $temp_values[$i];
		}

      // Return the response code.
		return $this->response['Response Code'];

	}

	function get_response_reason_text() {
		return $this->response['Response Reason Text'];
	}

	function get_transaction_id() {
		return $this->response['Transaction ID'];
	}

	function dump_fields() {

      // Used for debugging, this function will output all the field/value pairs
      // that are currently defined in the instance of the class using the
      // add_field() function.

		echo "<h3>authorizenet_class->dump_fields() Output:</h3>";
		echo "<table width=\"95%\" border=\"1\" cellpadding=\"2\" cellspacing=\"0\">
		<tr>
			<td bgcolor=\"black\"><b><font color=\"white\">Field Name</font></b></td>
			<td bgcolor=\"black\"><b><font color=\"white\">Value</font></b></td>
		</tr>"; 

		foreach ($this->fields as $key => $value) {
			echo "<tr><td>$key</td><td>".urldecode($value)."&nbsp;</td></tr>";
		}

		echo "</table><br>"; 
	}

	function dump_response() {

      // Used for debuggin, this function will output all the response field
      // names and the values returned for the payment submission.  This should
      // be called AFTER the process() function has been called to view details
      // about authorize.net's response.

		echo "<h3>authorizenet_class->dump_response() Output:</h3>";
		echo "<table width=\"95%\" border=\"1\" cellpadding=\"2\" cellspacing=\"0\">
		<tr>
			<td bgcolor=\"black\"><b><font color=\"white\">Index&nbsp;</font></b></td>
			<td bgcolor=\"black\"><b><font color=\"white\">Field Name</font></b></td>
			<td bgcolor=\"black\"><b><font color=\"white\">Value</font></b></td>
		</tr>";

		$i = 0;
		foreach ($this->response as $key => $value) {
			echo "<tr>
			<td valign=\"top\" align=\"center\">$i</td>
			<td valign=\"top\">$key</td>
			<td valign=\"top\">$value&nbsp;</td></tr>";
			$i++;
		} 
		echo "</table><br>";
	}    
}


//||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||

//||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||

function make_payment_authorize_dot_net($user_info)	//argument==user inrormation as array,    return true/false
{


/*  Demonstration on using authorizenet.class.php.  This just sets up a
 *  little test transaction to the authorize.net payment gateway.  You
 *  should read through the AIM documentation at authorize.net to get
 *  some familiarity with what's going on here.  You will also need to have
 *  a login and password for an authorize.net AIM account and PHP with SSL and
 *  curl support.
 *
 *  Reference http://www.authorize.net/support/AIM_guide.pdf for details on
 *  the AIM API.
*/  

//require_once('authorizenet.class.php');

$a = new authorizenet_class;

// You login using your login, login and tran_key, or login and password.  It
// varies depending on how your account is setup.
// I believe the currently reccomended method is to use a tran_key and not
// your account password.  See the AIM documentation for additional information.

$a->add_field('x_login', '34rQcE5n');	//test tPmK83wZp4f
$a->add_field('x_tran_key', '2a73Yk228qXtV6RR');	//test w49GkrYG6uWZ5p7v
//$a->add_field('x_password', 'RSI@3920b');

$a->add_field('x_version', '3.1');
$a->add_field('x_type', 'AUTH_CAPTURE');
$a->add_field('x_test_request', 'FALSE');    // Just a test transaction
$a->add_field('x_relay_response', 'FALSE');

// You *MUST* specify '|' as the delim char due to the way I wrote the class.
// I will change this in future versions should I have time.  But for now, just
// make sure you include the following 3 lines of code when using this class.

$a->add_field('x_delim_data', 'TRUE');
$a->add_field('x_delim_char', '|');     
$a->add_field('x_encap_char', '');


// Setup fields for customer information.  This would typically come from an
// array of POST values froma secure HTTPS form.


//These are the information of the user. 
//If these are not same with the details of the credit card holder then the transaction is rejected.
//So to take no risk just comment out these fields. - Tushar


$a->add_field('x_first_name', $user_info['first_name']);
$a->add_field('x_last_name', $user_info['last_name']);
$a->add_field('x_address', $user_info['address']);
$a->add_field('x_city', $user_info['city']);
$a->add_field('x_state', $user_info['state']);
$a->add_field('x_zip', $user_info['zip']);
$a->add_field('x_country', $user_info['country']);
$a->add_field('x_email', $user_info['email']);
$a->add_field('x_phone', $user_info['phone']);


// Using credit card number '4007000000027' performs a successful test.  This
// allows you to test the behavior of your script should the transaction be
// successful.  If you want to test various failures, use '4222222222222' as
// the credit card number and set the x_amount field to the value of the 
// Response Reason Code you want to test.  
// 
// For example, if you are checking for an invalid expiration date on the
// card, you would have a condition such as:
// if ($a->response['Response Reason Code'] == 7) ... (do something)
//
// Now, in order to cause the gateway to induce that error, you would have to
// set x_card_num = '4222222222222' and x_amount = '7.00'




//  Setup fields for payment information
$a->add_field('x_method', 'CC');
$a->add_field('x_card_num', $user_info['card_num']);   // test successful visa
//$a->add_field('x_card_num', '370000000000002');   // test successful american express
//$a->add_field('x_card_num', '6011000000000012');  // test successful discover
//$a->add_field('x_card_num', '5424000000000015');  // test successful mastercard
// $a->add_field('x_card_num', '4222222222222');    // test failure card number
$a->add_field('x_amount', $user_info['amount']);
$a->add_field('x_exp_date', $user_info['exp_date']);    // '0308' i.e.march of 2008
$a->add_field('x_card_code', $user_info['cvc']);    // Card CAVV Security code


// Process the payment and output the results
switch ($a->process()) {

   case 1:  // Successs
      //echo "<b>Success:</b><br>";
      //echo $a->get_response_reason_text();
      //echo "<br><br>Details of the transaction are shown below...<br><br>";
   $payemnt_status="true";
   break;

   case 2:  // Declined
      //echo "<b>Payment Declined:</b><br>";
      //echo $a->get_response_reason_text();
      //echo "<br><br>Details of the transaction are shown below...<br><br>";
   $payemnt_status="false";
   break;

   case 3:  // Error
      //echo "<b>Error with Transaction:</b><br>";
      //echo $a->get_response_reason_text();
      //echo "<br><br>Details of the transaction are shown below...<br><br>";
   $payemnt_status="false";
   break;
 }

// The following two functions are for debugging and learning the behavior
// of authorize.net's response codes.  They output nice tables containing
// the data passed to and recieved from the gateway.

//$a->dump_fields();      // outputs all the fields that we set
//$a->dump_response();    // outputs the response from the payment gateway
//return true;
//echo $a->get_response_reason_text();
 return $payemnt_status.'~'.$a->get_response_reason_text().'~'.$a->get_transaction_id();
}
?>