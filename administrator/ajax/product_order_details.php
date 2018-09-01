<?php
include "../../includes/settings.php";
include "../../includes/class_call_one_file.php";
 
/*$aColumns = array('ort.trans_id','ort.generate_no','pt.style_no', 'pt.product_name', 'pst.size_description', 'ort.total_set', 'ort.amount' );
$sIndexColumn = "ort.trans_id";
$sTable = $db->tbl_pre . "orders_tbl ort, " . $db->tbl_pre . "customer_tbl lt, " . $db->tbl_pre . "product_details_tbl pdt, " . $db->tbl_pre . "product_size_tbl pst, " . $db->tbl_pre . "product_tbl pt " ;
$sWhere = "WHERE ort.customer_id=lt.customer_id and ort.product_id=pt.product_id and ort.product_details_id=pdt.product_details_id and pdt.size_id=pst.product_size_id and ort.product_id=pt.product_id   ";*/
 
 
 $aColumns = array('ort.trans_id','lt.customer_name','pt.product_name','ort.generate_no','pt.style_no' , 'pst.size_description', 'ort.total_set', 'ort.amount'  );
$sIndexColumn = "ort.trans_id";
$sTable = $db->tbl_pre . "orders_tbl ort, " . $db->tbl_pre . "customer_tbl lt, " . $db->tbl_pre . "product_details_tbl pdt, " . $db->tbl_pre . "product_size_tbl pst, " . $db->tbl_pre . "product_tbl pt " ;
$sWhere = "WHERE ort.customer_id=lt.customer_id and ort.product_id=pt.product_id and ort.product_details_id=pdt.product_details_id and pdt.size_id=pst.product_size_id and ort.product_id=pt.product_id  and ort.generate_no='".$_GET['orderno']."' ";

//print_r($_GET);
//// Pagination //customer_id 
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
$aRow =  $order->order_display($sTable, $aColumns, $sWhere, $sLimit, $sOrder);
/* Data set length after filtering */
$sQuery = "SELECT FOUND_ROWS()";
$rResultFilterTotal = $db->query($sQuery, PDO::FETCH_ASSOC);
$aResultFilterTotal = $db->result($rResultFilterTotal);
$iFilteredTotal = $aResultFilterTotal[0]['FOUND_ROWS()'];

/* Total data set length */
$sQuery = $db->query("SELECT * FROM " . $db->tbl_pre . "orders_tbl");
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
		if ($aColumns[$i] != ' ') {
			$row[] = repc($aRow[$j][$i]);
		}
	}
	$output['aaData'][] = $row;
}
echo json_encode($output);
?>