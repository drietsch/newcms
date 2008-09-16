<?php

/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_wysiwyg
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/weAcronymDialog.class.inc.php");

$appendJS = "";
if(defined("GLOSSARY_TABLE") && isset($_REQUEST['weSaveToGlossary']) && $_REQUEST['weSaveToGlossary'] == 1) {

	include_once(WE_GLOSSARY_MODULE_DIR . "/weGlossary.php");
	include_once(WE_GLOSSARY_MODULE_DIR . "/weGlossaryCache.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/glossary.inc.php");

	$Glossary = new weGlossary();
	$Glossary->Language = $_REQUEST['language'];
	$Glossary->Type = "acronym";
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

$dialog = new weAcronymDialog();
$dialog->initByHttp();
$dialog->registerOkJsFN("weDoAcronymJS");
print $dialog->getHTML();
print $appendJS;

function weDoAcronymJS(){
	return '
eval("var editorObj = top.opener.weWysiwygObject_"+document.we_form.elements["we_dialog_args[editname]"].value);
var title = document.we_form.elements["we_dialog_args[title]"].value;
var lang = document.we_form.elements["we_dialog_args[lang]"].value;
editorObj.editAcronym(title,lang);
top.close();
';
}
?>