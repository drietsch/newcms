<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/weRuleDialog.class.inc.php");

$dialog = new weRuleDialog();
$dialog->initByHttp();
$dialog->registerOkJsFN("weDoRuleJS");
print $dialog->getHTML();

function weDoRuleJS(){
	return '
eval("var editorObj = top.opener.weWysiwygObject_"+document.we_form.elements["we_dialog_args[editname]"].value);
var width = document.we_form.elements["we_dialog_args[width]"].value;
var height = document.we_form.elements["we_dialog_args[height]"].value;
var color = document.we_form.elements["we_dialog_args[color]"].value;
var align_sel = document.we_form.elements["we_dialog_args[align]"];
var align = align_sel.options[align_sel.selectedIndex].value;
var noshade = document.we_form.elements["we_dialog_args[noshade]"].checked ? 1 : 0;
editorObj.editrule(width,height,color,align,noshade);
top.close();
';
}
?>