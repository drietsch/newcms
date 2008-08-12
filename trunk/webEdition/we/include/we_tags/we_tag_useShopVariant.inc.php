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
 * This function inits a shop variant if available
 *
 * @param	$attribs array
 *
 * @return	void
 */
function we_tag_useShopVariant($attribs) {
	
	global $we_doc;
	
	if (isset($_REQUEST[WE_SHOP_VARIANT_REQUEST]) && !$GLOBALS['we_doc']->InWebEdition ) {
		include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_modules/shop/weShopVariants.inc.php');
		weShopVariants::useVariant($we_doc, $_REQUEST[WE_SHOP_VARIANT_REQUEST]);
	}
}
?>