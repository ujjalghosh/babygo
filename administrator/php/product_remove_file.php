<?php 
include "../../includes/settings.php";
include "../../includes/class_call_one_file.php";
//if(isset($_POST['file'])){
	$file = '../../images/product_list/set_images/' . $_POST['file'];
	if(file_exists($file)){
		unlink($file);
		$reply=$Product->remove_file($_POST['id']);
	}else{
		$reply=array("error"=>true);
	}



	echo json_encode($reply);
//}
?>