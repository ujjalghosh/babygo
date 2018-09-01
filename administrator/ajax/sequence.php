<?php
include "../../includes/settings.php";
include "../../includes/class_call_one_file.php";
$aColumns = array('ut.sequence_id', 'ut.sequence_name', 'ut.sequence_subject', 'ut.sequence_sender_name', 'ut.sequence_sender_email', 'ut.sequence_reply_to_name', 'ut.sequence_reply_to_email', 'ut.sequence_id', 'ut.sequence_day', 'ut.sequence_time', 'ut.sequence_status');
$sIndexColumn = "ut.sequence_id";
$sTable = $db->tbl_pre . "sequence_tbl ut";
$sWhere = "WHERE ut.sequence_type='Automatic'";
//print_r($_GET);
//// Pagination //
$sLimit = "";
if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
	$sLimit = $_GET['iDisplayStart'] . ", " . $_GET['iDisplayLength'];
}
// Order //
if (isset($_GET['iSortCol_0'])) {
	$sOrder = "";
	for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
		if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
			$sOrder .= $aColumns[intval($_GET['iSortCol_' . $i])] . "	" . $_GET['sSortDir_' . $i] . ", ";
		}
	}
	$sOrder = substr_replace($sOrder, "", -2);
}
// Search //
if ($_GET['sSearch'] != "") {
	$sWhere .= " AND (";
	for ($i = 0; $i < count($aColumns); $i++) {
		$sWhere .= $aColumns[$i] . " LIKE '%" . ($_GET['sSearch']) . "%' OR ";
	}
	$sWhere = substr_replace($sWhere, "", -3);
	$sWhere .= ')';
}
/* Individual column filtering */
for ($i = 0; $i < count($aColumns); $i++) {
	if ($_GET['bSearchable_' . $i] == "true" && $_GET['sSearch_' . $i] != '') {
		if ($sWhere == "") {
			$sWhere = "WHERE ";
		} else {
			$sWhere .= " AND ";
		}
		$sWhere .= $aColumns[$i] . " LIKE '%" . mysql_real_escape_string($_GET['sSearch_' . $i]) . "%' ";
	}
}
// Generate Sql Query //
$aRow = $sequence->sequence_display($sTable, $aColumns, $sWhere, $sLimit, $sOrder);

/* Data set length after filtering */
$sQuery = "SELECT FOUND_ROWS()";
$rResultFilterTotal = $db->query($sQuery, PDO::FETCH_ASSOC);
$aResultFilterTotal = $db->result($rResultFilterTotal);
$iFilteredTotal = $aResultFilterTotal[0]['FOUND_ROWS()'];

/* Total data set length */
$sQuery = $db->query("SELECT * FROM " . $db->tbl_pre . "sequence_tbl");
$iTotal = $db->total($sQuery);

$output = array(
	"sEcho" => intval($_GET['sEcho']),
	"iTotalRecords" => $iTotal,
	"iTotalDisplayRecords" => $iFilteredTotal,
	"aaData" => array(),
);

for ($j = 0; $j < count($aRow); $j++) {
	$row = array();
	for ($i = 0; $i < count($aColumns); $i++) {
		if ($i == 7) {
			$email_list_name = '';
			$sequence_list_array = $sequence->sequence_display($db->tbl_pre . "sequence_email_list_tbl", array(), "WHERE sequence_id='" . $aRow[$j][$i] . "'");
			for ($sla = 0; $sla < count($sequence_list_array); $sla++) {
				$email_list_array = $email_list->email_list_display($db->tbl_pre . "email_list_tbl", array(), "WHERE email_list_id='" . $sequence_list_array[$sla]['email_list_id'] . "'");
				$email_list_name .= $email_list_array[0]['email_list_name'] . '<br>';
			}
			$row[] = repc($email_list_name);
		} else {
			$row[] = word_wrap_pass($aRow[$j][$i]);
		}
	}
	$output['aaData'][] = $row;
}
echo json_encode($output);
?>