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