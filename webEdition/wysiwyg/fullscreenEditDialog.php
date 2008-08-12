<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/weFullscreenEditDialog.class.inc.php");

$dialog = new weFullscreenEditDialog();
$dialog->initByHttp();
$dialog->registerOkJsFN("weDoFullscreenJS");
print $dialog->getHTML();

function weDoFullscreenJS(){
	return '
if(weWysiwygSetHiddenText){
	weWysiwygSetHiddenText();
}

eval("editorObj = top.opener.weWysiwygObject_"+document.we_form.elements["we_dialog_args[editname]"].value);
var src = document.we_form.elements["we_dialog_args[src]"].value;
editorObj.setText(src);
top.close();
';
}
?>