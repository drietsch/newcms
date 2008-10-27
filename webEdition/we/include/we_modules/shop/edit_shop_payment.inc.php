<?php

/**
 * webEdition CMS
 *
 * This source is part of webEdition CMS. webEdition CMS is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile
 * webEdition/licenses/webEditionCMS/License.txt
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_multibox.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_forms.inc.php");
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/we_class.inc.php');


if(defined("SHOP_TABLE")){
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/shop.inc.php");
}

function prepareFieldname($str){
	
	if(strpos($str, '_')){
		return substr_replace($str, "/", strpos($str, '_'),1);
	} else {
		return $str;
	}
	
}

protect();

htmlTop();

print STYLESHEET;

$we_button = new we_button();

if(!empty($_REQUEST["fieldForname"])){	//	save data in arrays .. 

	$q = 'SELECT * FROM ' . ANZEIGE_PREFS_TABLE . ' WHERE strDateiname="payment_details"';
	
	$DB_WE->query($q);
	if ( $DB_WE->num_rows() > 0) {
		$DB_WE->query("UPDATE ".ANZEIGE_PREFS_TABLE." SET strFelder= '" . mysql_real_escape_string($_REQUEST["fieldForname"]). "|" . mysql_real_escape_string($_REQUEST["fieldSurname"]). "|" . mysql_real_escape_string($_REQUEST["fieldStreet"]). "|" . mysql_real_escape_string($_REQUEST["fieldZip"]) . "|" . mysql_real_escape_string($_REQUEST["fieldCity"]) . "|". mysql_real_escape_string($_REQUEST["lc"]) . "|" . mysql_real_escape_string($_REQUEST["ppB"]) . "|" . mysql_real_escape_string($_REQUEST["psb"]) . "|" . mysql_real_escape_string($_REQUEST["lcS"]) . "|" . mysql_real_escape_string($_REQUEST["spAID"]). "|" . mysql_real_escape_string($_REQUEST["spB"]). "|" . mysql_real_escape_string($_REQUEST["spC"]). "|" . mysql_real_escape_string($_REQUEST["spD"]) . "|" . mysql_real_escape_string($_REQUEST["spCo"]) . "|" . mysql_real_escape_string($_REQUEST["spPS"]) . "|" . mysql_real_escape_string($_REQUEST["spcmdP"]) . "|" . mysql_real_escape_string($_REQUEST["spconfP"]) . "|" . mysql_real_escape_string($_REQUEST["spdesc"]) .  "|" . mysql_real_escape_string($_REQUEST["fieldEmail"]) . "' where strDateiname = 'payment_details'");
	} else {
		$DB_WE->query("INSERT INTO ".ANZEIGE_PREFS_TABLE." (ID,strDateiname,strFelder) VALUES('','payment_details','strFelder')");	
	}
	
	$DB_WE->query("UPDATE ".ANZEIGE_PREFS_TABLE." SET strFelder= '" . mysql_real_escape_string($_REQUEST["fieldForname"]) . "|" . mysql_real_escape_string($_REQUEST["fieldSurname"]) . "|" . mysql_real_escape_string($_REQUEST["fieldStreet"]) . "|" . mysql_real_escape_string($_REQUEST["fieldZip"]). "|" . mysql_real_escape_string($_REQUEST["fieldCity"]) . "|". mysql_real_escape_string($_REQUEST["lc"]) . "|" . mysql_real_escape_string($_REQUEST["ppB"]) . "|" . mysql_real_escape_string($_REQUEST["psb"]) . "|" . mysql_real_escape_string($_REQUEST["lcS"]) . "|" . mysql_real_escape_string($_REQUEST["spAID"]) . "|" . mysql_real_escape_string($_REQUEST["spB"]) . "|" . mysql_real_escape_string($_REQUEST["spC"]) . "|" . mysql_real_escape_string($_REQUEST["spD"]) . "|" . mysql_real_escape_string($_REQUEST["spCo"]) . "|" . mysql_real_escape_string($_REQUEST["spPS"]) . "|" . mysql_real_escape_string($_REQUEST["spcmdP"]) . "|" . mysql_real_escape_string($_REQUEST["spconfP"]) . "|" . mysql_real_escape_string($_REQUEST["spdesc"]) .  "|" . mysql_real_escape_string($_REQUEST["fieldEmail"]) . "' where strDateiname = 'payment_details'");
	                                                                                                                                                                                                                                                                                                                                                                                                                                           
	//	Close window when finished
	echo '<script type="text/javascript">self.close();</script>';
	exit;
}


//	NumberFormat - currency and taxes
$DB_WE->query("SELECT strFelder from ".ANZEIGE_PREFS_TABLE." where strDateiname = 'payment_details'");
$DB_WE->next_record();
$feldnamen = explode("|",$DB_WE->f("strFelder"));

for ($i=0;$i<=18;$i++) {
	$feldnamen[$i] = isset($feldnamen[$i]) ? $feldnamen[$i] : '';
}

$_row = 0;
//hier
$Parts= array();

if (defined("CUSTOMER_TABLE")) {
	$_htmlTable = new we_htmlTable(	array(	'border'      => 0,
	'cellpadding' => 0,
	'cellspacing' => 0,
	'width' => "100%"),
	14,
	3);
	$_htmlTable->setCol($_row++, 0, array('colspan' => 4, 'class'=>'defaultfont'),$l_shop["FormFieldsTxt"]);
	$_htmlTable->setCol($_row++, 0, array('colspan' => 4), getPixel(20,15));
	
	$custfields=array();


	$DB_WE->query("SHOW FIELDS FROM " . CUSTOMER_TABLE);
	while ($DB_WE->next_record()) {
		$custfields[$DB_WE->f("Field")]=$DB_WE->f("Field");
	}
	
	$_htmlTable->setCol($_row, 0, array('class'=>'defaultfont'), $l_shop["fieldForname"]);
	$_htmlTable->setColContent($_row, 1, getPixel(10,5) );
	$_htmlTable->setColContent($_row++, 2, htmlSelect('fieldForname',$custfields, 1, $feldnamen[0]) );
	$_htmlTable->setCol($_row++, 0, array('colspan' => 4), getPixel(20,4));
	
	$_htmlTable->setCol($_row, 0, array('class'=>'defaultfont'), $l_shop["fieldSurname"]);
	$_htmlTable->setColContent($_row, 1, getPixel(10,5) );
	$_htmlTable->setColContent($_row++, 2, htmlSelect('fieldSurname',$custfields, 1, $feldnamen[1]) );
	$_htmlTable->setCol($_row++, 0, array('colspan' => 4), getPixel(20,4));
	
	$_htmlTable->setCol($_row, 0, array('class'=>'defaultfont'), $l_shop["fieldStreet"]);
	$_htmlTable->setColContent($_row, 1, getPixel(10,5) );
	$_htmlTable->setColContent($_row++, 2, htmlSelect('fieldStreet',$custfields, 1, $feldnamen[2]) );
	$_htmlTable->setCol($_row++, 0, array('colspan' => 4), getPixel(20,4));
	
	$_htmlTable->setCol($_row, 0, array('class'=>'defaultfont'), $l_shop["fieldZip"]);
	$_htmlTable->setColContent($_row, 1, getPixel(10,5) );
	$_htmlTable->setColContent($_row++, 2, htmlSelect('fieldZip',$custfields, 1, $feldnamen[3]) );
	$_htmlTable->setCol($_row++, 0, array('colspan' => 4), getPixel(20,4));
	
	$_htmlTable->setCol($_row, 0, array('class'=>'defaultfont'), $l_shop["fieldCity"]);
	$_htmlTable->setColContent($_row, 1, getPixel(10,5) );
	$_htmlTable->setColContent($_row++, 2, htmlSelect('fieldCity',$custfields, 1, $feldnamen[4]) );
	$_htmlTable->setCol($_row++, 0, array('colspan' => 4), getPixel(20,4));
	
	
	$_htmlTable->setCol($_row, 0, array('class'=>'defaultfont'), $l_shop["fieldEmail"]);
	$_htmlTable->setColContent($_row, 1, getPixel(10,5) );
	$_htmlTable->setColContent($_row++, 2, htmlSelect('fieldEmail', array_merge(array(""), $custfields), 1, $feldnamen[18]) );

	array_push($Parts, array("html"	=> $_htmlTable->getHtmlCode())); 

}

// PayPal
$_htmlTable = new we_htmlTable(	array(	'border'      => 0,
		'cellpadding' => 0,
		'cellspacing' => 0,
		'width' => "100%"),
	20,
	3);

$_htmlTable->setCol($_row++, 0, array('class'=>'weDialogHeadline', 'colspan' => 4), $l_shop["paypal"]);
$_htmlTable->setCol($_row++, 0, array('colspan' => 4), getPixel(20,8));

$list1 = array("AI" => "Anguilla","AR" => "Argentina","AU" => "Australia", "AT"=>"Austria","BE" => "Belgium","BR" => "Brazil","CA" => "Canada", "CL"=>"Chile", "CN" => "China","CR" => "Costa Rica","CY" => "Cyprus", "CZ"=>"Czech Republic","DK" => "Denmark","DO" => "Dominican Rep.","EC" => "Equador", "EE"=>"Estonia", "FI"=>"Finland","FR" => "France", "DE"=>"Deutschland", "GR"=>"Greece", "HK"=>"Hong Kong");
$list2= array("HU" => "Hungary","IS" => "Iceland","IN" => "India", "IE"=>"Ireland","IL" => "Israel","IT" => "Italy","JM" => "Jamaica", "JP"=>"Japan", "LV" => "Latvia","LT" => "Lithuania","LU" => "Luxemburg", "MY"=>"Malaysia","MT" => "Malta","MX" => "Mexico");
$list3= array("NL" => "Netherlands", "NZ"=>"New Zealand", "NO"=>"Norway","PL" => "Poland", "PT"=>"Portugal", "SG"=>"Singapore", "SK"=>"Slovakia","ZA" => "South Afrika","KR" => "South Korea","ES" => "Spain", "SE"=>"Sweden","CH" => "Switzerland","TW" => "Taiwan","TH" => "Thailand","TR" => "Turkey","GB" => "United Kingdom","United States" => "US","Uruguay" => "UY","Venezuela" => "VE");
$list = array_merge($list1,$list2,$list3);

$_htmlTable->setCol($_row, 0, array('class'=>'defaultfont'), $l_shop["lc"]);
$_htmlTable->setColContent($_row, 1, getPixel(10,5) );
$_htmlTable->setColContent($_row++, 2, htmlSelect('lc', $list, 1, $feldnamen[5]). '<span class="small">&nbsp'. $l_shop["paypalLcTxt"].' </span>' );
$_htmlTable->setCol($_row++, 0, array('colspan' => 4), getPixel(20,4));

$_htmlTable->setCol($_row, 0, array('class'=>'defaultfont'), $l_shop["paypalbusiness"]);
$_htmlTable->setColContent($_row, 1, getPixel(10,5) );
$_htmlTable->setColContent($_row++, 2, htmlTextInput("ppB",30,$feldnamen[6],"","","text",128). '<span class="small">&nbsp'. $l_shop["paypalbTxt"].' </span>' );
$_htmlTable->setCol($_row++, 0, array('colspan' => 4), getPixel(20,4));

$paypalPV = array("default" => "PayPal-Shop","test" => "Sandbox (Test) ");
$_htmlTable->setCol($_row, 0, array('class'=>'defaultfont'), $l_shop["paypalSB"]);
$_htmlTable->setColContent($_row, 1, getPixel(10,5) );
$_htmlTable->setColContent($_row++, 2, htmlSelect('psb', $paypalPV, 1, $feldnamen[7]). '<span class="small">&nbsp'. $l_shop["paypalSBTxt"].' </span>' );

array_push($Parts, array("html"	=> $_htmlTable->getHtmlCode())); 

// saferpay
$_htmlTable = new we_htmlTable(	array(	'border'      => 0,
		'cellpadding' => 0,
		'cellspacing' => 0,
		'width' => "100%"),
	43,
	3);

$_htmlTable->setCol($_row++, 0, array('class'=>'weDialogHeadline', 'colspan' => 4), $l_shop["saferpay"]);
$_htmlTable->setCol($_row++, 0, array('colspan' => 4), getPixel(20,8));

$saferPayLang = array("en" => "english","de" => "deutsch","fr" => "francais","it" => "italiano");
$_htmlTable->setCol($_row, 0, array('class'=>'defaultfont'), $l_shop["saferpayTermLang"]);
$_htmlTable->setColContent($_row, 1, getPixel(10,5) );
$_htmlTable->setColContent($_row++, 2, htmlSelect('lcS',$saferPayLang, 1, $feldnamen[8]). '<span class="small">&nbsp'. $l_shop["saferpayLcTxt"].' </span>' );
$_htmlTable->setCol($_row++, 0, array('colspan' => 4), getPixel(20,4));

$_htmlTable->setCol($_row, 0, array('class'=>'defaultfont'), $l_shop["saferpayID"]);
$_htmlTable->setColContent($_row, 1, getPixel(10,5) );
$_htmlTable->setColContent($_row++, 2, htmlTextInput("spAID",30,$feldnamen[9],"","","text",128). '<span class="small">&nbsp'. $l_shop["saferpayIDTxt"].' </span>' );
$_htmlTable->setCol($_row++, 0, array('colspan' => 4), getPixel(20,4));

$_htmlTable->setCol($_row, 0, array('class'=>'defaultfont'), $l_shop["saferpaybusiness"]);
$_htmlTable->setColContent($_row, 1, getPixel(10,5) );
$_htmlTable->setColContent($_row++, 2, htmlTextInput("spB",30,$feldnamen[10],"","","text",128). '<span class="small">&nbsp'. $l_shop["saferpaybTxt"].' </span>' );
$_htmlTable->setCol($_row++, 0, array('colspan' => 4), getPixel(20,4));

$saferPayCollect = array("no" => $l_shop["saferpayNo"],"yes" => $l_shop["saferpayYes"]);
$_htmlTable->setCol($_row, 0, array('class'=>'defaultfont'), $l_shop["saferpayAllowCollect"]);
$_htmlTable->setColContent($_row, 1, getPixel(10,5) );
$_htmlTable->setColContent($_row++, 2, htmlSelect('spC',$saferPayCollect, 1, $feldnamen[11]). '<span class="small">&nbsp'. $l_shop["saferpayAllowCollectTxt"].' </span>' );
$_htmlTable->setCol($_row++, 0, array('colspan' => 4), getPixel(20,4));

$saferPayDelivery = array("no" => $l_shop["saferpayNo"],"yes" => $l_shop["saferpayYes"]);
$_htmlTable->setCol($_row, 0, array('class'=>'defaultfont'), $l_shop["saferpayDelivery"]);
$_htmlTable->setColContent($_row, 1, getPixel(10,5) );
$_htmlTable->setColContent($_row++, 2, htmlSelect('spD',$saferPayDelivery, 1, $feldnamen[12]). '<span class="small">&nbsp'. $l_shop["saferpayDeliveryTxt"].' </span>' );
$_htmlTable->setCol($_row++, 0, array('colspan' => 4), getPixel(20,4));

$saferPayConfirm = array("no" => $l_shop["saferpayNo"],"yes" => $l_shop["saferpayYes"]);
$_htmlTable->setCol($_row, 0, array('class'=>'defaultfont'), $l_shop["saferpayUnotify"]);
$_htmlTable->setColContent($_row, 1, getPixel(10,5) );
$_htmlTable->setColContent($_row++, 2, htmlSelect('spCo',$saferPayConfirm, 1, $feldnamen[13]). '<span class="small">&nbsp'. $l_shop["saferpayUnotifyTxt"].' </span>' );
$_htmlTable->setCol($_row++, 0, array('colspan' => 4), getPixel(20,4));

$_htmlTable->setCol($_row, 0, array('class'=>'defaultfont'), $l_shop["saferpayProviderset"]);
$_htmlTable->setColContent($_row, 1, getPixel(10,5) );
$_htmlTable->setColContent($_row++, 2, htmlTextInput("spPS",30,$feldnamen[14],"","","text",128). '<span class="small">&nbsp'. $l_shop["saferpayProvidersetTxt"].' </span>' );
$_htmlTable->setCol($_row++, 0, array('colspan' => 4), getPixel(20,4));

$_htmlTable->setCol($_row, 0, array('class'=>'defaultfont'), $l_shop["saferpayCMDPath"]);
$_htmlTable->setColContent($_row, 1, getPixel(10,5) );
$_htmlTable->setColContent($_row++, 2, htmlTextInput("spcmdP",30,$feldnamen[15],"","","text",128). '<span class="small">&nbsp'. $l_shop["saferpayCMDPathTxt"].' </span>' );
$_htmlTable->setCol($_row++, 0, array('colspan' => 4), getPixel(20,4));

$_htmlTable->setCol($_row, 0, array('class'=>'defaultfont'), $l_shop["saferpayconfPath"]);
$_htmlTable->setColContent($_row, 1, getPixel(10,5) );
$_htmlTable->setColContent($_row++, 2, htmlTextInput("spconfP",30,$feldnamen[16],"","","text",128). '<span class="small">&nbsp'. $l_shop["saferpayconfPathTxt"].' </span>' );
$_htmlTable->setCol($_row++, 0, array('colspan' => 4), getPixel(20,4));

$_htmlTable->setCol($_row, 0, array('class'=>'defaultfont'), $l_shop["saferpaydesc"]);
$_htmlTable->setColContent($_row, 1, getPixel(10,5) );
$_htmlTable->setColContent($_row++, 2, we_class::htmlTextArea("spdesc",2,30,$feldnamen[17]). '<span class="small">&nbsp'. $l_shop["saferpaydescTxt"].' </span>' );
$_htmlTable->setCol($_row++, 0, array('colspan' => 4), getPixel(20,4));

$_htmlTable->setCol($_row++, 0, array('colspan' => 4), getPixel(20,15));

array_push($Parts, array("html" => $_htmlTable->getHtmlCode())); 

$_buttons = $we_button->position_yes_no_cancel(	$we_button->create_button("save", "javascript:document.we_form.submit();"),
"",
$we_button->create_button("cancel", "javascript:self.close();")
);

$frame = we_multiIconBox::getHTML('','100%',$Parts,'30',$_buttons,-1,'','',false, $l_shop["paymentP"],'','','hidden');


echo '<script type="text/javascript">self.focus();</script>
</head>
<body class="weDialogBody"> 


<form name="we_form" method="post" style="margin-top:16px;">
' . $frame. '</form>


</body></html>';


?>
