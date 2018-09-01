<?php
include "includes/session.php";
$bill_id = isset($_REQUEST['bill_id']) ? $_REQUEST['bill_id'] : 0;
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'add';
 
if ($_REQUEST['submit'] == 'Submit') {
 
   $bill_no = $_REQUEST['bill_no']; 
   $bill_date = date('Y-m-d',strtotime($_POST['bill_date']));  
   $misc = $_REQUEST['misc']; 
 
} else {
  $bill_no = '';
}


if ($_REQUEST['submit'] == 'Submit') {

 

  $name_value = array(  'bill_no' => rep($bill_no),'bill_date' => $bill_date,'misc' => rep($misc) );
  // purchase Add //
  if ($action == "add") {
    $purchase->purchase_add($name_value, "Product stock added successfully. Please enter another.", "Sorry, nothing is added.", "Sorry, Bill No name is already added. Please use another Bill no..");
     $purchase_array[0]["document_type_id"]=1;
  }
  // purchase Edit //
  elseif ($action == "edit") {
    $purchase->purchase_edit($name_value, $bill_id, "Product stock updated successfully.", "Sorry, nothing is updated.", "Sorry, Product type is already added. Please use another Bill no.");
      
  }
}
// Show Value When Try To Update purchase //
elseif ($action == "edit") {
  $purchase_array = $purchase->purchase_display($db->tbl_pre .  'purchase_bill_master', array(), "WHERE bill_id=" . $bill_id . "");
  $purchase_tans_array = $purchase->purchase_display($db->tbl_pre .'purchase_bill_transaction', array(), "WHERE bill_id=" . $bill_id . "");

} 

 
//print_r($company_details);
include "includes/header.php";
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
        Product Stock
    </h1>
    <ol class="breadcrumb">
      <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><?php echo $action == 'add' ? 'New' : 'Edit'; ?> Product Stock</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title"><?php echo $action == 'add' ? 'New' : 'Edit'; ?> Product Stock</h3>
          </div><!-- /.box-header -->
          <!-- form start -->
          <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" method="post" enctype="multipart/form-data">  
            <input type="hidden" name="action" id="action" value="<?php echo $action; ?>" />
            <input type="hidden" name="bill_id" id="bill_id" value="<?php echo $bill_id; ?>" />
            <?php if ($action=="edit") { ?>
            <input type="hidden" name="item" id="item" value="<?php echo count($purchase_tans_array)+1; ?>" > 
            <?php } else { ?>
            <input type="hidden" name="item" id="item" value="2" >
            <?php } ?>
            <div class="box-body">
      <?php echo $_SESSION['purchase_msg']; $_SESSION['purchase_msg'] = "";       ?>

 
            <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">  Bill No:</label>

                              <div class="col-sm-4">
                                <input id="bill_no" name="bill_no" class="form-control round-form" data-validation-engine="validate[required]" value="<?php echo $purchase_array[0]["bill_no"] ?>"  type="text"    >
                              </div>

                            <label class="col-sm-2 col-sm-2 control-label">Date:</label>
                            <div class="col-xs-4"> 
                              <div class="input-group date" >
                              <?php if ($action=="edit") { ?>
                                 <input type="text" name="bill_date" value="<?php echo date('d-m-Y',strtotime($purchase_array[0]["bill_date"]))  ?>" data-validation-engine="validate[required]" class="form-control datepicker">
                              <?php } else {?>
                                <input type="text" name="bill_date"  data-validation-engine="validate[required]" class="form-control datepicker">
                                 <?php } ?>
                                <div class="input-group-addon">
                                  <span class="glyphicon glyphicon-th"></span>
                                </div>
                              </div>
                            </div>

              </div>

 

 




                          <div class="form-group">

    <div class="">
        <div class="table-responsive">
       

            <table class="table table-bordered table-hover" id="tab_logic">
                <thead>
                    <tr >
                        <th class="text-center">#</th>
                        <th class="text-center">
                            DESCRIPTION 
                        </th>
                        <th class="text-center">
                           Qty
                        </th>
                        <th class="text-center">
                           Price
                        </th>
                         
                        <th class="text-center">
                            Total
                        </th>
                         
                        <th><a href="javascript:void(0);" style="font-size:18px;" id="add_row" title="Add More "><span class="glyphicon glyphicon-plus"></span></a>

                        </th>

                        </tr>

                </thead>

                

                <?php if($action == "edit"){
//print_r($purchase_tans_array);
                 ?>

                 <tbody>

                 <?php
                 $k=0;   $tot_qty=0; $tot_total=0;
                  for($i=0;$i<count($purchase_tans_array); $i++){ 
                    $k=$k+1;
                     $tot_qty=$tot_qty + $purchase_tans_array[$i]["qty"];
                     $tot_total=$tot_total + $purchase_tans_array[$i]["total"];
                    
                  ?>

                    <tr id='addr<?php echo $k; ?>'>

        <td><?php echo $k; ?></td>
<td> <select data-id='<?php echo $k; ?>' width='15%' name='product_id<?php echo $k; ?>' id='product_id<?php echo $k; ?>' class='form-control product_id select2' data-validation-engine="validate[required]">
<option value="">Select Product</option>
 <?php
  $product_array = $Product->Product_display($db->tbl_pre . "product_tbl", array(), "WHERE Product_status='Active'");
 
  if (count($product_array)>0) {  
  for ($p=0; $p <count($product_array) ; $p++) {  ?>
   
   <option value="<?php echo $product_array[$p]["product_id"]?>" <?php echo $purchase_tans_array[$i]["product_id"] == $product_array[$p]['product_id'] ? 'selected="selected"' : ''; ?> ><?php echo $product_array[$p]["product_name"]; ?></option>"

 <?php }
}
  

 ?>

</select> </td> 
 
<td> <input  name='qty<?php echo $k; ?>' type='text' id='qty<?php echo $k; ?>' data-id='<?php echo $k; ?>' data-validation-engine="validate[required]"  value="<?php echo abs($purchase_tans_array[$i]["qty"]); ?>" class='form-control input-sm qty numeric'>  </td>
<td><input  name='rate<?php echo $k; ?>' type='text' id='rate<?php echo $k; ?>' readonly data-id='<?php echo $k; ?>' width='auto'  value="<?php echo abs($purchase_tans_array[$i]["rate"]); ?>"   class='form-control input-md rate numeric'> </td> 
<td><input  name='total<?php echo $k; ?>' type='text' id='total<?php echo $k; ?>' data-id='<?php echo $k; ?>' width='auto'  readonly  value="<?php echo abs($purchase_tans_array[$i]["total"]); ?>"  class='form-control input-md total  '> </td> 
 <td><a href='javascript:void(0);'  class='remove'><span class='glyphicon glyphicon-remove'></span></a> </td>

                    </tr>
 <?php 
/* $total_tax=0;
$total_tax=abs($purchase_tans_array[$i]["sgst_amt"]) + abs($purchase_tans_array[$i]["cgst_amt"]) + abs($purchase_tans_array[$i]["igst_amt"]) + abs($purchase_tans_array[$i]["cess_amt"]);

 $total_sgst  = $total_sgst+abs($purchase_tans_array[$i]["sgst_amt"]);
  $total_cgst = $total_cgst+abs($purchase_tans_array[$i]["cgst_amt"]);
  $total_igst = $total_igst+abs($purchase_tans_array[$i]["igst_amt"]); 
  $total_cess = $total_cess+abs($purchase_tans_array[$i]["cess_amt"]);*/
 ?>


                    <?php } ?>

                    <tr id='addr<?php echo $k +1; ?>'></tr>

                </tbody>

                <?php } else{ ?>

                <tbody>

<tr id='addr1'><td>1</td>
<td> <select data-id='1' width='15%' name='product_id1' id='product_id1' class='form-control product_id select2' data-validation-engine="validate[required]">
<option value="">Select Product</option>
 <?php
  $product_array = $Product->Product_display($db->tbl_pre . "product_tbl", array(), "WHERE Product_status='Active'");
 
  if (count($product_array)>0) {  
  for ($i=0; $i <count($product_array) ; $i++) { 
   echo "<option value=".$product_array[$i]["product_id"]." >".$product_array[$i]["style_no"]." ".$product_array[$i]["product_name"]."</option>";
  }
}

 ?>

</select> </td>
<td> <input  name='qty1' type='text' id='qty1' data-id='1' data-validation-engine="validate[required]"  class='form-control input-sm qty numeric'>  </td>
<td><input  name='rate1' type='text' id='rate1' readonly data-id='1' width='auto'    class='form-control input-md rate numeric'> </td> 
<td><input  name='total1' type='text' id='total1' data-id='1' width='auto'  readonly   class='form-control input-md total  '> </td> 
 
 <td><a href='javascript:void(0);'  class='remove'><span class='glyphicon glyphicon-remove'></span></a> </td></tr>

                    <tr id='addr2'></tr>
                  

                </tbody>
  <?php } ?>
                <tfoot>  
                <tr>
                  <th colspan="2"> Total</th>
                  <th> <input name="tot_qty" id="tot_qty" readonly="" value="<?php echo abs($tot_qty); ?>" class="form-control input-md" type="text"> </th>
                <th   > </th>
                 <th> <input name="tot_amt" id="tot_amt" readonly="" value="<?php echo abs($tot_total); ?>" class="form-control input-md" type="text"> </th>
                 <th> </th>
                 
                <th> </th>
                </tr>
 
 
                <th> </th>
                </tr>
               
                </tfoot>

                 

            </table>
 
        </div>

    </div>

</div>
   

                     <div class="form-group">

                          <label class="col-sm-2 col-sm-2 control-label">Narration:</label>

                          <div class="col-sm-10">
                <textarea rows="5" cols="5" name="misc" class="form-control"> <?php echo $purchase_array[0]["misc"]; ?> </textarea>                              

                          </div>  
                      </div> 





            </div><!-- /.box-body -->
            <div class="box-footer">
              <button type="submit" class="btn btn-primary" name="submit" value="Submit">Submit</button>
   
            </div>
          </form>
        </div><!-- /.box -->
      </div><!--/.col (left) -->
    </div>   <!-- /.row -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php include "includes/footer.php";?>
 