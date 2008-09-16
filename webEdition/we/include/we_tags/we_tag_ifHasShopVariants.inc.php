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