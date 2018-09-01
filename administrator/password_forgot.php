<?php
include "../includes/settings.php";
include "../includes/class_call_one_file.php";

//echo md5('Admin123');
$admin_new_password = NewGuid(7);
$db->update("administrator_tbl", array('administrator_password' => encode($admin_new_password)), "administrator_id='1'");

//$to='mbaskillassessment@gmail.com';
$to = Admin_Receiving_Email_ID;
$subject = "New Password " . Site_Title;
$mailsend->FromName = Site_Title;
$mailsend->From = Admin_Sending_Email_ID;
$mailsend->Subject = $subject;
$mailsend->IsHTML(true);
$mailsend->Body = '<p style="font:normal 14px calibri;">Dear Admin,<br><br>Your New Password is: ' . $admin_new_password . '</p>';
$mailsend->AltBody = "Alternate text";
$mailsend->AddAddress($to, 'Admin');
$mailsend->Send();
$mailsend->ClearAddresses();
$mailsend->ClearAttachments();
$_SESSION['admin_msg'] = messagedisplay("A new password will be sent to your e-mail address.", 1);
header('location:login.php');
?>