<footer class="main-footer">
  <?php echo Copyright_Text; ?>
</footer>
</div><!-- ./wrapper -->

<!-- jQuery 2.1.4 -->
<script src="plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<!-- Select2 -->
<script src="plugins/select2/select2.full.min.js" type="text/javascript"></script>
<!-- DATA TABES SCRIPT -->
<script src="plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
<!-- SlimScroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.js" type="text/javascript"></script>
<!-- Sparkline -->
<script src="plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
<!-- jvectormap -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
<!-- SlimScroll 1.3.0 -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<!-- ChartJS 1.0.1 -->
<script src="plugins/chartjs/Chart.min.js" type="text/javascript"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js" type="text/javascript"></script>
<!-- Validation JS -->
<script src="dist/js/jquery.validationEngine.js"></script>
<script src="dist/js/jquery.validationEngine-en.js"></script>
<script src="dist/js/jquery-ui.js"></script>
<script src="plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="plugins/timepicker/bootstrap-timepicker.js" type="text/javascript"></script>
<link href="dist/css/imageuploadify.min.css" rel="stylesheet">
<script type="text/javascript" src="dist/js/imageuploadify.min.js"></script>
<script type="text/javascript" src="dist/js/jquery.bootstrap-touchspin.min.js"></script>

<script type="text/javascript">
  function change_pricing_type(typevalue){
    if(typevalue=='Single Family'){
      $("#pricing_square_footage").removeAttr('disabled');
    }
    if(typevalue=='Multi Family'){
      $("#pricing_square_footage").attr('disabled','true');
    }
  }
  function display_slot(appointslottype,appointdate,zipcodeid){
    $.ajax({
      type: "POST",
      url: "ajax/ajax.php",
      data: "appointdate=" + appointdate + "&appointslottype=" + appointslottype + "&zipcodeid=" + zipcodeid,
      success: function(html) {
        $("#appsloid").html(html).show();
      }
    });
  }
  function display_appointment_price(customer_address_type){
    $.ajax({
      type: "POST",
      url: "ajax/ajax.php",
      data: "customer_address_type=" + customer_address_type,
      success: function(html) {
        $("#appuniid").html(html).show();
      }
    });
  }
  $(function(){
    jQuery(".form-horizontal").validationEngine('attach', {
      relative: true,
      overflownDIV:"#divOverflown",
      promptPosition:"topLeft"
    });
    $(".select2").select2();
    $(".datepicker").datepicker({
      format: "yyyy-mm-dd",
      startDate: new Date(),
      autoclose: true
    });

 <?php  if ($page_name == 'add_product_stock.php') { ?>

var i=Number(jQuery('#item').val());

   $("#add_row").click(function(){
    Getproduct(i);

    $('#addr'+i).html("<td> "+ (i) +"</td> <td> <select data-id='"+i+"' width='10%' name='product_id"+i+"' id='product_id"+i+"' class='form-control product_id' data-validation-engine='validate[required]'></select> </td> <td> <input  name='qty"+i+"' type='text' id='qty"+i+"' data-id='"+i+"' data-validation-engine='validate[required]'  class='form-control input-sm qty numeric'>  </td>  <td>  <input  name='rate"+i+"' type='text' id='rate"+i+"' readonly data-id='"+i+"' width='auto'    class='form-control input-md '> </td> <td><input  name='total"+i+"' type='text' id='total"+i+"' data-id='"+i+"' width='auto' readonly   class='form-control input-md total numeric'> </td>    ><td><a href='javascript:void(0);'  class='remove'><span class='glyphicon glyphicon-remove'></span></a> </td>");

    $('#tab_logic').append('<tr class="xx" id="addr'+(i+1)+'"></tr>');
      i++; 
       jQuery('#item').val(i);

    jQuery(".form-horizontal").validationEngine('attach', {
      relative: true,
      overflownDIV:"#divOverflown",
      promptPosition:"topLeft"
    });

       
          $('.datepicker').datepicker({
    format: 'dd-mm-yyyy',
    todayHighlight:'TRUE',
    autoclose: true,
})


});

        $(document).on('click', '.remove', function() {
         var trIndex = $(this).closest("tr").index();
            if(trIndex>0) {
             $(this).closest("tr").remove();
              console.log(totalcal());
             console.log(inWords());
           } else {
             alert("Sorry Can't remove first row!");              
           }
      });

            function Getproduct(i)
     {
   $.ajax({
     type: 'post',
     url: 'php/fetch_product.php',
     success: function (response) {
       document.getElementById("product_id"+i+"").innerHTML=response; 
       $("select").select2();
     }
   });
}

 $(document).on('change','.product_id',function(){
 var row= $(this).attr("data-id");
 var product_id= this.value; 

   $.ajax({
     type: 'post',
     data: {  product_id:product_id },
     url: 'php/fetch_product_dtls.php',
     dataType: "json",
     success: function (value) {
if (value.status==true) {
  jQuery("#rate"+row+"").val(value.mrp);
}
  rowcal(row);
totalcalcu();
     }
   });
}); 

 $(document).on('keyup','.qty',function(){
  var row= $(this).attr("data-id");  
  rowcal(row);
totalcalcu();
 
  });

var rowcal= function(row){
  var qty= Number($("#qty"+row+"").val());
var mrp =  Number($("#rate"+row+"").val());  
 var total= qty*mrp; 
total =Number(total.toFixed(2));
$("#total"+row+"").val(total);
}

var totalcalcu= function () { 
var tot=0;   qty= 0;  
 

  $('.qty').each(function(){
qty= Number(qty) + Number(this.value); 
});

    $('.total').each(function(){
tot= Number(tot) + Number(this.value); 
});
 
 

$('#tot_qty').val(qty);
$('#tot_amt').val(tot);
 
}



 <?php  } if ($page_name == 'manage_product_category.php') {  ?>

     jQuery('#example').dataTable( {
      "processing": true,
      "serverSide": true,
      "iDisplayLength": <?php echo Pagination_Number; ?>,
      "sAjaxSource": "ajax/product_category.php",
      "order": [[ 1, "asc" ]],
      "aoColumnDefs": [
      {
       "bSortable": false,
       "aTargets": [ 3 ] ,
       "mData": "download_link",
       "mRender": function ( data, type, full ) {
        if(full[2]=='Inactive'){
         var atbu='inactive';
       }
       return '<a href="add_product_category.php?category_id='+full[0]+'&action=edit" title="Edit"><i class="fa fa-fw fa-edit"></i></a><a href="javascript:status_update('+full[0]+',\''+full[2]+'\',\'manage_product_category.php\')" title="Change Status"><i class="fa fa-fw fa-lightbulb-o '+atbu+'"></i></a><a href="javascript:del('+full[0]+',\'manage_product_category.php\',\'Size\')" title="Delete"><i class="fa fa-fw fa-close"></i></a>';
     }
   },
   {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            }
   ]

 } );
     <?php
}
if ($page_name == 'manage_product_group.php') {
	?>
     jQuery('#example').dataTable( {
      "processing": true,
      "serverSide": true,
      "iDisplayLength": <?php echo Pagination_Number; ?>,
      "sAjaxSource": "ajax/product_group.php",
      "order": [[ 1, "asc" ]],
      "aoColumnDefs": [
      {
       "bSortable": false,
       "aTargets": [ 5 ] ,
       "mData": "download_link",
       "mRender": function ( data, type, full ) {
        if(full[4]=='Inactive'){
         var atbu='inactive';
       }
       return '<a href="add_product_group.php?product_group_id='+full[0]+'&action=edit" title="Edit"><i class="fa fa-fw fa-edit"></i></a><a href="javascript:status_update('+full[0]+',\''+full[4]+'\',\'manage_product_group.php\')" title="Change Status"><i class="fa fa-fw fa-lightbulb-o '+atbu+'"></i></a><a href="javascript:del('+full[0]+',\'manage_product_group.php\',\'Franchise\')" title="Delete"><i class="fa fa-fw fa-close"></i></a>';
     }
   },
   {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            }
   ]

 } );
     <?php
}



if ($page_name == 'manage_product_stock.php') {
  ?>
     jQuery('#example').dataTable( {
      "processing": true,
      "serverSide": true,
      "iDisplayLength": <?php echo Pagination_Number; ?>,
      "sAjaxSource": "ajax/product_stock.php",
      "order": [[ 1, "asc" ]],
      "aoColumnDefs": [
      {
       "bSortable": false,
       "aTargets": [ 4 ] ,
       "mData": "download_link",
       "mRender": function ( data, type, full ) {
        if(full[3]=='Inactive'){
         var atbu='inactive';
       }
       return '<a href="add_product_stock.php?bill_id='+full[0]+'&action=edit" title="Edit"><i class="fa fa-fw fa-edit"></i></a> <a href="javascript:del('+full[0]+',\'manage_product_stock.php\',\'product stock\')" title="Delete"><i class="fa fa-fw fa-close"></i></a>';
     }
   },
   {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            }
   ]

 } );
     <?php
}


if ($page_name == 'manage_customer.php') {
	?>
     jQuery('#example').dataTable( {
      "processing": true,
      "serverSide": true,
      "iDisplayLength": <?php echo Pagination_Number; ?>,
      "sAjaxSource": "ajax/customer.php",
      "order": [[ 1, "asc" ]],
      "aoColumnDefs": [
      {
       "bSortable": false,
       "aTargets": [ 5 ] ,
       "mData": "download_link",
       "mRender": function ( data, type, full ) {
        if(full[4]=='Inactive'){
         var atbu='inactive';
       }
       return '<a href="add_customer.php?customer_id='+full[0]+'&action=edit" title="Edit"><i class="fa fa-fw fa-edit"></i></a><a href="javascript:status_update('+full[0]+',\''+full[4]+'\',\'manage_customer.php\')" title="Change Status"><i class="fa fa-fw fa-lightbulb-o '+atbu+'"></i></a><a href="javascript:del('+full[0]+',\'manage_customer.php\',\'Franchise\')" title="Delete"><i class="fa fa-fw fa-close"></i></a>';
     }
   },
   {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            }
   ]

 } );
     <?php
}

if ($page_name == 'manage_product_size.php') {
  ?>
     jQuery('#example').dataTable( {
      "processing": true,
      "serverSide": true,
      "iDisplayLength": <?php echo Pagination_Number; ?>,
      "sAjaxSource": "ajax/product_size.php",
      "order": [[ 1, "asc" ]],
      "aoColumnDefs": [
      {
       "bSortable": false,
       "aTargets": [ 3 ] ,
       "mData": "download_link",
       "mRender": function ( data, type, full ) {
        if(full[2]=='Inactive'){
         var atbu='inactive';
       }
       return '<a href="add_product_size.php?product_size_id='+full[0]+'&action=edit" title="Edit"><i class="fa fa-fw fa-edit"></i></a><a href="javascript:status_update('+full[0]+',\''+full[2]+'\',\'manage_product_size.php\')" title="Change Status"><i class="fa fa-fw fa-lightbulb-o '+atbu+'"></i></a><a href="javascript:del('+full[0]+',\'manage_product_size.php\',\'Size\')" title="Delete"><i class="fa fa-fw fa-close"></i></a>';
     }
   },
   {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            }
   ]

 } );
     <?php
}  

if ($page_name == 'manage_product_color.php') {
  ?>
     jQuery('#example').dataTable( {
      "processing": true,
      "serverSide": true,
      "iDisplayLength": <?php echo Pagination_Number; ?>,
      "sAjaxSource": "ajax/product_color.php",
      "order": [[ 1, "asc" ]],
      "aoColumnDefs": [
      {
       "bSortable": false,
       "aTargets": [ 3 ] ,
       "mData": "download_link",
       "mRender": function ( data, type, full ) {
        if(full[2]=='Inactive'){
         var atbu='inactive';
       }
       return '<a href="add_product_color.php?product_color_id='+full[0]+'&action=edit" title="Edit"><i class="fa fa-fw fa-edit"></i></a><a href="javascript:status_update('+full[0]+',\''+full[2]+'\',\'manage_product_color.php\')" title="Change Status"><i class="fa fa-fw fa-lightbulb-o '+atbu+'"></i></a><a href="javascript:del('+full[0]+',\'manage_product_color.php\',\'Color\')" title="Delete"><i class="fa fa-fw fa-close"></i></a>';
     }
   },
   {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            }
   ]

 } );
     <?php
}

if ($page_name == 'manage_customer_category.php') {
  ?>
     jQuery('#example').dataTable( {
      "processing": true,
      "serverSide": true,
      "iDisplayLength": <?php echo Pagination_Number; ?>,
      "sAjaxSource": "ajax/customer_category.php",
      "order": [[ 1, "asc" ]],
      "aoColumnDefs": [
      {
       "bSortable": false,
       "aTargets": [ 4 ] ,
       "mData": "download_link",
       "mRender": function ( data, type, full ) {
        if(full[3]=='Inactive'){
         var atbu='inactive';
       }
       return '<a href="add_customer_category.php?category_id='+full[0]+'&action=edit" title="Edit"><i class="fa fa-fw fa-edit"></i></a><a href="javascript:status_update('+full[0]+',\''+full[2]+'\',\'manage_customer_category.php\')" title="Change Status"><i class="fa fa-fw fa-lightbulb-o '+atbu+'"></i></a><a href="javascript:del('+full[0]+',\'manage_customer_category.php\',\'customer_category\')" title="Delete"><i class="fa fa-fw fa-close"></i></a>';
     }
   },
   {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            }
   ]

 } );
     <?php
}

if ($page_name == 'manage_product_image.php') {
  ?>
     jQuery('#example').dataTable( {
      "processing": true,
      "serverSide": true,
      "iDisplayLength": <?php echo Pagination_Number; ?>,
      "sAjaxSource": "ajax/product_image.php",
      "order": [[ 1, "asc" ]],
      "aoColumnDefs": [
      {
       "bSortable": false,
       "aTargets": [ 4 ] ,
       "mData": "download_link",
       "mRender": function ( data, type, full ) {
 
       return '<a href="add_product_image.php?color_image_id='+full[0]+'&action=edit" title="Edit"><i class="fa fa-fw fa-edit"></i></a> <a href="javascript:del('+full[0]+',\'manage_product_image.php\',\'manage_product_image\')" title="Delete"><i class="fa fa-fw fa-close"></i></a>';
     }
   },
   {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            }
   ]

 } );
     <?php
}

if ($page_name == 'manage_product.php') {
  ?>
     jQuery('#example').dataTable( {
      "processing": true,
      "serverSide": true,
      "iDisplayLength": <?php echo Pagination_Number; ?>,
      "sAjaxSource": "ajax/product.php",
      "order": [[ 1, "asc" ]],
      "aoColumnDefs": [
      {
       "bSortable": false,
       "aTargets": [ 5 ] ,
       "mData": "download_link",
       "mRender": function ( data, type, full ) {
        if(full[4]=='Inactive'){
         var atbu='inactive';
       }
       return '<a href="add_product.php?Product_id='+full[0]+'&action=edit" title="Edit"><i class="fa fa-fw fa-edit"></i></a><a href="javascript:status_update('+full[0]+',\''+full[2]+'\',\'manage_product.php\')" title="Change Status"><i class="fa fa-fw fa-lightbulb-o '+atbu+'"></i></a><a href="javascript:del('+full[0]+',\'manage_product.php\',\'product\')" title="Delete"><i class="fa fa-fw fa-close"></i></a>';
     }
   },
   {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            }
   ]

 } );
     <?php
}


if ($page_name == 'manage_product_style.php') {
  ?>
     jQuery('#example').dataTable( {
      "processing": true,
      "serverSide": true,
      "iDisplayLength": <?php echo Pagination_Number; ?>,
      "sAjaxSource": "ajax/product_style.php",
      "order": [[ 1, "asc" ]],
      "aoColumnDefs": [
      {
       "bSortable": false,
       "aTargets": [ 6 ] ,
       "mData": "download_link",
       "mRender": function ( data, type, full ) {

       return '<a href="add_product_style.php?product_details_id='+full[0]+'&action=edit" title="Edit"><i class="fa fa-fw fa-edit"></i></a><a href="javascript:del('+full[0]+',\'manage_product_style.php\',\'product\')" title="Delete"><i class="fa fa-fw fa-close"></i></a>';
     }
   },
   {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            }
   ]

 } );
     <?php
}

if ($page_name == 'manage_notification.php') {
  ?>
     jQuery('#example').dataTable( {
      "processing": true,
      "serverSide": true,
      "iDisplayLength": <?php echo Pagination_Number; ?>,
      "sAjaxSource": "ajax/notification.php",
      "order": [[ 1, "asc" ]],
      "aoColumnDefs": [
      {
       "bSortable": false,
       "aTargets": [ 5 ] ,
       "mData": "download_link",
       "mRender": function ( data, type, full ) {
        if(full[4]=='Inactive'){
         var atbu='inactive';
       }
       return '<a href="add_notification.php?notification_id='+full[0]+'&action=edit" title="Edit"><i class="fa fa-fw fa-edit"></i></a><a href="javascript:status_update('+full[0]+',\''+full[4]+'\',\'manage_notification.php\')" title="Change Status"><i class="fa fa-fw fa-lightbulb-o '+atbu+'"></i></a><a href="javascript:del('+full[0]+',\'manage_notification.php\',\'Notification\')" title="Delete"><i class="fa fa-fw fa-close"></i></a>';
     }
   },
   {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            }
   ]

 } );
     <?php
}


if ($page_name == 'manage_order.php') {
  ?>
  var table = jQuery('#example');
        var dataTable =  table.dataTable( {
      "processing": true,
      "serverSide": true,
      "iDisplayLength": <?php echo Pagination_Number; ?>,
      "sAjaxSource": "ajax/product_order.php",
      "order": [[ 3, "desc" ]],
      "stripeClasses": [ 'success', 'info' ],
      "aoColumnDefs": [
      {
       "bSortable": false,
       "aTargets": [ 6 ] ,
       "mData": "download_link",
       "mRender": function ( data, type, full ) {
        if(full[2]=='Inactive'){
         var atbu='inactive';
       }
       return '<a href="javascript:invoice_order('+full[0]+',\''+full[2]+'\',\'manage_order.php\')" title="Add Invoice"><i class="fa fa-clone '+atbu+'"></i></a> <a href="add_order.php?order_id='+full[0]+'&action=edit" title="Edit"><i class="fa fa-fw fa-edit"></i></a> <a href="javascript:view_order_details('+full[0]+',\''+full[2]+'\',\'manage_order.php\')" title="View Details"><i class="fa fa-fw fa-eye '+atbu+'"></i></a> <a href="javascript:del('+full[0]+',\'manage_order.php\',\'Order\')" title="Delete"><i class="fa fa-fw fa-close"></i></a>';
     }
   },
   {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            }
   ]

 } );


       $('#example tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    } );
 
    // DataTable
    var table = $('#example').DataTable();
 
    // Apply the search
    table.columns().every( function () {
        var that = this;
 
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );
     <?php
}


if ($page_name == 'manage_sequence.php') {
	?>
     jQuery('#example').dataTable( {
      "processing": true,
      "serverSide": true,
      "iDisplayLength": <?php echo Pagination_Number; ?>,
      "sAjaxSource": "ajax/sequence.php",
      "order": [[ 1, "desc" ]],
      "aoColumnDefs": [
      {
       "bSortable": false,
       "aTargets": [ 11 ] ,
       "mData": "download_link",
       "mRender": function ( data, type, full ) {
        return '<a href="add_sequence.php?sequence_id='+full[0]+'&action=edit" title="Edit"><i class="fa fa-fw fa-edit"></i></a><a href="javascript:del('+full[0]+',\'manage_sequence.php\',\'Sequence\')" title="Delete"><i class="fa fa-fw fa-close"></i></a>';
      }
    }
    ]

  } );
     <?php
}
 
if ($page_name == 'manage_static_page.php') {
	?>
     jQuery('#example').dataTable( {
      "processing": true,
      "serverSide": true,
      "iDisplayLength": <?php echo Pagination_Number; ?>,
      "sAjaxSource": "ajax/static_page.php",
      "order": [[ 1, "asc" ]],
      "aoColumnDefs": [
      {
       "bSortable": false,
       "aTargets": [ 5 ] ,
       "mData": "download_link",
       "mRender": function ( data, type, full ) {
        return '<a href="add_static_page.php?static_page_id='+full[0]+'&action=edit" title="Edit"><i class="fa fa-fw fa-edit"></i></a>';
      }
    }
    ]

  } );
     <?php
}
?>
 });
function del(aa,bb,cc) {
  var a = confirm("Are you sure, you want to delete this " + cc + "?");
  if (a) {
    location.href = bb + "?cid=" + aa + "&action=delete";
  }
}
function del1(aa,bb,cc) {
  bs=aa.replace(/\b0+/g, "");
  var a = confirm("Are you sure, you want to delete this " + cc + "?");
  if (a) {
    location.href = bb + "?cid=" + bs + "&action=delete";
  }
}
function status_update(aa, bb, cc) {
  location.href = cc + "?cid=" + aa + "&action=status&current_status=" + bb;
}


function invoice_order(aa, bb, cc){
   $("#order_invoice").modal();

  jQuery.ajax({
  type: "POST",
  url: "php/fetch_order_invoice.php",
  data: {order_no: bb},
  dataType: "json"
  }).done(function(value) {
    if (value.status==true) {

/*  jQuery('#flat_id').val(value.flat_id);
  jQuery('#flat_name').val(value.flat_name);
  jQuery('#flat_size').val(value.flat_size);
  jQuery('#amount_due').val(value.amount_due);*/
  

}else{
  alert(value.msg);
}

  });
}

function view_order_details(aa, bb, cc) {
        $("#styles_pop").modal();
  
  var javascriptVariable = bb;
  //alert(javascriptVariable);
     jQuery('#style_details').dataTable( {
      "filter": false,
      "destroy": true,
      "processing": true,
      "serverSide": true,
      "iDisplayLength": <?php echo Pagination_Number; ?>,
      "sAjaxSource": "ajax/product_order_details.php?orderno="+javascriptVariable+" ",
      "order": [[ 1, "asc" ]],
      "aoColumnDefs": [
      {
       "bSortable": false,
       "aTargets": [ 7 ] ,
       
 
    },
   {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            }
    ]

  } ); 

 

    } 


$(document).ready(function () {

    //var next = $('#item').val();
    var next=Number(jQuery('#item').val());
    $("#add-more").click(function(e){
        e.preventDefault();
        var addto = "#field" + next;
        var addRemove = "#field" + (next);
        next = next + 1;
        var newIn = ' <!-- Text input--><div id="field'+ next +'" name="field'+ next +'"> <!-- Text input--><div class="form-group"> <label class="col-md-4 control-label" for="image_text">Image Text</label> <div class="col-md-5"> <input id="image_text" name="image_text'+ next +'" type="text" placeholder="" class="form-control input-md"> </div></div><!-- File Button --> <div class="form-group"> <label class="col-md-4 control-label" for="style_image">Image</label> <div class="col-md-4"> <input id="style_image" name="style_image'+ next +'" class="input-file" type="file"> </div></div></div>';
        var newInput = $(newIn);
        var removeBtn = '<button id="remove' + (next - 1) + '" class="btn btn-danger remove-me" >Remove</button></div></div><div id="field">';
        var removeButton = $(removeBtn);
        $(addto).after(newInput);
        $(addRemove).after(removeButton);
        $("#field" + next).attr('data-source',$(addto).attr('data-source'));
        $("#item").val(next);  
        
            $('.remove-me').click(function(e){
                e.preventDefault();
                var fieldNum = this.id.charAt(this.id.length-1);
                var fieldID = "#field" + fieldNum;
                $(this).remove();
                $(fieldID).remove();
            });
    });

});

<?php if ($page_name == 'add_product.php') { ?>

$('#category_id').on('change', function() {
  var id= (this.value );
     $.ajax({
      url: "php/get_product_group.php",
      type: "post",
      data: { id: id },
     success: function (response) {
       document.getElementById("group_id").innerHTML=response; 
        
       $("#group_id").select2();
     }

    });
})
<?php } ?> 

  function remove_product_images(file_nm,id){
    $.ajax({
      url: "php/product_remove_file.php",
      type: "post",
      data: { file: file_nm, id: id },
      success: function(data){
        console.log(data);
        if(!data.error){
          $("#"+id).remove();
        }
      }
    });
  }

    function remove_product_color_images(file_nm,id){
    $.ajax({
      url: "php/product_color_remove_file.php",
      type: "post",
      data: { file: file_nm, id: id },
      success: function(data){     
        console.log(data);
        if(!data.error){
          $("#"+id).remove();
        }
      }
    });
  }
  $(document).on( "change", "input[name=preferred_courier_service]", function() {
//  $("input[name='preferred_courier_service']").click(function() {
    //$("input[name=preferred_courier_service]").on( "change", function() {

         var test = $(this).val();
         alert(test);
         if (test=='other-cour') {         
         $("#other_corir").show();
       }else{
        $("#other_corir").hide();
       }
    } );
</script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js" type="text/javascript"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%'
    });
        $(".set_qty").TouchSpin({

      min: 0

    });
  });
  $(document).on('keyup change','.set_qty',function(){
  var row=  $(this).attr("data-id").split("_")
 
  var set_qty =Number($("#set_"+row[0]+"_"+row[1]+"").val());
  var Pcs= $("#style_set_qty_"+row[0]+"_"+row[1]+"").val();
  var style_mrp= $("#style_mrp_for_size"+row[0]+"_"+row[1]+"").val();
  var stock_in_hand=Number($("#stock_in_hand"+row[0]+"_"+row[1]+"").val());
   var discount= $("#discount_percent").val();
if(set_qty<=stock_in_hand){
  var total= style_mrp*set_qty*Pcs; 
  if (discount>0) {
total=total*discount/100; 
  }   
  total =Number(total.toFixed(2));
   //alert(total);
  $("#amt_"+row[0]+"_"+row[1]+"").html(total);
  $("#amount_"+row[0]+"_"+row[1]+"").val(total);

   var piece =Pcs*set_qty; 

   $("#piece"+row[0]+"_"+row[1]+"").val(piece);
    $("#set_piece_"+row[0]+"_"+row[1]+"").html(piece);
  
}
else{
  $("#set_"+row[0]+"_"+row[1]+"").val(stock_in_hand);
  alert('The style is out of stock, Available stock is :'+stock_in_hand+''); 
}

 console.log(totalcal());

  });
  var totalcal= function () { 
 var total_amount=0;
 $('.amount').each(function(){
total_amount= Number(total_amount) + Number(this.value);     
});
   $("#total_bill_amount").val(total_amount);
  }

</script>
<script src="plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
<script src="ckfinder/ckfinder.js" type="text/javascript"></script>
<script type="text/javascript">
//$(document).ready(function() {
 

//});
  $(function () {
    //CKEDITOR.plugins.addExternal( 'youtube', '/SAC/CKEDITORPLUGIN/youtube/', 'plugin.js' );
    CKFinder.setupCKEditor();
  });

   $('.datepicker').datepicker({
    format: 'dd-mm-yyyy',
    todayHighlight:'TRUE',
    autoclose: true,
})
</script>

<!-- <script type="text/javascript">
$(document).ready(function(){
    $('#country').on('change',function(){
        var countryID = $(this).val();
        if(countryID){
            $.ajax({
                type:'POST',
                url:'ajaxData.php',
                data:'country_id='+countryID,
                success:function(html){
                    $('#state').html(html);
                    $('#city').html('<option value="">Select state first</option>'); 
                }
            }); 
        }else{
            $('#state').html('<option value="">Select country first</option>');
            $('#city').html('<option value="">Select state first</option>'); 
        }
    });
    

});
</script> -->

        <script type="text/javascript">
            $(document).ready(function() {
               // $('input[type="file"]').imageuploadify();
            })
        </script>

</body>
</html>