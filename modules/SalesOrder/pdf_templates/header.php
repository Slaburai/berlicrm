<?php
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  crm-now, www.crm-now.com
* Portions created by crm-now are Copyright (C)  crm-now c/o im-netz Neue Medien GmbH.
* All Rights Reserved.
 *
 ********************************************************************************/
// hole and fold marks
$pdf->SetDrawColor(120,120,120);
$pdf->line(5, 99, 4, 99);
$pdf->line(5, 148.5, 4, 148.5);
$pdf->line(5, 198, 4, 198);
$pdf->SetDrawColor(0,0,0);

$pdf-> setImageScale(1.5);
// ************** Begin company information *****************
//company logo
//function to scal the image to the space availabel is needed
global $logo_name;
if ($logoradio =='true') {
	if (file_exists('test/logo/'.$logo_name))
	$pdf->Image('test/logo/'.$logo_name, $x='125', $y='10', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false);
	else {
	$pdf->SetXY('145','10');
	$pdf->Cell(20,$pdf->getFontSize(),$pdf_strings['MISSING_IMAGE'],0,0);
	}
}
// ************** End company information *******************

// ************* Begin Top-Right Header ***************
//set location
$xmargin = '130';
$ymargin = '45';
$xdistance = '40';
$pdf->SetXY($xmargin,$ymargin);
// define standards
$pdf->SetFont($default_font,'',$font_size_header);
// so number-label
$pdf->Cell($pdf->GetStringWidth($pdf_strings['NUM_FACTURE_NAME']),$pdf->getFontSize(),$pdf_strings['NUM_FACTURE_NAME'],0,0);
//so number-content
//we get the SO # from the entry field, if not set the record id is used
$pdf->SetX($xmargin+$xdistance);
if (trim($requisition_no) != '') {
	$pdf->Cell($pdf->GetStringWidth($requisition_no),$pdf->getFontSize(),$requisition_no,0,1);
}
else {
	$pdf->Cell($pdf->GetStringWidth($SalesOrder_no),$pdf->getFontSize(),$SalesOrder_no,0,1);
}
//so date
$pdf->SetFont($default_font,'',$font_size_header);
//so date - label
$pdf->SetX($xmargin);
$pdf->Cell($pdf->GetStringWidth($pdf_strings['DATE']),$pdf->getFontSize(),$pdf_strings['DATE'],0,0);
//so date -content
$pdf->SetX($xmargin+$xdistance);
$pdf->Cell($pdf->GetStringWidth($date_to_display),$pdf->getFontSize(),$date_to_display,0,1);
//delivery date
$pdf->SetFont($default_font,'',$font_size_header);
//so delivery - label
$pdf->SetX($xmargin);
$pdf->Cell($pdf->GetStringWidth($pdf_strings['SODATE']),$pdf->getFontSize(),$pdf_strings['SODATE'],0,0);
//so delivery -content
$pdf->SetX($xmargin+$xdistance);
$pdf->Cell($pdf->GetStringWidth($delivery_date),$pdf->getFontSize(),$delivery_date,0,1);

//print owner if requested
if ($owner =='true'){
	//owner label
	$pdf->SetX($xmargin);
	$pdf->Cell($pdf->GetStringWidth($pdf_strings['ISSUER']),$pdf->getFontSize(),$pdf_strings['ISSUER'],0,0);
	//owner-content
	$pdf->SetX($xmargin+$xdistance);
	$pdf->Cell($pdf->GetStringWidth($owner_firstname.' '.$owner_lastname),$pdf->getFontSize(),$owner_firstname.' '.$owner_lastname,0,1);
}
if ($ownerphone =='true'){
	//owner label
	$pdf->SetX($xmargin);
	$pdf->Cell($pdf->GetStringWidth($pdf_strings['PHONE']),$pdf->getFontSize(),$pdf_strings['PHONE'],0,0);
	//owner-content
	$pdf->SetX($xmargin+$xdistance);
	$pdf->Cell($pdf->GetStringWidth($owner_phone),$pdf->getFontSize(),$owner_phone,0,1);
}
//print customer markif set
if ($clientid =='true'){
	if (trim($customermark)!='') {
		// label
		$pdf->SetX($xmargin);
		$pdf->Cell($pdf->GetStringWidth($pdf_strings['YOUR_SIGN']),$pdf->getFontSize(),$pdf_strings['YOUR_SIGN'],0,0);
		//content
		$pdf->SetX($xmargin+$xdistance);
		$pdf->Cell($pdf->GetStringWidth(decode_html($customermark)),$pdf->getFontSize(),decode_html($customermark),0,1);
	}
}
// used to define the y location for the body
$ylocation_rightheader= $pdf->GetY();
// ************** End Top-Right Header *****************

// ************** Begin Top-Left Header **************
// Address
$xmargin = '20';
$ymargin = '55';
//senders info
$pdf->SetTextColor(120,120,120);
// companyBlockPositions -> x,y,width
$companyText=decode_html($org_name." - ".$org_address." - ".$org_code." ".$org_city);
$pdf->SetFont($default_font,'B',6);
$pdf->text($xmargin+1,$ymargin,$companyText);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont($default_font,'B',$font_size_address);
$billPositions = array($xmargin,$ymargin,"80");
if (trim($contact_name)!='') {
	if ($bill_country!='Deutschland'   AND trim($bill_country)!='') {
		if (trim($contact_department)!='') {
			$billText=$account_name."\n".$contact_department."\n".$contact_name."\n".$bill_street."\n".$bill_code." ".$bill_city."\n".$bill_country;
		}
		else {
			$billText=$account_name."\n".$contact_name."\n".$bill_street."\n".$bill_code." ".$bill_city."\n".$bill_country;
		}
	}
	else {
		if (trim($contact_department)!='') {
			$billText=$account_name."\n".$contact_department."\n".$contact_name."\n".$bill_street."\n".$bill_code." ".$bill_city;
		}
		else {
			$billText=$account_name."\n".$contact_name."\n".$bill_street."\n".$bill_code." ".$bill_city;
		}
	}
}
elseif ($bill_country!='Deutschland'  AND trim($bill_country)!='') {
	$billText=$account_name."\n".$bill_street."\n".$bill_code." ".$bill_city."\n".$bill_country;
}
else {
	$billText=$account_name."\n".$bill_street."\n".$bill_code." ".$bill_city;
}
$pdf->SetFont($default_font, "", $font_size_address);
$pdf->SetXY ($xmargin,$ymargin+1*$pdf->getFontSize());
$pdf->MultiCell(60,$pdf->getFontSize(), $billText,0,'L');
// ********** End Top-Left Header ******************
//***** empty space below the address required ************
$pdf->SetTextColor(255,255,255);
		//Line break
		$pdf->Ln(20);
//set start y location for body
if ($pdf->GetY() > $ylocation_rightheader) $ylocation_after = $pdf->GetY();
else $ylocation_after = $ylocation_rightheader;
$pdf->SetTextColor(0,0,0);

?>