<?php

include "../../includes/settings.php";
include "../../includes/class_call_one_file.php";


             

   $product_array = $Product->Product_display($db->tbl_pre . "product_tbl", array(), "WHERE Product_status='Active'");
   echo "<option value='' >Select Product</option>";
 
  if (count($product_array)>0) {  
  for ($i=0; $i <count($product_array) ; $i++) { 
   echo "<option value=".$product_array[$i]["product_id"]." >".$product_array[$i]["style_no"]." ".$product_array[$i]["product_name"]."</option>";
  }
}
 
    

   
?>