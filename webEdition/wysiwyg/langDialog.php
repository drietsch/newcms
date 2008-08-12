<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/weLangDialog.class.inc.php");

$appendJS = "";
if(defined("GLOSSARY_TABLE") && isset($_REQUEST['weSaveToGlossary']) && $_REQUEST['weSaveToGlossary'] == 1) {
	
	include_once(WE_GLOSSARY_MODULE_DIR . "/weGlossary.php");
	include_once(WE_GLOSSARY_MODULE_DIR . "/weGlossaryCache.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/glossary.inc.php");
	
	$Glossary = new weGlossary();
	$Glossary->Language = $_REQUEST['language'];
	$Glossary->Type = "foreignword";
	$Glossary->Text = trim($_REQUEST['text']);
	$Glossary->Published = time();
	$Glossary->setAttribute('lang', $_REQUEST['we_dialog_args']['lang']);
	$Glossary->setPath();
	
	if($Glossary->Text=="" || $Glossary->getAttribute('lang')=="") {
		$appendJS = '<script type="text/javascript">' . we_message_reporting::getShowMessageCall($l_glossary['name_empty'], WE_MESSAGE_ERROR) . '</script>';
	
	} else if($Glossary->pathExists($Glossary->Path)) {
		$appendJS = '<script type="text/javascript">' . we_message_reporting::getShowMessageCall($l_glossary['name_exists'], WE_MESSAGE_ERROR) . '</script>';
		
	} else {
		$Glossary->save();
		$appendJS = '<script type="text/javascript">' . we_message_reporting::getShowMessageCall($l_glossary['entry_saved'], WE_MESSAGE_NOTICE) . 'top.close();</script>';

	}
	
}

$dialog = new weLangDialog();
$dialog->initByHttp();
$dialog->registerOkJsFN("weDoLangJS");
print $dialog->getHTML();
print $appendJS;

function weDoLangJS(){
	return '
eval("var editorObj = top.opener.weWysiwygObject_"+document.we_form.elements["we_dialog_args[editname]"].value);
var lang = document.we_form.elements["we_dialog_args[lang]"].value;
editorObj.editLang(lang);
top.close();
';
}
?>