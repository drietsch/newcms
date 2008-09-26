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
 * @package    webEdition_wysiwyg
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/weAbbrDialog.class.inc.php");

$appendJS = "";
if(defined("GLOSSARY_TABLE") && isset($_REQUEST['weSaveToGlossary']) && $_REQUEST['weSaveToGlossary'] == 1) {

	include_once(WE_GLOSSARY_MODULE_DIR . "/weGlossary.php");
	include_once(WE_GLOSSARY_MODULE_DIR . "/weGlossaryCache.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/glossary.inc.php");

	$Glossary = new weGlossary();
	$Glossary->Language = $_REQUEST['language'];
	$Glossary->Type = "abbreviation";
	$Glossary->Text = trim($_REQUEST['text']);
	$Glossary->Title = trim($_REQUEST['we_dialog_args']['title']);
	$Glossary->Published = time();
	$Glossary->setAttribute('lang', $_REQUEST['we_dialog_args']['lang']);
	$Glossary->setPath();

	if($Glossary->Title=="") {
		$appendJS = '<script type="text/javascript">' . we_message_reporting::getShowMessageCall($l_glossary['title_empty'], WE_MESSAGE_ERROR) . ';var elem = document.forms[0].elements["we_dialog_args[title]"];elem.focus();elem.select();</script>';
	} else if($Glossary->getAttribute('lang')=="") {
		$appendJS = '<script type="text/javascript">' . we_message_reporting::getShowMessageCall($l_glossary['lang_empty'], WE_MESSAGE_ERROR) . 'var elem = document.forms[0].elements["we_dialog_args[lang]"];elem.focus();elem.select();</script>';
	} else if($Glossary->Text=="") {
		$appendJS = '<script type="text/javascript">' . we_message_reporting::getShowMessageCall($l_glossary['name_empty'], WE_MESSAGE_ERROR) . '</script>';

	} else if($Glossary->pathExists($Glossary->Path)) {
		$appendJS = '<script type="text/javascript">' . we_message_reporting::getShowMessageCall($l_glossary['name_exists'], WE_MESSAGE_ERROR) . '</script>';

	} else {
		$Glossary->save();

		$Cache = new weGlossaryCache($_REQUEST['language']);
		$Cache->write();
		unset($Cache);

		$appendJS = '<script type="text/javascript">' . we_message_reporting::getShowMessageCall($l_glossary['entry_saved'], WE_MESSAGE_NOTICE) . 'top.close();</script>';

	}

}

$dialog = new weAbbrDialog();
$dialog->initByHttp();
$dialog->registerOkJsFN("weDoAbbrJS");
print $dialog->getHTML();
print $appendJS;

function weDoAbbrJS(){
	return '
eval("var editorObj = top.opener.weWysiwygObject_"+document.we_form.elements["we_dialog_args[editname]"].value);
var title = document.we_form.elements["we_dialog_args[title]"].value;
var lang = document.we_form.elements["we_dialog_args[lang]"].value;
editorObj.editAbbr(title,lang);
top.close();
';
}
?>