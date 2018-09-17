<?php
//============================================================+
// File name   : example_061.php
// Begin       : 2010-05-24
// Last Update : 2014-01-25
//
// Description : Example 061 for TCPDF class
//               XHTML + CSS
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: XHTML + CSS
 * @author Nicola Asuni
 * @since 2010-05-25
 */

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 061');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 061', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 10);

// add a page
$pdf->AddPage();

/* NOTE:
 * *********************************************************
 * You can load external XHTML using :
 *
 * $html = file_get_contents('/path/to/your/file.html');
 *
 * External CSS files will be automatically loaded.
 * Sometimes you need to fix the path of the external CSS.
 * *********************************************************
 */

// define some HTML content with style
$html = <<<EOF
<!-- EXAMPLE OF CSS STYLE -->
<style>


  table {
    color: #003300;
    font-family:  Arial, Helvetica, sans-serif;
    font-size: 8pt;
    border-left: 3px solid red;
    border-right: 3px solid #FF00FF;
    border-top: 3px solid green;
    border-bottom: 3px solid blue;
    background-color: #ccffcc;
    border-collapse: collapse;
  }
  td {
    border: 2px solid blue;
    background-color: #ffffee;
  }

    h1 {
    color: navy;
    font-family: times;
    font-size: 24pt;
    text-decoration: underline;
  }
  p.first {
    color: #003300;
    font-family: helvetica;
    font-size: 12pt;
  }
  p.first span {
    color: #006600;
    font-style: italic;
  }
  p#second {
    color: rgb(00,63,127);
    font-family: times;
    font-size: 12pt;
    text-align: justify;
  }
  p#second > span {
    background-color: #FFFFAA;
  }
  table.first {
      border-collapse: collapse;
    color: #003300;
    font-family: Arial;
    font-size: 8pt;

  }
  td {
      border-collapse: collapse;
    border: 2px solid blue;
    background-color: #ffffee;
    border:1px solid #999;padding: 0px 5px;vertical-align: top;
  }
  table tr td{border-collapse: collapse;
    border: 2px solid blue;
    background-color: #ffffee;
    border:1px solid #999;padding: 0px 5px;vertical-align: top;}
  td.second {
    border: 2px dashed green;
  }
  div.test {
    color: #CC0000;
    background-color: #FFFF66;
    font-family: helvetica;
    font-size: 10pt;
    border-style: solid solid solid solid;
    border-width: 2px 2px 2px 2px;
    border-color: green #FF00FF blue red;
    text-align: center;
  }
  .lowercase {
    text-transform: lowercase;
  }
  .uppercase {
    text-transform: uppercase;
  }
  .capitalize {
    text-transform: capitalize;
  }

</style>


      <div class="section">
    <h4 style="text-align:center;position:relative">Tax Invoice <span style="position:absolute;right:5px;font-style:italic;font-weight:normal">(ORIGINAL FOR RECIPIENT)</span></h4>
  </div>

  <div class="section">
  <table class="first" border="collapse" cellpadding="4" cellspacing="6">
 <tr>
  <td width="30" align="center"><b>No.</b></td>
  <td width="140" align="center" bgcolor="#FFFF00"><b>XXXX</b></td>
  <td width="140" align="center"><b>XXXX</b></td>
  <td width="80" align="center"> <b>XXXX</b></td>
  <td width="80" align="center"><b>XXXX</b></td>
  <td width="45" align="center"><b>XXXX</b></td>
 </tr>
 <tr>
  <td width="30" align="center">1.</td>
  <td width="140" rowspan="6" class="second">XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX</td>
  <td width="140">XXXX<br />XXXX</td>
  <td width="80">XXXX<br />XXXX</td>
  <td width="80">XXXX</td>
  <td align="center" width="45">XXXX<br />XXXX</td>
 </tr>
 <tr>
  <td width="30" align="center" rowspan="3">2.</td>
  <td width="140" rowspan="3">XXXX<br />XXXX</td>
  <td width="80">XXXX<br />XXXX</td>
  <td width="80">XXXX<br />XXXX</td>
  <td align="center" width="45">XXXX<br />XXXX</td>
 </tr>
 <tr>
  <td width="80">XXXX<br />XXXX<br />XXXX<br />XXXX</td>
  <td width="80">XXXX<br />XXXX</td>
  <td align="center" width="45">XXXX<br />XXXX</td>
 </tr>
 <tr>
  <td width="80" rowspan="2" >XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX</td>
  <td width="80">XXXX<br />XXXX</td>
  <td align="center" width="45">XXXX<br />XXXX</td>
 </tr>
 <tr>
  <td width="30" align="center">3.</td>
  <td width="140">XXXX<br />XXXX</td>
  <td width="80">XXXX<br />XXXX</td>
  <td align="center" width="45">XXXX<br />XXXX</td>
 </tr>
 <tr bgcolor="#FFFF80">
  <td width="30" align="center">4.</td>
  <td width="140" bgcolor="#00CC00" color="#FFFF00">XXXX<br />XXXX</td>
  <td width="80">XXXX<br />XXXX</td>
  <td width="80">XXXX<br />XXXX</td>
  <td align="center" width="45">XXXX<br />XXXX</td>
 </tr>
</table>

</div>

   <div class="section">
          <table class="price-tbl" border="collapse" cellpadding="0" cellspacing="0">
            <thead>
            <tr>
              <td align="center" width="3" style="border-bottom:1px solid #999">SL No.</td>
              <td align="center" width="25" style="border-bottom:1px solid #999">PRODUCT</td>
              <td align="center" width="10" style="border-bottom:1px solid #999">SIZE RANGE</td>              
              <td align="center" width="9" style="border-bottom:1px solid #999">BOX</td>
              <td align="center" width="9" style="border-bottom:1px solid #999">HSN</td>
               <td align="center" width="9" style="border-bottom:1px solid #999">PACK <br>QTY</td>
              <td align="center" style="border-bottom:1px solid #999">QTY</td>
              <td align="center" style="border-bottom:1px solid #999">UNIT</td>        
              <td align="center" width="9" style="border-bottom:1px solid #999">MRP</td>
              <td align="center" style="border-bottom:1px solid #999">DISC</td>
              <td align="center" style="border-bottom:1px solid #999">DN<br>AMT</td>
              <td align="center" style="border-bottom:1px solid #999">NET<br>RATE</td>
              <td align="center" width="12" style="border-bottom:1px solid #999;border-right:0">Amount</td>
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
              <td align="right" colspan="4"  style="border:0;font-style:italic">E. & O.E</td>
            </tr>
            </tfoot>
          </table>

   </div>

EOF;

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');


// ---------------------------------------------------------

//Close and output PDF document
//$pdf->Output('example_061.pdf', 'I');
$pdf->Output('D:\xampp\htdocs\expirement\babygo\images\Invoices/'.time().'file.pdf', 'F');

//============================================================+
// END OF FILE
//============================================================+
