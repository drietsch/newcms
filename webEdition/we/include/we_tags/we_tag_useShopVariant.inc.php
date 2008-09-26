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