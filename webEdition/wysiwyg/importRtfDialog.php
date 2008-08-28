<?php

/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   we
 * @package    we_wysiwyg
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/weImportRtfDialog.class.inc.php");

$dialog = new weImportRtfDialog();
$dialog->initByHttp();
if(isset($dialog->args["ntxt"]) && $dialog->args["ntxt"]){
	$dialog->registerOkJsFN("weDoRtfJSTxt");	
}else{
	$dialog->registerOkJsFN("weDoRtfJS");
}
print $dialog->getHTML();

function weDoRtfJS(){
	return '
eval("var editorObj = top.opener.weWysiwygObject_"+document.we_form.elements["we_dialog_args[editname]"].value);
editorObj.replaceText(document.we_form.elements["we_dialog_args[htmltxt]"].value);
top.close();
';
}
function weDoRtfJSTxt(){
	return '
eval("var taObj = top.opener."+document.we_form.elements["we_dialog_args[taname]"].value+"Object");
taObj.appendText(document.we_form.elements["we_dialog_args[htmltxt]"].value);
top.close();
';
}
?>