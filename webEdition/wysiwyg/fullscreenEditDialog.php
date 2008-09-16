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