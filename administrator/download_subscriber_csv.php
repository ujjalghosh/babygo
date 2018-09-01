<?php
include "includes/session.php";
if ($_REQUEST['email_list_id'] == '') {
	$subscriber_array = $subscriber->subscriber_display($db->tbl_pre . "subscriber_tbl", array(), "WHERE subscriber_id<>0");
} else {
	$subscriber_list_array = $subscriber->subscriber_display($db->tbl_pre . "subscriber_list_tbl", array(), "WHERE email_list_id='" . $_REQUEST['email_list_id'] . "'");
	$subscriber_ids = '';
	for ($sla = 0; $sla < count($subscriber_list_array); $sla++) {
		$subscriber_ids = $subscriber_ids . '' . $subscriber_list_array[$sla]['subscriber_id'] . ',';
	}
	$subscriber_ids = substr($subscriber_ids, 0, -1);
	$subscriber_array = $subscriber->subscriber_display($db->tbl_pre . "subscriber_tbl", array(), "WHERE subscriber_id in (" . $subscriber_ids . ")");
}
header("Content-type:text/octect-stream");
header("Content-Disposition:attachment;filename=subscriber_" . date('ymdhis') . "_list.csv");
echo 'First Name,Last Name,Email Address,Date of Joining,Email List Signup,Status';
echo "\n";

for ($bis = 0; $bis < count($subscriber_array); $bis++) {
	$email_list_name = '';
	$subscriber_list_array = $subscriber->subscriber_display($db->tbl_pre . "subscriber_list_tbl", array(), "WHERE subscriber_id='" . $subscriber_array[$bis]['subscriber_id'] . "'");
	for ($sla = 0; $sla < count($subscriber_list_array); $sla++) {
		$email_list_array = $email_list->email_list_display($db->tbl_pre . "email_list_tbl", array(), "WHERE email_list_id='" . $subscriber_list_array[$sla]['email_list_id'] . "'");
		$email_list_name .= $email_list_array[0]['email_list_name'] . '--';
	}
	$email_list_name = substr($email_list_name, 0, -2);
	echo rep_b($subscriber_array[$bis]['subscriber_first_name']) . ",";
	echo rep_b($subscriber_array[$bis]['subscriber_last_name']) . ",";
	echo rep_b($subscriber_array[$bis]['subscriber_email_address']) . ",";
	echo rep_b($subscriber_array[$bis]['subscriber_date']) . ",";
	echo $email_list_name . ",";
	echo rep_b($subscriber_array[$bis]['subscriber_status']);
	echo "\n";
}
exit;

?>