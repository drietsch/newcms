<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/shop/we_conf_shop.inc.php");

/**
 * This functions checks if the shops basket is not empty
 *
 * @param          $attribs                                array
 *
 * @return         bool
 */

function we_tag_ifShopNotEmpty($attribs) {
	$foo = attributFehltError($attribs,"shopname","ifShopNotEmpty");

	if ($foo) {
		return $foo;
	}

	$shopname = we_getTagAttribute("shopname",$attribs);

	$basket = isset($GLOBALS[$shopname]) ? $GLOBALS[$shopname] : "";

	if ($basket) {
		$shoppingItems = $basket->getShoppingItems();
		$basket_count = sizeof($shoppingItems);

		return abs($basket_count) > 0;
	} else {
		return false;
	}
}

?>