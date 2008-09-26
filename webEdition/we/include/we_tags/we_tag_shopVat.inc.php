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

function we_tag_shopVat($attribs,$content) {
    
	global $we_editmode;
	
	$name = WE_SHOP_VAT_FIELD_NAME;
	
	require_once(WE_SHOP_MODULE_DIR . 'weShopVats.class.php');
	
	
	
	$type = we_getTagAttribute('type', $attribs, 'select');
	$id = we_getTagAttribute('id', $attribs);
	
	
	if ($id) {
		
		$shopVat = weShopVats::getShopVATById($id);
		if ($shopVat) {
			return $shopVat->vat;
		}
		
	} else {
	
	
		// in webEdition - EditMode
		$allVats = weShopVats::getAllShopVATs();
		$values = array();
		
		$standardVal = '';
		
		foreach ($allVats as $id => $shopVat) {
			$values[$id] = $shopVat->vat . ' - ' . $shopVat->text;
			if ($shopVat->standard) {
				
				$standardId = $id;
				$standardVal = $shopVat->vat;
			}
		}
		
		$attribs['name'] = WE_SHOP_VAT_FIELD_NAME;
		$val = htmlspecialchars(isset($GLOBALS["we_doc"]->elements[$name]["dat"]) ? $GLOBALS["we_doc"]->getElement($name) : $standardId);
		
		// use a defined name for this...
		if ($we_editmode) {
			
			switch ($type) {
				default:
					$fieldname = 'we_'.$GLOBALS["we_doc"]->Name.'_txt['.$name.']';
					return $GLOBALS["we_doc"]->htmlSelect($fieldname, $values, 1, $val);
				break;
			}
			
		} else {
			return ( isset($allVats[$val]) ? $allVats[$val]->vat : $standardVal );
		}
	}
}
?>