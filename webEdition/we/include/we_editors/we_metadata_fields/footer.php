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


/*****************************************************************************
 * INCLUDES
 *****************************************************************************/

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlElement.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/metadata.inc.php");

/*****************************************************************************
 * INITIALIZATION
 *****************************************************************************/

protect();

htmlTop();

/*****************************************************************************
 * CREATE JAVASCRIPT
 *****************************************************************************/

// Define needed JS

$_meta_field_empty_messsage = addslashes($GLOBALS['l_metadata']['error_meta_field_empty_msg']);
$_meta_field_wrong_chars_messsage = addslashes($GLOBALS['l_metadata']['meta_field_wrong_chars_messsage']);
$_meta_field_wrong_name_messsage = addslashes($GLOBALS['l_metadata']['meta_field_wrong_name_messsage']);

$_javascript = <<< END_OF_SCRIPT
<!--
function we_save() {
	var _doc = top.we_metadatafields.document;


	var _z = 0;
	var _field = typeof(_doc.forms[0].elements['metadataTag[' + _z + ']']) != "undefined" ? _doc.forms[0].elements['metadataTag[' + _z + ']'] : null;

	while (_field != null) {
		if (!checkMetaFieldName(_field, _z)) {
			return;
		}
		_z++;
		_field = typeof(_doc.forms[0].elements['metadataTag[' + _z + ']']) != "undefined" ? _doc.forms[0].elements['metadataTag[' + _z + ']'] : null;
	}

	_doc.getElementById('metadatafields_dialog').style.display = 'none';

	_doc.getElementById('metadatafields_save').style.display = '';

	_doc.we_form.save_metadatafields.value = 'true';
	_doc.we_form.submit();
}

function checkMetaFieldName(inpElem, nr) {
	var _val = inpElem.value;
	var _forbiddenNames = ",data,width,height,border,align,hspace,vspace,alt,name,title,longdescid,useMetaTitle,scale,play,autoplay,quality,attrib,salign,loop,controller,volume,hidden,";
	var _errtxt = "";
	if (_val === "") {
		_errtxt = "$_meta_field_empty_messsage";
		_errtxt = _errtxt.replace(/%s1/,nr+1);
	} else if (_val.search(/[^a-zA-z0-9_]/) != -1) {
		_errtxt = "$_meta_field_wrong_chars_messsage";
		_errtxt = _errtxt.replace(/%s1/,_val);
	} else if (_forbiddenNames.indexOf(","+_val+",") >= 0) {
		_errtxt = "$_meta_field_wrong_name_messsage";
		_errtxt = _errtxt.replace(/%s1/,_val);
		_errtxt = _errtxt.replace(/%s2/,"\\n" + _forbiddenNames.substring(1,_forbiddenNames.length-1).replace(/,/g,", "));
	}


	if (_errtxt !== "") {
		inpElem.focus();
		inpElem.select();
		top.opener.top.showMessage(_errtxt, 4, top);
		return false;
	}
	return true;
}


//-->
END_OF_SCRIPT;

/*****************************************************************************
 * RENDER FILE
 *****************************************************************************/

print STYLESHEET . we_htmlElement::jsElement($_javascript) . "</head>";

$we_button = new we_button();

$okbut = $we_button->create_button("ok", "javascript:we_save();");
$cancelbut = $we_button->create_button("cancel", "javascript:".((isset($_REQUEST["closecmd"]) && $_REQUEST["closecmd"]) ?  ($_REQUEST["closecmd"].";") : "")."top.close()");

print we_htmlElement::htmlBody(array("class"=>"weDialogButtonsBody"), $we_button->position_yes_no_cancel($okbut, "", $cancelbut, 10, "", "",0) . "</html>");

?>