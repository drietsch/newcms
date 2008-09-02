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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/prefs.inc.php");

/*****************************************************************************
 * INITIALIZATION
 *****************************************************************************/

protect();

htmlTop();

/*****************************************************************************
 * CREATE JAVASCRIPT
 *****************************************************************************/

// Define needed JS
$acErrorMsg = we_message_reporting::getShowMessageCall($l_alert['save_error_fields_value_not_valid'],WE_MESSAGE_ERROR);
$_javascript = <<< END_OF_SCRIPT
<!--
var countSaveTrys = 0;
function we_save() {
	/* 
	-- ERROR HANDLING IS RUNNING ON SERVER --
	if(countSaveTrys>10) {
		$acErrorMsg
		return;
	} else {
		if(!!top.we_preferences.YAHOO.autocoml) {
			countSaveTrys++;

			if(!!top.we_preferences.document.getElementById('seem_start_object') && top.we_preferences.document.getElementById('seem_start_object').style.display == 'none') {
				top.we_preferences.document.getElementById('yuiAcInputObj').value = '';
				top.we_preferences.document.getElementById('yuiAcResultObj').value = ''
				top.we_preferences.YAHOO.autocoml.selectorSetValid('yuiAcInputObj');
			}
			if(!!top.we_preferences.document.getElementById('seem_start_document') && top.we_preferences.document.getElementById('seem_start_document').style.display == 'none') {
				top.we_preferences.document.getElementById('yuiAcInputDoc').value = ''
				top.we_preferences.document.getElementById('yuiAcResultDoc').value = ''
				top.we_preferences.YAHOO.autocoml.selectorSetValid('yuiAcInputDoc');
			}

			weFieldTest = top.we_preferences.YAHOO.autocoml.checkACFields();
			if(weFieldTest.running) {
				setTimeout('we_save()',100);
				return;
			} else if(!weFieldTest.valid) {
				$acErrorMsg
				return;
			}
		}
	}
	*/
	top.we_preferences.document.getElementById('setting_ui').style.display = 'none';
	top.we_preferences.document.getElementById('setting_extensions').style.display = 'none';
	top.we_preferences.document.getElementById('setting_editor').style.display = 'none';
	top.we_preferences.document.getElementById('setting_recipients').style.display = 'none';
	top.we_preferences.document.getElementById('setting_proxy').style.display = 'none';
	top.we_preferences.document.getElementById('setting_cache').style.display = 'none';
	top.we_preferences.document.getElementById('setting_advanced').style.display = 'none';
	top.we_preferences.document.getElementById('setting_system').style.display = 'none';
	top.we_preferences.document.getElementById('setting_error_handling').style.display = 'none';
	top.we_preferences.document.getElementById('setting_backup').style.display = 'none';
	top.we_preferences.document.getElementById('setting_validation').style.display = 'none';
	top.we_preferences.document.getElementById('setting_language').style.display = 'none';
	top.we_preferences.document.getElementById('setting_message_reporting').style.display = 'none';
	//top.we_preferences.document.getElementById('setting_modules').style.display = 'none';

	// update setting for message_reporting
	top.opener.top.messageSettings = top.we_preferences.document.getElementById("message_reporting").value;

	if(top.opener.top.weEditorFrameController.getActiveDocumentReference().quickstart){
		var oCockpit=top.opener.top.weEditorFrameController.getActiveDocumentReference();
		var _fo=top.we_preferences.document.forms[0];
		var oSctCols=_fo.elements['cockpit_amount_columns'];
		var iCols=oSctCols.options[oSctCols.selectedIndex].value;
		if(iCols!=oCockpit._iLayoutCols){
			oCockpit.modifyLayoutCols(iCols);
		}
	}

	top.we_preferences.document.getElementById('setting_email').style.display = 'none';
	top.we_preferences.document.getElementById('setting_save').style.display = '';
	top.we_preferences.document.we_form.save_settings.value = 'true';

END_OF_SCRIPT;

if (we_hasPerm("FORMMAIL")) {
	$_javascript .= "top.we_preferences.send_recipients();";
}

// Define needed JS
$_javascript .= <<< END_OF_SCRIPT
	top.we_preferences.document.we_form.submit();
}

//-->
END_OF_SCRIPT;

/*****************************************************************************
 * RENDER FILE
 *****************************************************************************/

print STYLESHEET . we_htmlElement::jsElement($_javascript) . "</head>";

$we_button = new we_button();

$okbut = $we_button->create_button("save", "javascript:we_save();");
$cancelbut = $we_button->create_button("cancel", "javascript:top.close()");

print we_htmlElement::htmlBody(array("class" => "weDialogButtonsBody"), $we_button->position_yes_no_cancel($okbut, "", $cancelbut, 10, "", "", 0) . "</html>");

?>