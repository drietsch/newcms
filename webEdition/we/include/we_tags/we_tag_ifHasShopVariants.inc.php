<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) living-e AG                   |
// +----------------------------------------------------------------------+
//


/**
 * This function returns if an article has variants
 *
 * @param	$attribs array
 *
 * @return	boolean
 */
function we_tag_ifHasShopVariants($attribs) {
	
	global $we_doc;
	
	require_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_modules/shop/weShopVariants.inc.php');
	if (weShopVariants::getNumberOfVariants($we_doc) > 0) {
		return true;
	} else {
		return false;
	}
}
?>