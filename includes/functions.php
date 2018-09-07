<?php
// Mysql Filter //
function filter($var) {
	if (get_magic_quotes_gpc()) $var = stripslashes($var);
	return trim($var);
}
// Function To Replace Illegal Characters //
function rep($ab) {
	$ab = str_replace("'", "''", $ab);
	$ab = str_replace("\'", "'", $ab);
	return $ab;
}
function rep_excel($ab) {
	$ab = str_replace("\u0000", "", $ab);
	$ab = str_replace("\'", "'", $ab);
	return $ab;
}
function rep_b($ab) {
	$ab = str_replace("''", "'", $ab);
	$ab = str_replace("\'", "'", $ab);
	return $ab;
}
function repc($ab) {
	$ab = stripslashes($ab);
	$ab = str_replace("''", "'", $ab);
	return $ab;
}
function rep_title($ab) {
	$ab = str_replace("''", "&quot;", $ab);
	return $ab;
}
// Date Time Function //
function date_time_format($date_time, $flag= 1) {
	global $db;
	$unx_stamp = strtotime($date_time);
	$date_str  = "";
	$date_format=$db->result($db->query("select site_configuration_value from " . $db->tbl_pre . "site_configuration_tbl where site_configuration_id=4", PDO::FETCH_BOTH));
	switch ($date_format[0][0]) {
						//2004-06-29
		case 1:
		$date_str  = (date("Y-m-d", $unx_stamp));
		break;
		case 2:
		$date_str = (date("m-d-Y", $unx_stamp));
		break;
						//06-29-2004
		case 3:
		$date_str = (date("d-m-Y", $unx_stamp));
		break;
						//29-06-2004
		case 4:
		$date_str = (date("d", $unx_stamp) . ' ' . date("M", $unx_stamp) . ' ' . date("Y", $unx_stamp));
		break;
						//29 Jun 2004
		case 5:
		$date_str = (date("d", $unx_stamp) . ' ' . date("F", $unx_stamp) . ' ' . date("Y", $unx_stamp));
		break;
						//29 June 2004
		case 6:
		$date_str = (date("M", $unx_stamp) . ' ' . date("d", $unx_stamp) . ' ' . date("Y", $unx_stamp));
		break;
						//Jun 29,2004
		case 7:
		$date_str = (date("D M dS, Y", $unx_stamp));
		break;
						//Tue Jun 29th,2004
		case 8:
		$date_str = (date("l M jS, Y", $unx_stamp));
		break;
						//Tuesday Jun 29th,2004
		case 9:
		$date_str = (date("l F jS, Y", $unx_stamp));
		break;
						//Tuesday June 29th,2004
		case 10:
		$date_str = (date("d F Y l", $unx_stamp));
		break;
						//29 June 2004 Tuesday
		case 11:
		$date_str = (date("m/d/Y", $unx_stamp));
		break;
						//29 June 2004 Tuesday
	}
	$time_str = "";
	$time_format=$db->result($db->query("select site_configuration_value from " . $db->tbl_pre . "site_configuration_tbl where site_configuration_id=5", PDO::FETCH_BOTH));
	switch ($time_format[0][0]) {
		case 1:
		$time_str = (date("h:i a", $unx_stamp));
		break;
						//06:20 pm
		case 2:
		$time_str = (date("h:i A", $unx_stamp));
		break;
						//06:20 PM
		case 3:
		$time_str = (date("H:i", $unx_stamp));
		break;
						//18:20
	}

	switch ($flag) {
		case 1:
		return ($date_str);
		break;
		case 2:
		return ($time_str);
		break;
		case 3:
		return ($date_str . " " . $time_str);
		break;
		default:
		return ($date_str);
		break;
	}
}
function date_time_difference($time1, $time2, $start     = 4, $end       = 6) {
		// If not numeric then convert texts to unix timestamps
	if (!is_int($time1)) {
		$time1     = strtotime($time1);
	}
	if (!is_int($time2)) {
		$time2     = strtotime($time2);
	}
		// If time1 is bigger than time2
		// Then swap time1 and time2
	if ($time1 > $time2) {
		$ttime     = $time1;
		$time1     = $time2;
		$time2     = $ttime;
	}
		// Set up intervals and diffs arrays
	$intervals = array(
		'year',
		'month',
		'day',
		'hour',
		'minute',
		'second'
		);
	$diffs     = array();
		// Loop thru all intervals
	foreach ($intervals as $interval) {
				// Create temp time from time1 and interval
		$ttime     = strtotime('+1 ' . $interval, $time1);
				// Set initial values
		$add       = 1;
		$looped    = 0;
				// Loop until temp time is smaller than time2
		while ($time2 >= $ttime) {
						// Create new temp time from time1 and interval
			$add++;
			$ttime = strtotime("+" . $add . " " . $interval, $time1);
			$looped++;
		}
		$time1 = strtotime("+" . $looped . " " . $interval, $time1);
		$diffs[$interval]       = $looped;
	}
	$count = 0;
	$times = array();
		// Loop thru all diffs
	foreach ($diffs as $interval => $value) {
		$count++;
				// Add value and interval
				// if value is bigger than 0
		if ($value > 0 && $count >= $start && $count <= $end) {
						// Add value and interval to times array
			if ($interval == 'hour') {
				$timeh    = $value * 60 * 60;
			}
			if ($interval == 'minute') {
				$timem    = $value * 60;
			}
			if ($interval == 'second') {
				$times    = $value;
			}
		}
	}
	$times    = $timeh + $timem + $times;
		// Return string with times
	return $times;
}
function dateDiff($dformat, $endDate, $beginDate) {
	$date_parts1 = explode($dformat, $beginDate);
	$date_parts2 = explode($dformat, $endDate);
	$start_date  = gregoriantojd($date_parts1[1], $date_parts1[2], $date_parts1[0]);
	$end_date    = gregoriantojd($date_parts2[1], $date_parts2[2], $date_parts2[0]);
	return $end_date - $start_date;
}
// Password Encription //
function random_number($len  = 8) {
	$temp = mt_rand(1, 15500);
	$temp = md5($temp);
	$temp = substr($temp, 0, $len);
	$temp = strtoupper($temp);
	return $temp;
}
function encode($text) {
	$text = random_number(3) . base64_encode($text);
	$text = base64_encode($text);
	return $text;
}
function decode($text) {
	$text = base64_decode($text);
	$text = substr($text, 3);
	$text = base64_decode($text);
	return $text;
}
// Generate Guid
function NewGuid($len      = 8) {
	$s        = strtoupper(md5(uniqid(rand() , true)));
	$guidText = substr($s, 0, $len);
	return $guidText;
}
// Auto Generate Password //
function generatePassword($l     = 8, $c     = 0, $n     = 0, $s     = 0) {
		// get count of all required minimum special chars
	$count = $c + $n + $s;
		// sanitize inputs; should be self-explanatory
	if (!is_int($l) || !is_int($c) || !is_int($n) || !is_int($s)) {
		trigger_error('Argument(s) not an integer', E_USER_WARNING);
		return false;
	} 
	elseif ($l < 0 || $l > 20 || $c < 0 || $n < 0 || $s < 0) {
		trigger_error('Argument(s) out of range', E_USER_WARNING);
		return false;
	} 
	elseif ($c > $l) {
		trigger_error('Number of password capitals required exceeds password length', E_USER_WARNING);
		return false;
	} 
	elseif ($n > $l) {
		trigger_error('Number of password numerals exceeds password length', E_USER_WARNING);
		return false;
	} 
	elseif ($s > $l) {
		trigger_error('Number of password capitals exceeds password length', E_USER_WARNING);
		return false;
	} 
	elseif ($count > $l) {
		trigger_error('Number of password special characters exceeds specified password length', E_USER_WARNING);
		return false;
	}
		// all inputs clean, proceed to build password
		// change these strings if you want to include or exclude possible password characters
	$chars = "abcdefghijklmnopqrstuvwxyz";
	$caps  = strtoupper($chars);
	$nums  = "123456789";
	$syms  = "!@#$%^&*?";
		// build the base password of all lower-case letters
	for ($i     = 0;$i < $l;$i++) {
		$out.= substr($chars, mt_rand(0, strlen($chars) - 1) , 1);
	}
		// create arrays if special character(s) required
	if ($count) {
				// split base password to array; create special chars array
		$tmp1 = str_split($out);
		$tmp2 = array();
				// add required special character(s) to second array
		for ($i    = 0;$i < $c;$i++) {
			array_push($tmp2, substr($caps, mt_rand(0, strlen($caps) - 1) , 1));
		}
		for ($i = 0;$i < $n;$i++) {
			array_push($tmp2, substr($nums, mt_rand(0, strlen($nums) - 1) , 1));
		}
		for ($i = 0;$i < $s;$i++) {
			array_push($tmp2, substr($syms, mt_rand(0, strlen($syms) - 1) , 1));
		}
				// hack off a chunk of the base password array that's as big as the special chars array
		$tmp1 = array_slice($tmp1, 0, $l - $count);
				// merge special character(s) array with base password array
		$tmp1 = array_merge($tmp1, $tmp2);
				// mix the characters up
		shuffle($tmp1);
				// convert to string for output
		$out = implode('', $tmp1);
	}
	return $out;
}
// Message Display//
function messagedisplay($var  = "", $mode = 3) {
	switch ($mode) {
		case 1:
		$var  = " <div class='alert alert-success alert-dismissable'>
		<button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button>
		" . $var . "</div> ";
						//Success
		break;
		case 2:
		$var = " <div class='alert alert-danger alert-dismissable'>
		<button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button>
		 " . $var . "</div> ";
						//Error
		break;
		case 3:
		$var = " <div class='alert alert-warning alert-dismissable'>
		<button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button>
		 " . $var . "</div> ";
						//Message
		break;
		case 4:
		$var = " <div class='alert alert-danger alert-dismissable'>
		<button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button>
		 " . $var . "</div> ";
						//Critical
		break;
		default:
		$var = " <div class='alert alert-warning alert-dismissable'>
		<button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button>
		 " . $var . "</div> ";
						//Message
		break;
	}
	return $var;
}
// General Function //
function array_push_assoc($array, $key, $value) {
	$array[$key] = $value;
	return $array;
}
function string_limit_words($string, $word_limit) {
	$string  = strip_tags(str_replace("&nbsp;", " ", repc($string)));
	if (!empty($string)) {
		$words   = @explode(' ', $string);
		$sho_wor = @implode(' ', @array_slice($words, 0, $word_limit));
		if (strlen($sho_wor) <= $word_limit) {
			return $sho_wor;
		} 
		else {
			$sho_wor1 = substr($sho_wor, 0, $word_limit);
			return $sho_wor1;
		}
	}
}
function check_login() {
	if ($_SESSION['user_login'] != "success" && $_SESSION['user_login'] == "") {
		$_SESSION['user_msg'] = messagedisplay("Error: Please login to access this page!", 2);
		header('location:index.php');
		exit();
	}
}

function check_order_login() {
	if ($_SESSION['order_user_login'] != "success" && $_SESSION['order_user_login'] == "") {
		$_SESSION['user_msg'] = messagedisplay("Error: Please login to access this page!", 2);
		header('location:index.php');
		exit();
	}
}

function get_string_between($string, $start, $end) {
	$string = " " . $string;
	$ini    = strpos($string, $start);
	if ($ini == 0) return "";
	$ini+= strlen($start);
	$len = strpos($string, $end, $ini) - $ini;
	return substr($string, $ini, $len);
}
function word_wrap_pass($message) {
	$wrapAt     = 15;
	$tempText   = '';
	$finalText  = '';
	$curCount   = $tempCount  = 0;
	$longestAmp = 19;
	$inTag      = false;
	$ampText    = '';
	$len        = strlen($message);
	for ($num        = 0;$num < $len;$num++) {
		$curChar = $message{$num};
		if ($curChar == '<') {
			for ($snum    = 0;$snum < strlen($ampText);$snum++) {
				addWrap($ampText{$snum}, $ampText{$snum + 1}, $wrapAt, $finalText, $tempText, $curCount, $tempCount);
			}
			$ampText = '';
			$tempText.= '<';
			$inTag = true;
		} 
		elseif ($inTag && $curChar == '>') {
			$tempText.= '>';
			$inTag = false;
		} 
		elseif ($inTag) {
			$tempText.= $curChar;
		} 
		elseif ($curChar == '&') {
			for ($snum = 0;$snum < strlen($ampText);$snum++) {
				addWrap($ampText{$snum}, $ampText{$snum + 1}, $wrapAt, $finalText, $tempText, $curCount, $tempCount);
			}
			$ampText = '&';
		} 
		elseif (strlen($ampText) < $longestAmp && $curChar == ';' && function_exists('html_entity_decode') && (strlen(html_entity_decode("$ampText;")) == 1 || preg_match('/^&#[0-9]+$/', $ampText))) {
			addWrap($ampText . ';', $message{$num + 1}, $wrapAt, $finalText, $tempText, $curCount, $tempCount);
			$ampText = '';
		} 
		elseif (strlen($ampText) >= $longestAmp || $curChar == ';') {
			for ($snum    = 0;$snum < strlen($ampText);$snum++) {
				addWrap($ampText{$snum}, $ampText{$snum + 1}, $wrapAt, $finalText, $tempText, $curCount, $tempCount);
			}
			addWrap($curChar, $message{$num + 1}, $wrapAt, $finalText, $tempText, $curCount, $tempCount);
			$ampText = '';
		} 
		elseif (strlen($ampText) != 0 && strlen($ampText) < $longestAmp) {
			$ampText.= $curChar;
		} 
		else {
			addWrap($curChar, $message{$num + 1}, $wrapAt, $finalText, $tempText, $curCount, $tempCount);
		}
	}
	return $finalText . $tempText;
}
function addWrap($curChar, $nextChar, $maxChars, &$finalText, &$tempText, &$curCount, &$tempCount) {
	$wrapProhibitedChars = "([{!;,\\/:?}])";
	if ($curChar == ' ' || $curChar == "\n") {
		$finalText.= $tempText . $curChar;
		$tempText = '';
		$curCount = 0;
		$curChar  = '';
	} 
	elseif ($curCount >= $maxChars) {
		$finalText.= $tempText . ' ';
		$tempText = '';
		$curCount = 1;
	} 
	else {
		$tempText.= $curChar;
		$curCount++;
	}
		// the following code takes care of (unicode) characters prohibiting non-mandatory breaks directly before them.
		// $curChar isn't a " " or "\n"
	if ($tempText != '' && $curChar != '') {
		$tempCount++;
	}
		// $curChar is " " or "\n", but $nextChar prohibits wrapping.
	elseif (($curCount == 1 && strstr($wrapProhibitedChars, $curChar) !== false) || ($curCount == 0 && $nextChar != '' && $nextChar != ' ' && $nextChar != "\n" && strstr($wrapProhibitedChars, $nextChar) !== false)) {
		$tempCount++;
	}
		// $curChar and $nextChar aren't both either " " or "\n"
	elseif (!($curCount == 0 && ($nextChar == ' ' || $nextChar == "\n"))) {
		$tempCount = 0;
	}
	if ($tempCount >= $maxChars && $tempText == '') {
		$finalText.= '&nbsp;';
		$tempCount = 1;
		$curCount  = 2;
	}
	if ($tempText == '' && $curCount > 0) {
		$finalText.= $curChar;
	}
}
function tep_get_uprid($prid, $params) {

	$uprid = $prid;

	if (is_array($params) && (sizeof($params) > 0)) {
		$attributes_check = true;
		$attributes_ids = '';

		reset($params);
		while (list($option, $value) = each($params)) {
			if (is_numeric($option) && is_numeric($value)) {
				$attributes_check = true;
				$attributes_ids .= '{' . (int)$option . '}' . (int)$value;
			} else {
				if ($attributes_check != true)
					$attributes_check = false;
				
			}
		}

		if ($attributes_check == true) {
			$uprid .= $attributes_ids;
		}
	}
	return $uprid;
}

function tep_get_prid($uprid) {
	$pieces = explode('{', $uprid);

	if (is_numeric($pieces[0])) {
		return $pieces[0];
	} else {
		return false;
	}
}

function tep_href_link($page = '', $parameters = '') {
	global $request_type, $session_started, $SID;

	
	if ($parameters!="") {
		$link .= $page . '?' . $parameters;
		$separator = '&';
	} else {
		$link .= $page;
		$separator = '?';
	}

	while ( (substr($link, -1) == '&') || (substr($link, -1) == '?') ) $link = substr($link, 0, -1);

// Add the session ID when moving from different HTTP and HTTPS servers, or when SID is defined
	

	return $link;
}

function tep_get_all_get_params($exclude_array = '') {
	global $HTTP_GET_VARS;

	if (!is_array($exclude_array)) $exclude_array = array();

	$get_url = '';
	if (is_array($HTTP_GET_VARS) && (sizeof($HTTP_GET_VARS) > 0)) {
		reset($HTTP_GET_VARS);
		while (list($key, $value) = each($HTTP_GET_VARS)) {
			if ( (strlen($value) > 0) && ($key != 'error') && (!in_array($key, $exclude_array)) && ($key != 'x') && ($key != 'y') ) {
				$get_url .= $key . '=' . rawurlencode(stripslashes($value)) . '&';
			}
		}
	}

	return $get_url;
}

 function  amount_format_in($amount){
	 
setlocale(LC_MONETARY, 'en_IN');
$amount = money_format('%!i', $amount);
return $amount;
}

  $host=$_SERVER['HTTP_HOST'];
		 if($host=='localhost' || $host=='127.0.01'){
 function money_format($format, $number)
{
    $regex  = '/%((?:[\^!\-]|\+|\(|\=.)*)([0-9]+)?'.
              '(?:#([0-9]+))?(?:\.([0-9]+))?([in%])/';
    if (setlocale(LC_MONETARY, 0) == 'C') {
        setlocale(LC_MONETARY, '');
    }
    $locale = localeconv();
    preg_match_all($regex, $format, $matches, PREG_SET_ORDER);
    foreach ($matches as $fmatch) {
        $value = floatval($number);
        $flags = array(
            'fillchar'  => preg_match('/\=(.)/', $fmatch[1], $match) ?
                           $match[1] : ' ',
            'nogroup'   => preg_match('/\^/', $fmatch[1]) > 0,
            'usesignal' => preg_match('/\+|\(/', $fmatch[1], $match) ?
                           $match[0] : '+',
            'nosimbol'  => preg_match('/\!/', $fmatch[1]) > 0,
            'isleft'    => preg_match('/\-/', $fmatch[1]) > 0
        );
        $width      = trim($fmatch[2]) ? (int)$fmatch[2] : 0;
        $left       = trim($fmatch[3]) ? (int)$fmatch[3] : 0;
        $right      = trim($fmatch[4]) ? (int)$fmatch[4] : $locale['int_frac_digits'];
        $conversion = $fmatch[5];

        $positive = true;
        if ($value < 0) {
            $positive = false;
            $value  *= -1;
        }
        $letter = $positive ? 'p' : 'n';

        $prefix = $suffix = $cprefix = $csuffix = $signal = '';

        $signal = $positive ? $locale['positive_sign'] : $locale['negative_sign'];
        switch (true) {
            case $locale["{$letter}_sign_posn"] == 1 && $flags['usesignal'] == '+':
                $prefix = $signal;
                break;
            case $locale["{$letter}_sign_posn"] == 2 && $flags['usesignal'] == '+':
                $suffix = $signal;
                break;
            case $locale["{$letter}_sign_posn"] == 3 && $flags['usesignal'] == '+':
                $cprefix = $signal;
                break;
            case $locale["{$letter}_sign_posn"] == 4 && $flags['usesignal'] == '+':
                $csuffix = $signal;
                break;
            case $flags['usesignal'] == '(':
            case $locale["{$letter}_sign_posn"] == 0:
                $prefix = '(';
                $suffix = ')';
                break;
        }
        if (!$flags['nosimbol']) {
            $currency = $cprefix .
                        ($conversion == 'i' ? $locale['int_curr_symbol'] : $locale['currency_symbol']) .
                        $csuffix;
        } else {
            $currency = '';
        }
        $space  = $locale["{$letter}_sep_by_space"] ? ' ' : '';

        $value = number_format($value, $right, $locale['mon_decimal_point'],
                 $flags['nogroup'] ? '' : $locale['mon_thousands_sep']);
        $value = @explode($locale['mon_decimal_point'], $value);

        $n = strlen($prefix) + strlen($currency) + strlen($value[0]);
        if ($left > 0 && $left > $n) {
            $value[0] = str_repeat($flags['fillchar'], $left - $n) . $value[0];
        }
        $value = implode($locale['mon_decimal_point'], $value);
        if ($locale["{$letter}_cs_precedes"]) {
            $value = $prefix . $currency . $space . $value . $suffix;
        } else {
            $value = $prefix . $value . $space . $currency . $suffix;
        }
        if ($width > 0) {
            $value = str_pad($value, $width, $flags['fillchar'], $flags['isleft'] ?
                     STR_PAD_RIGHT : STR_PAD_LEFT);
        }

        $format = str_replace($fmatch[0], $value, $format);
    }
    return $format;
}
}

function goods_movement_summary(){
global $db;
  $db->truncate("TRUNCATE table " . $db->tbl_pre .  "goods_movement_summary");

    $db->executequery("INSERT INTO babygodb_goods_movement_summary (`product_id`, `stock_qty`, `avg_cost_price`) SELECT product_id, style_color_qty AS stock_qty, style_mrp_for_size as avg_cost_price FROM babygodb_product_tbl");
    


/*"INSERT INTO babygodb_goods_movement_summary (`product_id`, `stock_qty`, `avg_cost_price`)

SELECT 0 as batch_id ,0 as batch_expiry,A.`product_id`,A.`company_id`,A.`location_id`,sum(qty_in)-sum(qty_out) as stock_qty, IFNULL(avg(case when `reference_type`='purchase' then B.taxable_value/qty_in else NULL end),0) as avg_cost_price FROM (select reference_id, product_id, company_id, location_id, reference_type, sum(qty_in) as qty_in, sum(qty_out) as qty_out FROM  babygodb_goods_movement_register group by reference_id, product_id, company_id, location_id,reference_type) AS A LEFT OUTER JOIN ( select bill_id, product_id, sum(taxable_value) as taxable_value FROM `babygodb_purchase_bill_transaction` group by bill_id, product_id ) as B ON A.`reference_id` = B.`bill_id` AND A.`product_id`=B.`product_id` JOIN babygodb_product_tbl C ON A.product_id = C.product_id JOIN babygodb_product_group_tbl D ON C.product_group_id = D.product_group_id and D.type <> 'Service' group BY A.`product_id`,A.`company_id`,A.`location_id`"*/


}


?>