<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/weSpecialCharDialog.class.inc.php");

$dialog = new weSpecialCharDialog();
$dialog->initByHttp();
$dialog->registerOkJsFN("weDoRuleJS");
print $dialog->getHTML();

function weDoRuleJS(){
	return '
eval("var editorObj = top.opener.weWysiwygObject_"+document.we_form.elements["we_dialog_args[editname]"].value);
var ch = document.we_form.elements["we_dialog_args[char]"].value;
var isSafari = (navigator.userAgent.toLowerCase().indexOf("safari") > -1);

if (isSafari) {
	ch = ch.replace(/^&/,"_xx_WE_AMP_xx_");
}

editorObj.replaceText(ch);

if (isSafari) {
	editorObj.editContainer.innerHTML = editorObj.editContainer.innerHTML.replace(/_xx_WE_AMP_xx_/,"&");
}

top.close();
';
}
?>