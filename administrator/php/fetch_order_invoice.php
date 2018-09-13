<?php
include "../../includes/settings.php";
include "../../includes/class_call_one_file.php";



             

"SELECT 'hsn' AS hsn,`pt`.`product_name`,`pt`.`style_no`,`pst`.`size_description`,`pt`.`style_color_qty`,`ort`.`total_set`, 0 AS set_delevered,`ort`.`piece`, `ort`.`mrp`,`ortm`.`discount_percent`, ort.product_id, pdt.stock_in_hand FROM babygodb_order_master ortm, babygodb_orders_tbl ort, babygodb_product_details_tbl pdt, babygodb_product_size_tbl pst, babygodb_product_tbl pt WHERE ort.product_id=pt.product_id and ort.product_details_id=pdt.product_details_id and pdt.size_id=pst.product_size_id and ort.product_id=pt.product_id and ort.generate_no='BBGO/O/0015/18-19' and ortm.generate_no='BBGO/O/0015/18-19' "
 
    

   
?>