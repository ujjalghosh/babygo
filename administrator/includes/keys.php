<?php
/*  � 2013 eBay Inc., All Rights Reserved */ 
/* Licensed under CDDL 1.0 -  http://opensource.org/licenses/cddl1.php */
    //show all errors
error_reporting(E_ALL);

    // these keys can be obtained by registering at http://developer.ebay.com

    $production         = true;   // toggle to true if going against production
    $compatabilityLevel = 717;    // eBay API version
    
    if ($production) {
        $devID = Ebay_Dev_ID;   // these prod keys are different from sandbox keys
        $appID = Ebay_App_ID;
        $certID = Ebay_Cert_ID;
        //set the Server to use (Sandbox or Production)
        $serverUrl = 'https://api.ebay.com/ws/api.dll';      // server URL different for prod and sandbox
        //the token representing the eBay user to assign the call with
        $userToken = $user_token;          
      } else {  
        // sandbox (test) environment
        $devID = 'xxxxxxxx';   // these SB keys are different from prod keys
        $appID = 'xxxxxxxxx';
        $certID = 'xxxxxxxxxxxxxx';
        //set the Server to use (Sandbox or Production)
        $serverUrl = 'https://api.sandbox.ebay.com/ws/api.dll';
        // the token representing the eBay user to assign the call with
        // this token is a long string - don't insert new lines - different from prod token
        $userToken = '*************';          
      }
      
      
      ?>