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


function we_tag_shopField($attribs,$content) {
    
	$foo = attributFehltError($attribs, "name", "shopField");if($foo) return $foo;
	$foo = attributFehltError($attribs, "reference", "shopField");if($foo) return $foo;
	$foo = attributFehltError($attribs, "shopname", "shopField");if($foo) return $foo;
	
	
	$name      = we_getTagAttribute("name", $attribs);
	$reference = we_getTagAttribute("reference", $attribs);
	$shopname  = we_getTagAttribute("shopname", $attribs);
	
	$type = we_getTagAttribute("type", $attribs);
	
	$values = we_getTagAttribute("values", $attribs); // select, choice
	$value = we_getTagAttribute("value", $attribs); // checkbox
	$checked = we_getTagAttribute("checked", $attribs, "", true); // checkbox
	$mode = we_getTagAttribute("mode",$attribs);
	
	$xml = we_getTagAttribute("xml",$attribs,"");
	
	if ( $reference == 'article' ) { // name depends on value
	
		$fieldname = WE_SHOP_ARTICLE_CUSTOM_FIELD . "[$name]";
		
		if (!$shopname) {
			$savedVal = isset($_REQUEST[WE_SHOP_ARTICLE_CUSTOM_FIELD][$name]) ? $_REQUEST[WE_SHOP_ARTICLE_CUSTOM_FIELD][$name] : '';
		} else {
			$savedVal = '';
		}
		
		
		// does not exist here - we are only in article - custom fields are not stored on documents
		$isFieldForCheckBox = false;
		
		if (isset($GLOBALS['lv']) && ($tmpVal = we_tag_field(array('name'=>$name),'')) ) {
			$savedVal = $tmpVal;
			unset($tmpVal);
		}
		
	} else {
		
		$fieldname = WE_SHOP_CART_CUSTOM_FIELD . "[$name]";
		$savedVal = isset($GLOBALS[$shopname]) && isset($GLOBALS[$shopname]->CartFields[$name]) ? $GLOBALS[$shopname]->CartFields[$name] : '';
		
		$isFieldForCheckBox = isset($GLOBALS[$shopname]->CartFields[$name]);
		
	}
	
	$atts = removeAttribs($attribs, array('name','reference','shopname','type','values','value','checked','mode'));
	
	if ($type != 'checkbox' && $type != 'choice' && $type != 'radio' && $value) {
		// value is compared to saved value in some cases
		// be careful with different behaviour when using value and values
		if (!$savedVal) {
			$savedVal = $value;
		}
	}
	
	switch ($type) {
		
		case "checkbox":
			
			$atts = removeAttribs($atts, array('size'));
			
			$atts['name'] = $fieldname;
			$atts['type'] = 'checkbox';
			$atts['value'] = $value;
			if( ($savedVal == $value) || (!$isFieldForCheckBox) && $checked ) {
				$atts['checked'] = 'checked';
			}
			
			return getHtmlTag('input', $atts);
		break;
		
		case 'choice':
		
			$reference = we_getTagAttribute("mode",$attribs);
			
			return we_getInputChoiceField($fieldname,$savedVal,$values,$atts,$mode);
			
		break;
		
		case 'hidden':
			return hidden($fieldname, $savedVal);
		break;
		
		case 'print':
			return $savedVal;
		break;
		
		case 'select':
			return we_getSelectField($fieldname,$savedVal,$values,$atts,false);
		break;
		
		case 'textarea':
			return we_getTextareaField($fieldname,$savedVal,$atts);
		break;
		
		case 'radio':
			return we_getInputRadioField($fieldname,$savedVal,$value,$atts);
		break;
		
		case 'textinput':
		default:
			return we_getInputTextInputField($fieldname,$savedVal,$atts);
		break;
	}
}

?>