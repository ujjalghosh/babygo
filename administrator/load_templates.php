<?php
include "includes/session.php";
$sequence_array = $sequence->sequence_display($db->tbl_pre . "sequence_tbl", array(), "WHERE sequence_status='Active'");

$response = array();
if ($sequence_array == -1) {
	$response['code'] = -1;
	echo json_encode($response);
	return;
}
if ($sequence_array == 0) {
	//not found
	$response['code'] = 1;
	echo json_encode($response);
	return;
}
$response['code'] = 0;
$response['files'] = $sequence_array;
echo json_encode($response);
?>
