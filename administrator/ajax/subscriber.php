<?php
include "../../includes/settings.php";
include "../../includes/class_call_one_file.php";
$aColumns = array('ut.subscriber_id', 'ut.subscriber_last_name', 'ut.subscriber_first_name', 'ut.subscriber_email_address', 'ut.subscriber_through', 'ut.subscriber_date', 'ut.subscriber_id', 'ut.subscriber_status');
$sIndexColumn = "ut.subscriber_id";
$sTable = $db->tbl_pre . "subscriber_tbl ut";
$sWhere = "WHERE ut.subscriber_id<>0";
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
$aRow = $subscriber->subscriber_display($sTable, $aColumns, $sWhere, $sLimit, $sOrder);

/* Data set length after filtering */
$sQuery = "SELECT FOUND_ROWS()";
$rResultFilterTotal = $db->query($sQuery, PDO::FETCH_ASSOC);
$aResultFilterTotal = $db->result($rResultFilterTotal);
$iFilteredTotal = $aResultFilterTotal[0]['FOUND_ROWS()'];

/* Total data set length */
$sQuery = $db->query("SELECT * FROM " . $db->tbl_pre . "subscriber_tbl");
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
		if ($aColumns[$i] == 'ut.subscriber_through' && $aRow[$j][$i] == 'Admin') {
			$subscriber_array1 = $subscriber->subscriber_display($db->tbl_pre . "subscriber_tbl", array(), "WHERE subscriber_id=" . $aRow[$j][0]);
			$row[] = $subscriber_array1[0]['subscriber_admin_name'];
		} else if ($i == 6) {
			$email_list_name = '';
			$subscriber_list_array = $subscriber->subscriber_display($db->tbl_pre . "subscriber_list_tbl", array(), "WHERE subscriber_id='" . $aRow[$j][$i] . "'");
			for ($sla = 0; $sla < count($subscriber_list_array); $sla++) {
				$email_list_array = $email_list->email_list_display($db->tbl_pre . "email_list_tbl", array(), "WHERE email_list_id='" . $subscriber_list_array[$sla]['email_list_id'] . "'");
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