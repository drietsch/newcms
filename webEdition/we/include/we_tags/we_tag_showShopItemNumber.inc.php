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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/shop/we_conf_shop.inc.php");

function we_tag_showShopItemNumber($attribs,$content) {
	
	$foo = attributFehltError($attribs,"shopname","showShopItemNumber");if($foo) return $foo;

	$shopname = we_getTagAttribute("shopname",$attribs);
    if (!isset($GLOBALS[$shopname])||empty($GLOBALS[$shopname])) {
    	return parseError(sprintf($GLOBALS["l_parser"]["missing_createShop"],'showShopItemNumber'));
    }
	$option = we_getTagAttribute("option",$attribs,"",true);
	$inputfield = we_getTagAttribute("inputfield",$attribs,"",true);
	$type = we_getTagAttribute("type",$attribs);

	$xml = we_getTagAttribute("xml", $attribs, "", true);

	$attr = removeAttribs($attribs, array('option', 'inputfield', 'type', 'start', 'stop', 'shopname'));
	
	// $type of the field
	$articleType = 'w';
	
	if (isset($GLOBALS["lv"]->Record['OF_ID'])) {
		$articleType = 'o';
	}
	
	$itemQuantity = $GLOBALS[$shopname]->Get_Item_Quantity($GLOBALS["lv"]->ShoppingCartKey);
	
	if($option || ($type=="select")) {
		
		$start = we_getTagAttribute("start",$attribs,0);
		$stop = we_getTagAttribute("stop",$attribs,10);
		
		$stop=( intval($stop) > intval($itemQuantity) ) ? $stop : $itemQuantity;
		
		$out = '';
		
		
		$attr['name'] = 'shop_cart_id[' . $GLOBALS["lv"]->ShoppingCartKey . ']';
		
		$attr['size'] = 1;
		$attr['xml']  = $xml;

		while( $start <= $stop ) {
			if ( $itemQuantity == $start) {
				$out .=   getHtmlTag('option', array('xml' => $xml,'value'=>$start, 'selected'=>'selected'), $start);
			}
			else {
				$out .=   getHtmlTag('option', array('xml' => $xml,'value'=>$start), $start);
			}
			$start++;
		}
		return getHtmlTag('select', $attr, $out, true) . getHtmlTag('input', array('type'=>'hidden', 'name'=>'t', 'value'=>time()) );
	}
	else if($inputfield || ($type=="textinput")) {
	    $attr = array_merge($attr, array('type'=>'text', 'name'=>'shop_cart_id[' . $GLOBALS["lv"]->ShoppingCartKey . ']', 'size'=>2, 'value'=> $itemQuantity) );
		return getHtmlTag('input', $attr) . getHtmlTag('input', array('type'=>'hidden', 'name'=>'t', 'value'=>time()) );
	}
	else {
		return $itemQuantity;
	}
}
?>