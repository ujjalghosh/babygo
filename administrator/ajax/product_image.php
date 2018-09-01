<?php
include "../../includes/settings.php";
include "../../includes/class_call_one_file.php";
$aColumns = array('zct.color_image_id', 'pt.style_no', 'gt.product_color_name',  'zct.listing_image');
$sIndexColumn = "zct.color_image_id";
$sTable = $db->tbl_pre . "color_image_tbl zct, " . $db->tbl_pre . "product_tbl pt, " . $db->tbl_pre . "product_color_tbl gt";
$sWhere = "WHERE zct.product_id=pt.product_id and zct.color_id=gt.product_color_id";
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
$aRow = $product_image->product_image_display($sTable, $aColumns, $sWhere, $sLimit, $sOrder);

/* Data set length after filtering */
$sQuery = "SELECT FOUND_ROWS()";
$rResultFilterTotal = $db->query($sQuery, PDO::FETCH_ASSOC);
$aResultFilterTotal = $db->result($rResultFilterTotal);
$iFilteredTotal = $aResultFilterTotal[0]['FOUND_ROWS()'];

/* Total data set length */
$sQuery = $db->query("SELECT * FROM " . $db->tbl_pre . "color_image_tbl");
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
 if ($aColumns[$i] != ' ' && $aColumns[$i] == 'zct.listing_image') {
			$row[] = '<img height="30" width="50" src="'.SITE_URL.'images/color/listing/'.$aRow[$j][$i].'" >' ;
		}else{
			$row[] = $aRow[$j][$i];
		}
	}
	$output['aaData'][] = $row;
}
echo json_encode($output);
?>