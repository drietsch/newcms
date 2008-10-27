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

function we_tag_ifShopPayVat($attribs,$content) {
    
	require_once(WE_SHOP_MODULE_DIR . 'weShopVatRule.class.php');
	require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tags/we_tag_ifRegisteredUser.inc.php');
	
	$weShopVatRule = weShopVatRule::getShopVatRule();
	
	if (we_tag_ifRegisteredUser(array(), '')) {
		$customer = $_SESSION['webuser'];
	} else {
		$customer = false;
	}
	
	
	return $weShopVatRule->executeVatRule($customer);
	
}

?>