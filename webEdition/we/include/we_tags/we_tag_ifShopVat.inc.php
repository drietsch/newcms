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

function we_tag_ifShopVat($attribs,$content) {
    
	require_once(WE_SHOP_MODULE_DIR . 'weShopVats.class.php');
	
	$foo = attributFehltError($attribs,"id","ifShopVat");if($foo) return $foo;
	$id = we_getTagAttribute('id', $attribs, -1);
	
	$vatId = 0;
	
	if (isset($GLOBALS['lv']) && $GLOBALS['lv']->f(WE_SHOP_VAT_FIELD_NAME)) {
		$vatId = $GLOBALS['lv']->f(WE_SHOP_VAT_FIELD_NAME);
	} else {
		$vatId = $GLOBALS['we_doc']->getField(WE_SHOP_VAT_FIELD_NAME);
	}
	
	if (!$vatId) {
		$shopVat = weShopVats::getStandardShopVat();
		if ($shopVat) {
			$vatId = $shopVat->id;
		}
	}
	return ($id == $vatId);
}

?>