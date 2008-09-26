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

include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once ($_SERVER['DOCUMENT_ROOT'] . "/webEdition/we/include/we_classes/html/we_multibox.inc.php");
include_once ($_SERVER['DOCUMENT_ROOT'] . "/webEdition/we/include/we_classes/html/we_htmlSelect.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/cockpit.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_widgets/dlg/prefs.inc.php");

$parts = array();
$jsCode = "
function init(){
	_fo=document.forms[0];
	initPrefs();
}

function save(){
	savePrefs();
	previewPrefs();
	" . we_message_reporting::getShowMessageCall(
		$l_cockpit['prefs_saved_successfully'], 
		WE_MESSAGE_NOTICE) . "
	self.close();
}

function preview(){ previewPrefs(); }

function exit_close(){
	previewPrefs();
	exitPrefs();
	self.close();
}
";

$we_button = new we_button();
array_push($parts, array(
	"headline" => "", "html" => $oSelCls->getHTMLCode(), "space" => 0
));

$save_button = $we_button->create_button("save", "javascript:save();", false, -1, -1);
$preview_button = $we_button->create_button("preview", "javascript:preview();", false, -1, -1);
$cancel_button = $we_button->create_button("close", "javascript:exit_close();");
$buttons = $we_button->position_yes_no_cancel($save_button, $preview_button, $cancel_button);

$sTblWidget = we_multiIconBox::getHTML("rssProps", "100%", $parts, 30, $buttons, -1, "", "", "", $l_cockpit['messaging']);

print 
		we_htmlElement::htmlHtml(
				we_htmlElement::htmlHead(
						we_htmlElement::htmlTitle($l_cockpit['messaging']) . STYLESHEET . we_htmlElement::jsElement(
								"", 
								array(
									"src" => JS_DIR . "we_showMessage.js"
								)) . we_htmlElement::jsElement(
								$jsPrefs . $jsCode . $we_button->create_state_changer(false))) . we_htmlElement::htmlBody(
						array(
							"class" => "weDialogBody", "onload" => "init();"
						), 
						we_htmlElement::htmlForm("", $sTblWidget)));

?>
