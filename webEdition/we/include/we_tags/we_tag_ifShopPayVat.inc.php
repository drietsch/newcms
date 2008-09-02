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