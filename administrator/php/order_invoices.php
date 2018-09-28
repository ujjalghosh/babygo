<?php
include "../../includes/settings.php";
include "../../includes/class_call_one_file.php";

$order_no = $_REQUEST['order_no'];
$invoice_sql = $db->query("SELECT im.`invoice_id`, im.`invoice_no`, im.`order_no`, DATE_FORMAT(im.`invoice_date`,'%d-%m-%Y') AS invoice_date FROM `".$db->tbl_pre."invoice_master` im LEFT JOIN ".$db->tbl_pre."invoice_trns it ON it.invoice_no=im.invoice_no  WHERE `order_no` ='".$order_no."' GROUP BY im.`invoice_no`", PDO::FETCH_BOTH);
 

$charge_total= $db->total($invoice_sql); 
if($charge_total>0){
$invoice_row = $db->result($invoice_sql); 
for ($i=0; $i <count($invoice_row) ; $i++) { ?>

<div class="col-md-3"> 

<a class="print_inv" href="javascript:void(0);" data-inv="<?php echo $invoice_row[$i]['invoice_no']; ?>" data-ord="<?php echo $invoice_row[$i]['order_no']; ?>">
	<img src="<?php echo Site_URL; ?>images/pdf.jpg" alt="" width="80" height="80">
<h6><?php echo $invoice_row[$i]['invoice_date']; ?></h6>
<h5><?php echo $invoice_row[$i]['invoice_no']; ?></h5>
</a>
   <a class="delete_inv btn btn-danger btn-sm" href="javascript:void(0);" data-invoice_id="<?php echo $invoice_row[$i]['invoice_id']; ?>" >
          <span class="glyphicon glyphicon-trash"></span> Trash 
        </a>
 </div>

<?php } }else { ?>
	<div class="col-md-3"> 
		<h4>No Invoice found</h4>
	</div>
<?php } ?>