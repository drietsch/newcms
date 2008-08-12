<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) living-e AG                   |
// +----------------------------------------------------------------------+
//

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