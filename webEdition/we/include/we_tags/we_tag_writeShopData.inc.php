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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/shop/we_conf_shop.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_util.inc.php");

/**
 * This function writes the shop data (order) to the database
 *
 * @param          $attribs array
 *
 * @return         void
 */
function we_tag_writeShopData($attribs) {
	global $DB_WE;

	$name = we_getTagAttribute("name",$attribs);
	$foo = attributFehltError($attribs,"pricename","writeShopData");
	if($foo)
		return $foo;
	if(!$name)
		$foo = attributFehltError($attribs,"shopname","writeShopData");
	if($foo)
		return $foo;

	$shopname = we_getTagAttribute("shopname",$attribs);
	$shopname = $shopname ? $shopname : $name;
	$pricename = we_getTagAttribute("pricename",$attribs);

	$netprices = we_getTagAttribute("netprices",$attribs,'true', true, true);

	$useVat = we_getTagAttribute("usevat",$attribs,'true', true);

	if (isset($_SESSION['webuser'])) {
		$_customer = $_SESSION['webuser'];
	} else {
		$_customer = false;
	}

	if ($useVat) {
		require_once(WE_SHOP_MODULE_DIR . 'weShopVatRule.class.php');

		$weShopVatRule = weShopVatRule::getShopVatRule();
		$calcVat = $weShopVatRule->executeVatRule($_customer);
	}

	// Check for Shop being set
	if (isset($GLOBALS[$shopname])) {

		$basket = $GLOBALS[$shopname];

		$shoppingItems = $basket->getShoppingItems();
		$cartFields = $basket->getCartFields();

		if (sizeof($shoppingItems) == 0) {
			return;
		}

		$DB_WE = !isset($DB_WE) ? new DB_WE : $DB_WE;

		$sql = "SELECT max(IntOrderID) as max from " . SHOP_TABLE;
		$DB_WE->connect();

		if (!$DB_WE->query($sql)) {
			echo "Data Insert Failed";
			return;
		}

		$DB_WE->next_record();
		$maxOrderID = $DB_WE->f('max');

		$totPrice = 0;
		
		if(defined("WE_ECONDA_STAT") && defined("WE_ECONDA_PATH") && WE_ECONDA_STAT  && WE_ECONDA_PATH !="" && !$GLOBALS["we_doc"]->InWebEdition){
			$_GLOBALS['weEconda'] = array('emosBasket'=>""); 
			$GLOBALS['weEconda']  = array('emosBilling'=>"");
		}
		$articleCount = 0;
		foreach ($shoppingItems as $shoppingItem) {

			$preis = ((isset($shoppingItem['serial']["we_".$pricename])) ? $shoppingItem['serial']["we_".$pricename] : $shoppingItem['serial'][$pricename]);

			$totPrice += $preis * $shoppingItem['quantity'];

			$preis = we_util::std_numberformat($preis);


			$additionalFields = array();

			// add shopcartfields to table
			$cartField[WE_SHOP_CART_CUSTOM_FIELD] = $cartFields; // add custom cart fields to article
			$cartField[WE_SHOP_PRICE_IS_NET_NAME] = $netprices; // add netprice flag to article

			if ($useVat) {
				$cartField[WE_SHOP_CALC_VAT] = $calcVat; // add flag to shop, if vats shall be used
			}

			// foreach article we must determine the correct tax-rate
			require_once(WE_SHOP_MODULE_DIR . 'weShopVats.class.php');
			$vatId = isset($shoppingItem['serial'][WE_SHOP_VAT_FIELD_NAME]) ? $shoppingItem['serial'][WE_SHOP_VAT_FIELD_NAME] : 0;
			$shopVat = weShopVats::getVatRateForSite($vatId, true, false);
			if ($shopVat) { // has selected or standard shop rate
				$shoppingItem['serial'][WE_SHOP_VAT_FIELD_NAME] = $shopVat;
			} else { // could not find any shoprates, remove field if necessary
				if (isset($shoppingItem['serial'][WE_SHOP_VAT_FIELD_NAME])) {
					unset($shoppingItem['serial'][WE_SHOP_VAT_FIELD_NAME]);
				}
			}

			$sql = "INSERT INTO " . SHOP_TABLE . " (intOrderID, IntArticleID, IntQuantity, Price, IntCustomerID, DateOrder, DateShipping, DatePayment, strSerial) ";
			$sql .= "VALUES (" . abs($maxOrderID + 1) . ", " . abs($shoppingItem['id']) . ", '" . abs($shoppingItem['quantity']) . "', '".mysql_real_escape_string($preis)."' , " . abs($_SESSION["webuser"]["ID"]) . ", now(), '00000000000000', '00000000000000', '" . mysql_real_escape_string(serialize($shoppingItem['serial'])) . "')";

			$DB_WE->connect();
			if (!$DB_WE->query($sql)) {
				echo "Data Insert Failed";
				return;
			}
			
			if (isset($_GLOBALS['weEconda'])){
				$_GLOBALS['weEconda']['emosBasket'] .= "
if(typeof emosBasketPageArray == 'undefined') var emosBasketPageArray = new Array();
emosBasketPageArray[$articleCount] = new Array();
emosBasketPageArray[$articleCount][0]='" . $shoppingItem['id'] . "';
emosBasketPageArray[$articleCount][1]='" . rawurlencode($shoppingItem['serial']['shoptitle']) . "';
emosBasketPageArray[$articleCount][2]='$preis';
emosBasketPageArray[$articleCount][3]='';
emosBasketPageArray[$articleCount][4]='".$shoppingItem['quantity']."';
emosBasketPageArray[$articleCount][5]='NULL';
emosBasketPageArray[$articleCount][6]='NULL';
emosBasketPageArray[$articleCount][7]='NULL';
";
			}
			$articleCount++;
		}

		// second part: add cart fields to table order.
		{
			// add shopcartfields to table
			$cartField[WE_SHOP_CART_CUSTOM_FIELD] = $cartFields; // add custom cart fields to article
			$cartField[WE_SHOP_PRICE_IS_NET_NAME] = $netprices; // add netprice flag to article
			$cartField[WE_SHOP_CART_CUSTOMER_FIELD] = $_customer; // add netprice flag to article

			require_once(WE_SHOP_MODULE_DIR . 'weShippingControl.class.php');
			$weShippingControl = weShippingControl::getShippingControl();

			$cartField[WE_SHOP_SHIPPING] = array(
				'costs'   => $weShippingControl->getShippingCostByOrderValue($totPrice, $_customer),
				'isNet'   => $weShippingControl->isNet,
				'vatRate' => $weShippingControl->vatRate
			);

			if ($useVat) {
				$cartField[WE_SHOP_CALC_VAT] = $calcVat; // add flag to shop, if vats shall be used
			}

			$cartSql = '
				UPDATE ' . SHOP_TABLE . '
				set strSerialOrder=\'' . mysql_real_escape_string(serialize($cartField)) . '\'
				WHERE intOrderID="' . ($maxOrderID + 1) . '"
			';

			if (!$DB_WE->query($cartSql)) {
				echo "Data Insert Failed";
				return;
			}
		}
		if (isset($_GLOBALS['weEconda'])){
			$GLOBALS['weEconda']['emosBilling'] .= "
if(typeof emosBillingPageArray == 'undefined') var emosBillingPageArray = new Array();
emosBillingPageArray [0]='".($maxOrderID+1)."';
emosBillingPageArray [1]='".md5($_SESSION["webuser"]["ID"])."';
emosBillingPageArray [2]='".rawurlencode($_SESSION["webuser"]["Contact_Country"])."/".rawurlencode($_SESSION["webuser"]["Contact_Address2"])."/".rawurlencode($_SESSION["webuser"]["Contact_Address1"])."';
emosBillingPageArray [3]='".$totPrice."';
			"; 			
		}
	}
	return;
}
?>