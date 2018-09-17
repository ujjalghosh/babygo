<?php 
include "../../includes/settings.php";
include "../../includes/class_call_one_file.php"; 
$order_no = $_REQUEST['order_no']; 
 ?>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title></title>
</head>

  <style>
    body {
      background: rgb(204,204,204); 
    }
    body, p, span, td, a {font-size:9pt;font-family: Arial, Helvetica, sans-serif;}
    * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }
    page {
      background: white;
      display: block;
      margin: 0 auto;
      margin-bottom: 0.5cm;
      box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
      padding: .3cm;
    }
    page[size="A4"] {  
      width: 21cm;
      height: 29.7cm;
    }
    page[size="A4"][layout="portrait"] {
      width: 29.7cm;
      height: 21cm;  
    }
    page[size="A3"] {
      width: 29.7cm;
      height: 42cm;
    }
    page[size="A3"][layout="portrait"] {
      width: 42cm;
      height: 29.7cm;  
    }
    page[size="A5"] {
      width: 14.8cm;
      height: 21cm;
    }
    page[size="A5"][layout="portrait"] {
      width: 21cm;
      height: 14.8cm;  
    }
    @media print {
      body, page {
        margin: 0;
        box-shadow: 0;
      }
      .page {
          margin: 0;
          border: initial;
          border-radius: initial;
          width: initial;
          min-height: initial;
          box-shadow: initial;
          background: initial;
          page-break-after: always;
      }
    }

    table{border-collapse: collapse;}
    table tr td{border:1px solid #999;padding: 0px 5px;vertical-align: top;}
    table tr td ul{list-style: none;margin: 0;padding: 0;list-style: none;padding-left: 10px;}
    table tr td ul li{font-style: italic;}

    table.no-border tr td{border:0;}

    table.price-tbl tr td{border:0;border-right: 1px solid #999;}

    h4{font-size: 10pt;margin-bottom: 5px;}
  
   .center_text{text-align: center;}

  </style>

<body>
  
  <page size="A4">
  <div class="section">

<table class="no-border" width="100%" cellpadding="0" cellspacing="0">
  <tr> 
<td width="30%">
  <img src="<?php echo Site_URL; ?>images/logo_order.png" alt="">
</td>
<td width="70%">
 <h2> GREEN ORBIT APPARELS PVT. LTD.</h2>
<p>21, BALLYGUANGE CIRCULAR ROAD, CPC OFFICE COMPLEX, 1st FLOOR <br>
<span class="center_text">UNIT-3, KOLKATA - 700019</span></p>
<p><span class="center_text">Tel : 033 4602 6390</span></p>

</td>
  </tr>
</table>



  </div>
  <div class="section">
    <table width="100%" cellpadding="0" cellspacing="0">
      <tr>
       <td height="40" colspan="3" valign="top" align="center"><strong>Tax Invoice</strong></td>          
      </tr>
      <tr>
        <td rowspan="2" valign="top" width="48%">
          <strong>Name :  </strong> Lorem ipsum dolor sit<br>
          <strong>Address :  </strong> Lorem ipsum dolor sit<br>
          <strong>State :  </strong> PUNJAB <br>
          <strong>Mob  :  </strong> 9914027165 <br>

        </td>
        <td height="40" valign="top">Invoice No: 123-126-4563 </td>
        <td height="40" valign="top">Invoice Date : 30-08-2018</td> 
      </tr>
      <tr>
        <td rowspan="1" colspan="3" valign="top" ">
          <strong>Shipping Add : :  </strong> Lorem ipsum dolor sit<br>
          <strong>Address :  </strong> Lorem ipsum dolor sit<br>
          <strong>State :  </strong> PUNJAB <br>   <br><br>    

        </td>        
      </tr>


      <tr>
        <td colspan="3" style="padding:0;">
          <table class="price-tbl" width="100%" cellpadding="0" cellspacing="0">
            <thead>
            <tr>
              <td align="center" width="3%" style="border-bottom:1px solid #999">SL No.</td>
              <td align="center" width="25%" style="border-bottom:1px solid #999">PRODUCT</td>
              <td align="center" width="10%" style="border-bottom:1px solid #999">SIZE RANGE</td>              
              <td align="center" width="9%" style="border-bottom:1px solid #999">BOX</td>
              <td align="center" width="9%" style="border-bottom:1px solid #999">HSN</td>
               <td align="center" width="9%" style="border-bottom:1px solid #999">PACK <br>QTY</td>
              <td align="center" style="border-bottom:1px solid #999">QTY</td>
              <td align="center" style="border-bottom:1px solid #999">UNIT</td>        
              <td align="center" width="9%" style="border-bottom:1px solid #999">MRP</td>
              <td align="center" style="border-bottom:1px solid #999">DISC</td>
              <td align="center" style="border-bottom:1px solid #999">DN<br>AMT</td>
              <td align="center" style="border-bottom:1px solid #999">NET<br>RATE</td>
              <td align="center" width="12%" style="border-bottom:1px solid #999;border-right:0">Amount</td>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td align="center" valign="top">1</td>
              <td align="left">
              <strong style="font-size:13px;text-transform:uppercase">Lorem ipsum dolor sit</strong>
              </td>
              <td align="center">12345678</td>
              <td align="right">18%</td>
              <td align="right"><strong>2 Pcs</strong></td>
              <td align="right">2,500.00</td>
              <td align="center">Pcs</td>
              <td align="right">18%</td>
              <td align="right"><strong>2 Pcs</strong></td>
              <td align="right">2,500.00</td>
              <td align="right">2,500.00</td>
              <td align="center">Pcs</td>
              <td align="right" style="border-right:0">5000.00</td>
            </tr>
            <tr>
              <td align="center" valign="top">2</td>
              <td align="left">
              <strong style="font-size:13px;text-transform:uppercase">Lorem ipsum dolor sit</strong>
              </td>
              <td align="center">12345678</td>
              <td align="right">18%</td>
              <td align="right"><strong>2 Pcs</strong></td>
              <td align="right">2,500.00</td>
              <td align="center">Pcs</td>
              <td align="right">18%</td>
              <td align="right"><strong>2 Pcs</strong></td>
              <td align="right">2,500.00</td>
              <td align="right">2,500.00</td>
              <td align="center">Pcs</td>
              <td align="right" style="border-right:0">5000.00</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td align="right" style="border-top:1px solid #999;border-right:0;padding-bottom:8px">8,700.00</td>
            </tr>

            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td align="right" style="border-top:1px solid #999;border-right:0;padding-bottom:8px">8,700.00</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td align="right" style="border-top:1px solid #999;border-right:0;padding-bottom:8px">8,700.00</td>
            </tr>
            <tr>
              <td style="border-left:0">&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
               <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td style="border-right:0">&nbsp;</td>
            </tr>
            <tr>
              <td style="border-left:0">&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
               <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td style="border-right:0">&nbsp;</td>
            </tr>
            <tr>
              <td style="border-left:0">&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
               <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td style="border-right:0">&nbsp;</td>
            </tr>
            <tr>
              <td style="border-left:0">&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
               <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td style="border-right:0">&nbsp;</td>
            </tr>
            <tr>
              <td style="border-left:0">&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
               <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td style="border-right:0">&nbsp;</td>
            </tr>
            <tr>
              <td style="border-left:0">&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
               <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td style="border-right:0">&nbsp;</td>
            </tr>
            <tr>
              <td style="border-left:0">&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
               <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td style="border-right:0">&nbsp;</td>
            </tr>
            <tr>
              <td style="border-left:0">&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
               <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td style="border-right:0">&nbsp;</td>
            </tr>
            <tr>
              <td style="border-left:0">&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
               <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td style="border-right:0">&nbsp;</td>
            </tr>
            <tr>
              <td style="border-left:0">&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td style="border-right:0">&nbsp;</td>
            </tr>
            <tr>
              <td style="border-left:0">&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
               <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td style="border-right:0">&nbsp;</td>
            </tr>
            <tr>
              <td style="border-left:0">&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
               <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td style="border-right:0">&nbsp;</td>
            </tr>
            <tr>
              <td style="border-left:0">&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
               <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td style="border-right:0">&nbsp;</td>
            </tr>
            <tr>
              <td style="border-left:0">&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
               <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td style="border-right:0">&nbsp;</td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
              <td style="border:1px solid #999;border-left:0">&nbsp;</td>
              <td style="border:1px solid #999" align="right">Total</td>
              <td style="border:1px solid #999">&nbsp;</td>
              <td style="border:1px solid #999">&nbsp;</td>
              <td style="border:1px solid #999" align="right"><strong>4 Pcs</strong></td>
              <td style="border:1px solid #999">&nbsp;</td>
              <td style="border:1px solid #999">&nbsp;</td>
              <td style="border:1px solid #999">&nbsp;</td>
              <td style="border:1px solid #999">&nbsp;</td>
              <td style="border:1px solid #999">&nbsp;</td>
              <td style="border:1px solid #999">&nbsp;</td>
              <td style="border:1px solid #999">&nbsp;</td>
              <td style="border:1px solid #999;border-right:0" align="right"><strong>? 10,000.00</strong></td>
            </tr>
            <tr>
              <td colspan="7">Amount Chargeable (in words)<br><strong style="font-size:14px;">Lorem ipsum dolor sit</strong></td>
              <td align="right"  style="border:0;font-style:italic">E. & O.E</td>
            </tr>
            </tfoot>
          </table>
        </td>
      </tr>
      <tr>
        <td colspan="3" style="padding:0;">
          <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
              <td width="55%" rowspan="2" align="center" style="border-top:0;border-left:0">HSN/SAC</td>
              <td rowspan="2" align="center" style="border-top:0">Taxable<br>Value</td>
              <td colspan="2" align="center" style="border-top:0">Central Tax</td>
              <td colspan="2" align="center" style="border-top:0;border-right:0">State Tax</td>
            </tr>
            <tr>
              <td align="center">Rate</td>
              <td align="center">Amount</td>
              <td align="center">Rate</td>
              <td align="center" style="border-right:0">Amount</td>
            </tr>
            <tr>
              <td align="left" style="border:0;border-right:1px solid #999">84733020</td>
              <td align="right" style="border:0;border-right:1px solid #999">5,000.00</td>
              <td align="right" style="border:0;border-right:1px solid #999">9%</td>
              <td align="right" style="border:0;border-right:1px solid #999">450.00</td>
              <td align="right" style="border:0;border-right:1px solid #999">9%</td>
              <td align="right" style="border:0;">450.00</td>
            </tr>
            <tr>
              <td align="left" style="border:0;border-right:1px solid #999">84733030</td>
              <td align="right" style="border:0;border-right:1px solid #999">5,000.00</td>
              <td align="right" style="border:0;border-right:1px solid #999">9%</td>
              <td align="right" style="border:0;border-right:1px solid #999">450.00</td>
              <td align="right" style="border:0;border-right:1px solid #999">9%</td>
              <td align="right" style="border:0">450.00</td>
            </tr>            
            <tr>
              <td align="right" style="border-bottom:0;border-left:0"><strong>Total</strong></td>
              <td align="right" style="border-bottom:0"><strong>8,700.00</strong></td>
              <td align="right" style="border-bottom:0">&nbsp;</td>
              <td align="right" style="border-bottom:0"><strong>783.00</strong></td>
              <td align="right" style="border-bottom:0">&nbsp;</td>
              <td align="right" style="border-bottom:0;border-right:0"><strong>783.00</strong></td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td colspan="3" height="40" style="border-bottom:0">Tax Amount (in words) &nbsp;&nbsp;<strong style="font-size:14px;">Lorem ipsum dolor sit</strong></td>
      </tr>
      <tr>
        <td colspan="3" style="padding:0;border-top:0">
          <table class="no-border" width="100%" cellpadding="0" cellspacing="0">
            <tr>
              <td width="50%" rowspan="4" align="left" style="vertical-align:bottom;padding-bottom:10px">
                <span style="width:120px;display:inline-block">Buyer's VAT TIN</span>: <strong>1023456789</strong><br>
                Deciaration<br>
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
              </td>
              <td style="vertical-align:bottom">
              Company's Bank Details<br>
              <span style="width:108px;display:inline-block">Bank Name</span>:&nbsp;<strong>H.D.F.C BANK LTD</strong><br>
              <span style="width:108px;display:inline-block">A/C No.</span>:&nbsp;<strong>10234567891</strong><br>
              <span style="width:108px;display:inline-block">Branch & IFS Code</span>:&nbsp;<strong>G.C Avenue & HDFC0000382</strong>
              </td>
            </tr>
            <tr>
              <td align="right" style="border-left:1px solid #999;border-top:1px solid #999">for M.S.IT STORE - (From 1-Apr-2015)</td>
            </tr>
            <tr>
              <td align="right" height="30" style="border-left:1px solid #999;">&nbsp;</td>
            </tr>
            <tr>
              <td align="right" style="border-left:1px solid #999;">Authorised Signatory</td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </div>
  <div class="section">
    <p style="text-align:center;margin-top:0;line-height:24px;">SUBJECT TO KOLKATA JURISDICTION<br>This is a Computer Generated Invoice</p>
  </div>
  </page>

</body>
</html>