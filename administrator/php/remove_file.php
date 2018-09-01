<?php 
if(isset($_POST['file'])){
	$file = '../../images/product/additional/' . $_POST['file'];
	if(file_exists($file)){
		unlink($file);
	}
}
?>