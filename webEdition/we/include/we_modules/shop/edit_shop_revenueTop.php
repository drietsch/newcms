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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_class.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_multibox.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/we_tabs.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_language/".$GLOBALS["WE_LANGUAGE"]."/we_editor_info.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/shop/we_pager_class.inc.php");

if(defined("SHOP_TABLE")){
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/shop.inc.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/shop_month.inc.php");
}

$selectedYear = isset($_REQUEST['ViewYear']) ? $_REQUEST['ViewYear'] : date("Y");
$selectedMonth = isset($_REQUEST['ViewMonth']) ? $_REQUEST['ViewMonth'] : '0';
$orderBy = isset($_REQUEST['orderBy']) ? $_REQUEST['orderBy'] : 'IntOrderID';
$actPage = isset($_REQUEST['actPage']) ? $_REQUEST['actPage'] : '0';

function orderBy($a, $b) {

	$true = true;
	$false = false;

	if (isset($_REQUEST['orderDesc'])) { // turn order!
		$true = false;
		$false = true;
	}

	if ($a[$_REQUEST['orderBy']] >= $b[$_REQUEST['orderBy']]) {
		return $true;
	} else {
		return $false;
	}
}

function getTitleLink($text, $orderKey) {

	global $selectedYear, $selectedMonth, $actPage, $orderBy;

	$_href =	$_SERVER['PHP_SELF'] .
				'?ViewYear=' . $selectedYear .
				'&ViewMonth=' . $selectedMonth .
				'&orderBy=' . $orderKey .
				'&actPage=' . $actPage .
				( ($orderBy == $orderKey && !isset($_REQUEST['orderDesc'])) ? '&orderDesc=true' : '' );

	$arrow = '';

	if ($orderBy == $orderKey) {

		if (isset($_REQUEST['orderDesc'])) {
			$arrow = ' <img src="' . IMAGE_DIR . '/arrow_sort_desc.gif" />';
		} else {
			$arrow = ' &darr; ';
			$arrow = ' <img src="' . IMAGE_DIR . '/arrow_sort_asc.gif" />';
		}

	}

	return '<a href="' . $_href . '">' . $text . '</a>' . $arrow;
}

function getPagerLink() {

	global $selectedMonth, $selectedYear, $actPage, $orderBy;

	return 	$_SERVER['PHP_SELF'] .
			'?ViewYear=' . $selectedYear .
			'&ViewMonth=' . $selectedMonth .
			'&orderBy=' . $orderBy .
			(isset($_REQUEST['orderdesc']) ? '&orderDesc=true' : '' );
}

function numfom($result){ //number format
  global $numberformat;
     if($numberformat=="german"){
			$result=number_format($result,2,",",".");
		}else if($numberformat=="french"){
			$result=number_format($result,2,","," ");
		}else if($numberformat=="swiss"){
			$result=number_format($result,2,".","'");
		}else if($numberformat=="english"){
			$result=number_format($result,2,".","");
		}
		return $result;
}

function yearSelect($select_name) {
	$yearStart = 2001;
	$yearNow   = date('Y');
	$opts = array();

	while ($yearNow > $yearStart) {
		$opts[$yearNow] = $yearNow;
		$yearNow--;
	}
	return we_class::htmlSelect($select_name, $opts, 1, (isset($_REQUEST[$select_name]) ? $_REQUEST[$select_name] : '' ), false, 'id="' . $select_name . '"'  );
}

function monthSelect($select_name) {

	global $l_shop_month;

	$opts[0] = '-';
	$opts = array_merge($opts, $l_shop_month);

	return we_class::htmlSelect($select_name, $opts, 1, (isset($_REQUEST[$select_name]) ? $_REQUEST[$select_name] : '' ), false, 'id="' . $select_name . '"'  );
}

protect();

htmlTop();

print STYLESHEET;


print '
<script type="text/javascript">

	function we_submitDateform() {
		elem = document.forms[0];
		elem.submit();
	}
	
	var countSetTitle = 0;
	function setHeaderTitle() {
		pre = "";
		post = "' . (isset($_REQUEST['ViewMonth']) && $_REQUEST['ViewMonth'] > 0 ? $l_shop_month[$_REQUEST['ViewMonth']] . " ": "") . $_REQUEST['ViewYear'] . '";
		if(parent.edheader && parent.edheader.setTitlePath) {
			parent.edheader.hasPathGroup = true; 
			parent.edheader.setPathGroup(pre); 
			parent.edheader.hasPathName = true; 
			parent.edheader.setPathName(post); 
			parent.edheader.setTitlePath();
			countSetTitle = 0;
		} else {
			if(countSetTitle < 30) {
				setTimeout("setHeaderTitle()",100);
				countSetTitle++;
			}
		}
	}

</script>
<style type="text/css">
	table.revenueTable {
		border-collapse: collapse;
	}
	table.revenueTable th,
	table.revenueTable td {
		padding: 8px;
		border: 1px solid #666666;
	}
</style>
</head>
<body class="weEditorBody" onload="self.focus(); setHeaderTitle();" onunload="">
<form>';

// get some preferences!
$query = 'SELECT strFelder from '.ANZEIGE_PREFS_TABLE.' where strDateiname = "shop_pref"';
	$DB_WE->query($query);
	$DB_WE->next_record();

$feldnamen = explode("|",$DB_WE->f("strFelder"));
	$waehr = "&nbsp;".$feldnamen[0];
	$numberformat = $feldnamen[2];
	$classid = (isset($feldnamen[3]) ? $feldnamen[3] : '');
	$defaultVat = !empty($feldnamen[1]) ? ($feldnamen[1]) : 0;

	if (!isset($nrOfPage)){

		$nrOfPage = isset($feldnamen[4]) ? $feldnamen[4] : 20;
	 }
	 if($nrOfPage == "default"){
		$nrOfPage =20;
	 }

	$parts = array();
	// get header of total revenue of a year

	array_push($parts, array(
		'headline' => '<label for="ViewYear">' . $l_shop["selectYear"] . '</label>',
		'html' => yearSelect("ViewYear"),
		'space' => 150,
		'noline' => 1
		)
	);
	array_push($parts, array(
		'headline' => '<label for="ViewMonth">' . $l_shop["selectMonth"] . '</label>',
		'html' => monthSelect("ViewMonth"),
		'space' => 150,
		'noline' => 1
		)
	);

	$we_button = new we_button();

	 array_push($parts, array(
		'headline' => $we_button->create_button('select', "javascript:we_submitDateform();"),
		'html' => '',
		'space' => 150
		)
	);

	// get queries for revenue and article list.
	$queryCondtion = 'date_format(DateOrder,"%Y") = "' . $selectedYear . '"';

	if ($selectedMonth != '0') {
		$queryCondtion .= ' AND date_format(DateOrder,"%c") = "' . $selectedMonth . '"';
	}

	$queryRevenue = '
		SELECT *,DATE_FORMAT(DateOrder, "%d.%m.%Y") as formatDateOrder, DATE_FORMAT(DatePayment, "%d.%m.%Y") as formatDatePayment
		FROM ' . SHOP_TABLE . '
		WHERE ' . $queryCondtion . '
		ORDER BY IntOrderID
		';
	unset($monthCondition);
	$DB_WE->query($queryRevenue);


	if ($DB_WE->num_rows()) {

		$actOrder = 0;
		$amountOrders = 0;
		$editedOrders = 0;
		$payedOrders = 0;
		$unpayedOrders = 0;
		$total = 0;
		$payed = 0;
		$unpayed = 0;


		// first of all calculate complete revenue of this year -> important check vats as well.

		$nr = 0;
		$orderRows = array();

		while ($DB_WE->next_record()) {

			// for the articlelist, we need also all these article, so sve them in array

			$orderRows[$nr]['articleArray'] = @unserialize($DB_WE->f('strSerial'));

			// initialize all data saved for an article
			$shopArticleObject = $orderRows[$nr]['articleArray'];

			// save all data in array
			$orderRows[$nr]['IntOrderID'] = $DB_WE->f('IntOrderID'); // also for ordering
			$orderRows[$nr]['IntCustomerID'] = $DB_WE->f('IntCustomerID');
			$orderRows[$nr]['IntArticleID'] = $DB_WE->f('IntArticleID');  // also for ordering
			$orderRows[$nr]['IntQuantity'] = $DB_WE->f('IntQuantity');
			$orderRows[$nr]['DatePayment'] = $DB_WE->f('DatePayment');
			$orderRows[$nr]['DateOrder'] = $DB_WE->f('DateOrder');
			$orderRows[$nr]['formatDateOrder'] = $DB_WE->f('formatDateOrder');  // also for ordering
			$orderRows[$nr]['formatDatePayment'] = $DB_WE->f('formatDatePayment'); // also for ordering
			$orderRows[$nr]['Price'] = $DB_WE->f('Price');  // also for ordering
			$orderRows[$nr]['shoptitle'] = (isset($shopArticleObject['shoptitle']) ? $shopArticleObject['shoptitle'] : $shopArticleObject['we_shoptitle']);  // also for ordering

			// all data from strSerialOrder
			// first unserialize order-data
			if ($DB_WE->f('strSerialOrder')) {
				$orderRows[$nr]['orderArray'] = @unserialize($DB_WE->f('strSerialOrder'));

				$customCartFields = isset($orderRows[$nr]['serialOrder'][WE_SHOP_CART_CUSTOM_FIELD]) ? $orderRows[$nr]['serialOrder'][WE_SHOP_CART_CUSTOM_FIELD] : array();

			} else {
				$orderRows[$nr]['orderArray'] = array();

				$customCartFields = array();
			}

			$actPrice = 0;

			$orderData = $orderRows[$nr]['orderArray'];

			// ********************************************************************************
			// now get information about complete order
			// - pay VAT?
			// - prices are net?

				// prices are net?
				$pricesAreNet = true;
				if ( isset($orderData[WE_SHOP_PRICE_IS_NET_NAME]) ) {
					$pricesAreNet = $orderData[WE_SHOP_PRICE_IS_NET_NAME];
				}

				// must calculate vat?
				$calcVat = true;
				if (isset($orderData[WE_SHOP_CALC_VAT])) {
					$calcVat = $orderData[WE_SHOP_CALC_VAT];
				}
			//
			// no get information about complete order
			// ********************************************************************************

			// now calculate prices: without vat first
			$actPrice = $DB_WE->f('Price') * $DB_WE->f('IntQuantity');
			// now calculate vats to prices !!!
				if ($calcVat) { // vat must be payed for this order

					// now determine VAT
					if (isset($shopArticleObject[WE_SHOP_VAT_FIELD_NAME])) {
						$articleVat = $shopArticleObject[WE_SHOP_VAT_FIELD_NAME];
					} else if (isset($defaultVat)) {
						$articleVat = $defaultVat;
					} else {
						$articleVat = 0;
					}

					if ($articleVat > 0) {

						if (!isset($articleVatArray[$articleVat])) { // avoid notices
							$articleVatArray[$articleVat] = 0;
						}

						// calculate vats to prices if neccessary
						if ($pricesAreNet) {
							$articleVatArray[$articleVat] += ($actPrice*$articleVat/100);
							$actPrice += ($actPrice*$articleVat/100);
						} else {
							$articleVatArray[$articleVat] += ($actPrice*$articleVat/(100 + $articleVat));
						}
					}
				}

			$total += $actPrice;


			if ($DB_WE->f('DatePayment') != 0) {

				if ($actOrder != $DB_WE->f('IntOrderID')) {
					$payedOrders++;
				}
				$payed += $actPrice;

			} else {
				if ($actOrder != $DB_WE->f('IntOrderID')) {
					$unpayedOrders++;
				}
				$unpayed += $actPrice;
			}

			if ($DB_WE->f('DateShipping') != 0) {
				if ($actOrder != $DB_WE->f('IntOrderID')) {
					$editedOrders++;
				}
			}

			// save last order.
			if ($actOrder != $DB_WE->f('IntOrderID')) {
				$actOrder = $DB_WE->f('IntOrderID');
				$amountOrders++;
			}

			$nr++;
		}

		// generate vat table
		$vatTable = '';
		if (isset($articleVatArray)) {
$vatTable .= '
<tr>
	<td>' . getPixel(1,10) . '</td>
<tr>
	<td colspan="6" class="shopContentfontR">' . $l_shop["includedVat"] . ':</td>
</tr>
';
			foreach ($articleVatArray as $_vat => $_amount) {
				$vatTable .= '
<tr>
	<td colspan="5"></td>
	<td class="shopContentfontR">' . $_vat . '&nbsp;%</td>
	<td class="shopContentfontR">' . numfom($_amount) . $waehr .  '</td>
</tr>
				';
			}
		}

		array_push($parts, array(

			'html' => '
<table class="defaultfont" width="680" cellpadding="2">
<tr>
	<th>' . $l_shop["anual"] . '</th>
	<th>' . ($selectedMonth ? $l_shop["monat"] : '' ) . '</th>
	<th>' . $l_shop["anzahl"] . '</th>
	<th>' . $l_shop["unbearb"] . '</th>
	<th>' . $l_shop["schonbezahlt"] . '</th>
	<th>' . $l_shop["unbezahlt"] . '</th>
	<th>' . $l_shop["umsatzgesamt"] . '</th>
</tr>
<tr class="shopContentfont">
	<td>' . $selectedYear . '</td>
	<td>' . ($selectedMonth ? $selectedMonth : '' ) . '</td>
	<td>' . $amountOrders . '</td>
	<td class="npshopContentfontR">' . ($amountOrders - $editedOrders) . '</td>
	<td>' . numfom($payed) . $waehr . '</td>
	<td class="npshopContentfontR">' . numfom($unpayed) . $waehr . '</td>
	<td class="shopContentfontR">' . numfom($total) . $waehr . '</td>
</tr>
' . $vatTable . '
</table>',
			'space'=> 0
			)
		);

		$headline[0]["dat"] = getTitleLink($l_shop["bestellung"], 'IntOrderID');
		$headline[1]["dat"] = getTitleLink($l_shop["artName"], 'shoptitle');
		$headline[2]["dat"] = getTitleLink($l_shop["artPrice"], 'Price');
		$headline[3]["dat"] = getTitleLink($l_shop["artOrdD"], 'DateOrder');
		$headline[4]["dat"] = getTitleLink($l_shop["artID"], 'IntArticleID');
		$headline[5]["dat"] = getTitleLink($l_shop["artPay"], 'DatePayment');

		// we need functionalitty to order these

		if (isset($_REQUEST['orderBy']) && $_REQUEST['orderBy']) {
			usort($orderRows, 'orderBy');
		}

		for ($nr=0,$i=($actPage*$nrOfPage); $i<sizeof($orderRows) && $i<($actPage*$nrOfPage + $nrOfPage); $i++, $nr++ ) {

			$orderData   = $orderRows[$i]['orderArray'];
			$articleData = $orderRows[$i]['articleArray'];

			$variantStr = '';
			if ( isset($articleData['WE_VARIANT']) && $articleData['WE_VARIANT'] ) {
				$variantStr = '<br />' . $l_shop["variant"] . ': ' . $articleData['WE_VARIANT'];
			}

			$customFields = '';
			if ( isset($articleData[WE_SHOP_ARTICLE_CUSTOM_FIELD]) && $articleData[WE_SHOP_ARTICLE_CUSTOM_FIELD] ) {
				$customFields = '<br />
					';
				foreach ($articleData[WE_SHOP_ARTICLE_CUSTOM_FIELD] as $key => $val) {
					$customFields .= "$key=$val<br />
					";
				}
			}

			$content[$nr][0]['dat'] = $orderRows[$i]['IntOrderID'];
			$content[$nr][1]['dat'] = $orderRows[$i]['shoptitle']  . '<span class="small">' . $variantStr . ' ' . $customFields . '</span>';
			$content[$nr][2]['dat'] = numfom($orderRows[$i]['Price']) . $waehr;
			$content[$nr][3]['dat'] = $orderRows[$i]['formatDateOrder'];
			$content[$nr][4]['dat'] = $orderRows[$i]['IntArticleID'];
			$content[$nr][5]['dat'] = ($orderRows[$i]['DatePayment'] != 0 ? $orderRows[$i]['formatDatePayment'] : '<span class="npshopContentfontR">' . $l_shop['artNPay'] . '</span>');

		}

		array_push($parts, array(
			'html' => htmlDialogBorder3(670,100,$content, $headline),
			'space' => 0,
			'noline' => true
			)
		);


		$pager = blaettern::getStandardPagerHTML(getPagerLink(),$actPage,$nrOfPage,count($orderRows));

		array_push($parts, array(
			'html' => $pager,
			'space' => 0
			)
		);



	} else {
		array_push($parts, array(
			'html' => $l_shop["NoRevenue"],
			'space'=> 0
			)
		);


	}

	print we_multiIconBox::getHTML("revenues", "100%", $parts, 30,"", -1,"","",false, sprintf($GLOBALS['l_tabs']['module']['revenueTotal'], $selectedYear));
?>
</form>
</body>
</html>