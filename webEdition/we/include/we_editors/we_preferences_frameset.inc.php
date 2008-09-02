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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlElement.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlFrameset.inc.php");

/*****************************************************************************
 * INITIALIZATION
 *****************************************************************************/

protect();

htmlTop();

$tabname = isset($_REQUEST["tabname"]) ? $_REQUEST["tabname"] : (isset($_REQUEST["we_cmd"][1]) ? $_REQUEST["we_cmd"][1] : "setting_ui");
/*****************************************************************************
 * CREATE JAVASCRIPT
 *****************************************************************************/

// Define needed JS
$_javascript = <<< END_OF_SCRIPT
<!--

function we_cmd() {
	var url = "/webEdition/we/include/we_editors/we_preferences.php?";

	switch (arguments[0]) {
		case "ui":
		case "editor":
		case "message_reporting":
END_OF_SCRIPT;

if (we_hasPerm("ADMINISTRATOR") || we_hasPerm("NEW_TEMPLATE")) {
	$_javascript .=	"
		case \"cache\":";
}

if (we_hasPerm("EDIT_SETTINGS_DEF_EXT")) {
	$_javascript .=	"
		case \"extensions\":";
}

if (we_hasPerm("EDIT_SETTINGS_DEF_EXT")) {
	$_javascript .=	"
		case \"recipients\":";
}

if (we_hasPerm("ADMINISTRATOR")) {
	$_javascript .=	"
		case \"proxy\":
		case \"advanced\":
		case \"system\":
		case \"error_handling\":
		case \"backup\":
		case \"validation\":
		case \"language\":
		case \"active_integrated_modules\":
		case \"versions\":
		case \"email\":";
		
}

if (we_hasPerm("FORMMAIL")) {
	$_javascript .=	"
		case \"recipients\":";
}

//if (we_hasPerm("ADMINISTRATOR") && defined("OBJECT_TABLE")) {
//	$_javascript .=	"
//		case \"modules\":";
//}

$_javascript .= <<< END_OF_SCRIPT
			we_preferences.document.getElementById('setting_ui').style.display = 'none';
			we_preferences.document.getElementById('setting_extensions').style.display = 'none';
			we_preferences.document.getElementById('setting_editor').style.display = 'none';
			we_preferences.document.getElementById('setting_recipients').style.display = 'none';
			we_preferences.document.getElementById('setting_proxy').style.display = 'none';
			we_preferences.document.getElementById('setting_advanced').style.display = 'none';
			we_preferences.document.getElementById('setting_system').style.display = 'none';
			we_preferences.document.getElementById('setting_error_handling').style.display = 'none';
			//we_preferences.document.getElementById('setting_modules').style.display = 'none';
			we_preferences.document.getElementById('setting_backup').style.display = 'none';
			we_preferences.document.getElementById('setting_validation').style.display = 'none';
			we_preferences.document.getElementById('setting_cache').style.display = 'none';
			we_preferences.document.getElementById('setting_language').style.display = 'none';
			we_preferences.document.getElementById('setting_message_reporting').style.display = 'none';
			we_preferences.document.getElementById('setting_active_integrated_modules').style.display = 'none';
			we_preferences.document.getElementById('setting_email').style.display = 'none';
			we_preferences.document.getElementById('setting_versions').style.display = 'none';

			we_preferences.document.getElementById('setting_' + arguments[0]).style.display = '';

			break;
END_OF_SCRIPT;

$_javascript .= "
		case \"show_tabs\":
			we_preferences_header.document.location = '" . WEBEDITION_DIR . "we/include/we_editors/we_preferences_header.php".($tabname!="" ? "?tabname=".$tabname : "")."';

			break;
	}
}
self.focus();

function closeOnEscape() {
	return true;
	
}

function saveOnKeyBoard() {
	window.frames[2].we_save();
	return true;
	
}

//-->
";

/*****************************************************************************
 * RENDER FILE
 *****************************************************************************/

print we_htmlElement::jsElement($_javascript, array("type" => "text/javascript")) . 
	  we_htmlElement::jsElement("", array("src" => JS_DIR . "keyListener.js")) . "</head>";

$frameset = new we_htmlFrameset(array("rows" => "38,*,40", "framespacing" => "0", "border" => "0",  "frameborder" => "no"), 0);
$frameset->addFrame(array("src" => WEBEDITION_DIR . "html/white.html", "name" => "we_preferences_header", "scrolling" => "no", "noresize" => "noresize"));
$frameset->addFrame(array("src" => WEBEDITION_DIR . "we/include/we_editors/we_preferences.php?setting=ui".($tabname!="" ? "&tabname=".$tabname : ""), "name" => "we_preferences", "scrolling" => "auto", "noresize" => "noresize"));
$frameset->addFrame(array("src" => WEBEDITION_DIR . "we/include/we_editors/we_preferences_footer.php", "name" => "we_preferences_footer", "scrolling" => "no", "noresize" => "noresize"));

print $frameset->getHtmlCode() . we_htmlElement::htmlBody(array()) . "</html>";

?>