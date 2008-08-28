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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/weColorDialog.class.inc.php");

$dialog = new weColorDialog();
$dialog->initByHttp();
$dialog->registerOkJsFN("weDoColorJS");
print $dialog->getHTML();

function weDoColorJS(){


	return '
var type = document.we_form.elements["we_dialog_args[type]"].value;
var color = document.we_form.elements["we_dialog_args[color]"].value;
var editorObj;
var name;
 
if(type == "forecolor" || type == "backcolor"){
	eval("editorObj = top.opener.weWysiwygObject_"+document.we_form.elements["we_dialog_args[editname]"].value);
}else{
	name = document.we_form.elements["we_dialog_args[name]"].value;
}
switch(type){
	case "forecolor":
		editorObj.setForecolor(color);
		break;
	case "backcolor":
		editorObj.setBackcolor(color);
		break;
	case "dialog":
		var inp = top.opener.document.we_form.elements[name];
		inp.value = color;
		inp.style.backgroundColor = color;
		break;
}
top.close();
';

}
?>