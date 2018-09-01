<?php
include('common_connect.php');
// json response array
$response = array("status" => FALSE);
if ( isset($_POST['customer_email']) ) {

$customer_email = $_REQUEST['customer_email'];
 

$customer_array = $customer->customer_display($db->tbl_pre . "customer_tbl", array(), "WHERE customer_email='" . $customer_email . "'");

if(count($customer_array>0)){

$message='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title> Reset password</title>
<link href="styles.css" media="all" rel="stylesheet" type="text/css" />
</head>

<body">

<table class="body-wrap">
    <tr>
        <td></td>
        <td class="container" width="600">
            <div class="content">
                <table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" itemscope itemtype="http://schema.org/ConfirmAction">
                    <tr>
                        <td class="content-wrap">
                            <meta itemprop="name" content="Confirm Email"/>
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="content-block">
                                        Please confirm your email address by clicking the link below.
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block">
                                        We may need to send you critical information about our service and it is important that we have an accurate email address.
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block" itemprop="handler"  >
                                        <a href="'.Site_Url.'reset_password.php?token='.encode($customer_array[0]["customer_email"]).'" class="btn-primary" itemprop="url">Change your Password</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block">
                                        &mdash; '.Site_Title.'
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <div class="footer">
 
                </div></div>
        </td>
        <td></td>
    </tr>
</table>

</body>
</html>';


$to_user= $customer_array[0]["customer_email"]; 
$subject_user = "Reset Password";
$headers_user = "MIME-Version: 1.0" . "\r\n";
$headers_user .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers_user .= 'From:'.Site_Title.' <'.Admin_Sending_Email_ID.'>' . "\r\n";
mail($to_user,$subject_user,$message,$headers_user);

    $response["status"] = TRUE;
    $response["msg"] = "We have sent you a link to your email to reset the password";
    echo json_encode($response);

}
else{
        $response["status"] = FALSE;
    $response["msg"] = "Please check your provided email, this email is not registered with us.";
    echo json_encode($response);
}

 
	} else {
    $response["status"] = TRUE;
    $response["msg"] = "Required parameters (customer email) is missing!";
    echo json_encode($response);
}

?>
