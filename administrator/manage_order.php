<?php
include "includes/session.php";
$url = basename(__FILE__) . "?" . (isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : 'cc=cc');
$_SESSION['product_size_manage_url'] = $url;
// Manage Delete //
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
	$order->order_delete('manage_order.php');
}
// Manage Status //
 
include "includes/header.php";
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Manage Product Order
		</h1>
		<ol class="breadcrumb">
			<li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Manage Product Order</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-primary">
					<div class="box-body">
						<?php echo $_SESSION['order_msg'];
$_SESSION['order_msg'] = ""; ?>
					</div>
					<div class="box-body table-responsive">
						<table class="table table-bordered table-hover" id="example">
							<thead>
								<tr>
									<th>ID</th>									
									<th>Customer Name</th>
									<th>Order No</th>
									<th>Order Date</th>
									<th>Total Amount</th>
									<th>Status</th>
									<th>Option</th>
								</tr>
							</thead>
						</table>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div>
		</div>
	</section><!-- /.content -->
</div><!-- /.content-wrapper -->
<div id="divToPrint" style="display: none;">


</div>

<?php include "includes/footer.php";?>


   <div class="modal fade" id="order_status" role="dialog">
    <div class="modal-dialog modal-sm">
    <form id="frm_order_status">
    	<input type="hidden" name="order_id" id="order_id" value="">
    	<input type="hidden" name="order_no" id="order_no" value="">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header modal-header-primary">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Change order status</h4>
        </div>
        <div class="modal-body">
				<div class="form-group">		
		<div class="col-sm-12">
			<select  class="form-control" name="order_status" id="order_status" >
				<option value="Ordered">Ordered</option>
				<option value="Delivered">Delivered</option> 
				<option value="Close">Close</option>
				
			</select>
		</div>
	</div>
       
 

        </div>
        <div class="modal-footer">
        <button type="submit" class="btn btn-success order_status"  >Save</button>	
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      </form>
    </div>
  </div>




  <div class="modal fade" id="styles_pop" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
         					<div class="box-body table-responsive">
						<table class="table table-bordered table-hover" id="style_details">
							<thead>
								<tr>
									<th>ID</th>									
									<th>Customer Name</th>
									<th>Description of Goods</th>									
									<th>Order No</th>
									<th>Style No</th>
									<th>Size</th>
									<th>PCS</th>
									<th>MRP</th>
								</tr>
							</thead>
						</table>
					</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
 
 <!-- invoice -->

   <div class="modal fade" id="order_invoice" role="dialog">
    <div class="modal-dialog modal-lg">
    <form id="frm_invoice_create">
    	<input type="hidden" name="total_row" id="total_row" value="">
    	<input type="hidden" name="order_no" id="order_no" value="">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header modal-header-primary">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Create Invoice</h4>
        </div>
        <div class="modal-body">
         					<div class="box-body table-responsive">
         						
						<table class="table table-bordered table-hover" id="invoice_create">
							<thead>
								<tr>
									<th>SL</th>									
									<th>Description</th>
									<th>Style No</th>								
									<th>Size</th>
									<th>Colour</th>
									<th>Set Ordered</th>
									<th>Set Delivered</th>
									<th>Set to be Invoiced/ Despatched</th>
									<th>Pcs</th>
									<th>MRP</th>
									<th>Disc%</th>
									<th>Discount Amount</th>
									<th>Net Rate (MRP-Discount)</th>
									<th>Amt</th>
									 
								</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
						
					</div>
        </div>
        <div class="modal-footer">
        <button type="submit" class="btn btn-success invoice_save"  >Save</button>	
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      </form>
    </div>
  </div>

  <div class="modal fade" id="order_invoices" role="dialog">
    <div class="modal-dialog ">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Order Invoices</h4>
        </div>
        <div class="modal-body">
<div class="container col-md-12"> 
	<div id="invoices_row" class="row">

	</div>
</div>

             </div>
          <div class="modal-footer">
        	
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        </div>
         
      </div>
      
    </div>
  </div>