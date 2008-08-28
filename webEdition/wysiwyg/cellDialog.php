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

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/weCellDialog.class.inc.php");

if(isset($_REQUEST["we_dialog_args"]["vAlign"])){
	$_REQUEST["we_dialog_args"]["valign"] = $_REQUEST["we_dialog_args"]["vAlign"];
	unset($_REQUEST["we_dialog_args"]["vAlign"]);
}
if(isset($_REQUEST["we_dialog_args"]["bgColor"])){
	$_REQUEST["we_dialog_args"]["bgcolor"] = $_REQUEST["we_dialog_args"]["bgColor"];
	unset($_REQUEST["we_dialog_args"]["bgColor"]);
}

if(isset($_REQUEST["we_dialog_args"]["colSpan"])){
	$_REQUEST["we_dialog_args"]["colspan"] = $_REQUEST["we_dialog_args"]["colSpan"];
	unset($_REQUEST["we_dialog_args"]["colSpan"]);
}

$dialog = new weCellDialog();
$dialog->initByHttp();
$dialog->registerOkJsFN("weDoCellJS");
print $dialog->getHTML();

function weDoCellJS(){
	return '
eval("var editorObj = top.opener.weWysiwygObject_"+document.we_form.elements["we_dialog_args[editname]"].value);
var width = document.we_form.elements["we_dialog_args[width]"].value;
var height = document.we_form.elements["we_dialog_args[height]"].value;
var isheader = document.we_form.elements["we_dialog_args[isheader]"].value;
var id = document.we_form.elements["we_dialog_args[id]"].value;
var headers = document.we_form.elements["we_dialog_args[headers]"].value;
var scope_sel = document.we_form.elements["we_dialog_args[scope]"];
var scope = scope_sel.options[scope_sel.selectedIndex].value;
var bgcolor = document.we_form.elements["we_dialog_args[bgcolor]"].value;
var className = document.we_form.elements["we_dialog_args[class]"].value;
var align_sel = document.we_form.elements["we_dialog_args[align]"];
var align = align_sel.options[align_sel.selectedIndex].value;
var valign_sel = document.we_form.elements["we_dialog_args[valign]"];
var valign = valign_sel.options[valign_sel.selectedIndex].value;
var colspan = document.we_form.elements["we_dialog_args[colspan]"].value;
editorObj.editcell(width,height,bgcolor,align,valign,colspan,className,isheader,id,headers,scope);
top.close();
';
}
?>