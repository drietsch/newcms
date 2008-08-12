<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) living-e AG                   |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/shop/we_conf_shop.inc.php");

/**
 * This functions checks if the shops basket is empty
 *
 * @param          $attribs                                array
 *
 * @return         bool
 */

function we_tag_ifShopEmpty($attribs) {
	$foo = attributFehltError($attribs,"shopname","ifShopEmpty");if($foo) return $foo;
	$shopname = we_getTagAttribute("shopname",$attribs);

	$basket = isset($GLOBALS[$shopname]) ? $GLOBALS[$shopname] : "";
	if ($basket) {
		$shoppingItems = $basket->getShoppingItems();
		$basket_count = sizeof($shoppingItems);

		return abs($basket_count) == 0;
	} else {
		return true;
	}
}
?>